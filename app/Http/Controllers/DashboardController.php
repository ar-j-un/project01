<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeRangeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Elastic\Elasticsearch\Client;

class DashboardController extends Controller
{
    public function index(TimeRangeRequest $request, Client $client)
    {
        [$rangeStart, $rangeEnd] = $request->period();

        $tz    = config('app.timezone');
        $start = now()->startOfYear();
        $end   = now()->endOfYear();

        $response = $client->search([
            'index' => config('elasticsearch.sales_index'),
            'body'  => [
                'size'  => 0,
                'query' => [
                    'range' => [
                        'created_at' => [
                            'gte' => $start->toIso8601String(),
                            'lte' => $end->toIso8601String(),
                        ],
                    ],
                ],
                'aggs' => [
                    'by_month' => [
                        'date_histogram' => [
                            'field'             => 'created_at',
                            'calendar_interval' => 'month',
                            'time_zone'         => $tz,
                            'min_doc_count'     => 0,
                            'extended_bounds'   => [
                                'min' => $start->getTimestamp() * 1000,
                                'max' => $end->getTimestamp() * 1000,
                            ],
                        ],
                        'aggs' => [
                            'revenue' => ['sum' => ['field' => 'revenue']],
                            'cost'  => ['sum' => ['field' => 'cost']],
                        ],
                    ],
                ],
            ],
        ]);

        $buckets = collect($response->asArray()['aggregations']['by_month']['buckets']);

        return view('dashboard', [
            'categories' => $buckets->map(fn ($b) => Carbon::createFromTimestampMs($b['key'], $tz)->format('M Y'))->values(),
            'revenue'    => $buckets->map(fn ($b) => (float) $b['revenue']['value'])->values(),
            'profit' => $buckets->map(fn ($b) => round($b['revenue']['value'] - $b['cost']['value'], 2))->values(),
            'trafficChart' => $this->trafficChart($client, $rangeStart, $rangeEnd),
            'topCountries' => $this->getTopRequests($client, 'country_index', 'country', $rangeStart, $rangeEnd),
            'topIps' => $this->getTopRequests($client, 'ip_index', 'ip', $rangeStart, $rangeEnd),
            'stats' => $this->getStatCards($client, $rangeStart, $rangeEnd),
            'filters'      => $request->filters(),
            'overall'     => 75,
            'performance' => [['name' => 'Total Sales',    'y' => 65], ['name' => 'New Customers',  'y' => 35], ['name' => 'Conversion',     'y' => 15]],
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    private function trafficChart(Client $client, Carbon $start, Carbon $end): array
    {
        $tz = config('app.timezone');
        $hourly = $start->diffInHours($end) <= 72;

        $response = $client->search([
            'index' => config('elasticsearch.traffic_index'),
            'body'  => [
                'size'  => 0,
                'query' => [
                    'range' => [
                        'timestamp' => [
                            'gte' => $start->toIso8601String(),
                            'lte' => $end->toIso8601String(),
                        ],
                    ],
                ],
                'aggs' => [
                    'per_bucket' => [
                        'date_histogram' => array_merge(
                            [
                                'field'           => 'timestamp',
                                'time_zone'       => $tz,
                                'min_doc_count'   => 0,
                                'extended_bounds' => [
                                    'min' => $start->getTimestamp() * 1000,
                                    'max' => $end->getTimestamp() * 1000,
                                ],
                            ],
                            $hourly ? ['fixed_interval' => '1h'] : ['calendar_interval' => 'day']
                        ),
                        'aggs' => [
                            'visits' => ['sum' => ['field' => 'visits']],
                        ],
                    ],
                ],
            ],
        ]);

        $buckets = collect($response->asArray()['aggregations']['per_bucket']['buckets']);
        $format  = $hourly ? 'd M, H:00' : 'd M';

        return [
            'trafficCategories' => $buckets
                ->map(fn ($b) => Carbon::createFromTimestampMs($b['key'], $tz)->format($format))
                ->values(),
            'trafficVisits' => $buckets
                ->map(fn ($b) => $b['doc_count'] > 0 ? (int) $b['visits']['value'] : null)
                ->values(),
            'trafficHasData' => $buckets->sum('doc_count') > 0,
            'trafficPeriod' => $start->format('d M Y').' - '.$end->format('d M Y'),
        ];
    }
    private function getTopRequests(Client $client, string $indexKey, string $field, Carbon $start, Carbon $end, int $limit = 3): array
    {
        $response = $client->search([
            'index' => config("elasticsearch.{$indexKey}"),
            'body'  => [
                'size' => 0,
                'query' => [
                    'range' => [
                        'timestamp' => [
                            'gte' => $start->toIso8601String(),
                            'lte' => $end->toIso8601String(),
                        ],
                    ],
                ],
                'aggs' => [
                    'top_items' => [
                        'terms' => [
                            'field' => $field,
                            'size'  => $limit,
                            'order' => [['peak_requests' => 'desc'], ['_key' => 'asc']],
                        ],
                        'aggs' => [
                            'peak_requests' => ['max' => ['field' => 'requests']],
                            'total_requests' => ['sum' => ['field' => 'requests']],
                        ],
                    ],
                ],
            ],
        ]);

        $buckets = $response['aggregations']['top_items']['buckets'] ?? [];

        return [
            'categories' => array_column($buckets, 'key'),
            'data'       => array_map(fn ($b) => (int) $b['peak_requests']['value'],$buckets),
        ];
    }

    private function getStatCards(Client $client, Carbon $start, Carbon $end): array
    {
        $empty = [
            'total_requests'    => 0,
            'security_events'   => 0,
            'attacks_blocked'   => 0,
            'events_monitored'  => 0,
            'rules_triggered'   => 0,
        ];

        try {
            $response = $client->search([
                'index' => config('elasticsearch.security_events_es_index'),
                'body'  => [
                    'size'             => 0,
                    'track_total_hits' => true,
                    'query' => [
                        'range' => [
                            'timestamp' => [
                                'gte' => $start->toIso8601String(),
                                'lte' => $end->toIso8601String(),
                            ],
                        ],
                    ],
                    'aggs'             => [
                        'security_events'  => ['filter' => ['term' => ['security_event' => true]]],
                        'attacks_blocked'  => ['filter' => ['term' => ['action' => 'blocked']]],
                        'events_monitored' => ['filter' => ['term' => ['action' => 'monitored']]],
                        'rules_triggered'  => ['cardinality' => ['field' => 'rule_id']],
                    ],
                ],
            ]);

            $data = is_array($response) ? $response : $response->asArray();
            $aggs = $data['aggregations'];

            return [
                'total_requests'   => $data['hits']['total']['value'],
                'security_events'  => $aggs['security_events']['doc_count'],
                'attacks_blocked'  => $aggs['attacks_blocked']['doc_count'],
                'events_monitored' => $aggs['events_monitored']['doc_count'],
                'rules_triggered'  => $aggs['rules_triggered']['value'],
            ];
        } catch (\Throwable $err) {
            report($err);
            return $empty;
        }
    }
}