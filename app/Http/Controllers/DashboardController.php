<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Elastic\Elasticsearch\Client;

class DashboardController extends Controller
{
    public function index(Request $request, Client $client)
    {
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
            'trafficChart' => $this->trafficChart($client, $request),
            'topCountries' => $this->getTopCountriesByRequests($client),
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

    private function trafficChart(Client $client, Request $request): array
    {
        $request->validate([
            'range' => ['nullable', 'in:1,2,3,7'],
            'from'  => ['nullable', 'date'],
            'to'    => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $tz = config('app.timezone');

        if ($request->filled('from') && $request->filled('to')) {
            $start = Carbon::parse($request->input('from'), $tz)->startOfDay();
            $end   = Carbon::parse($request->input('to'), $tz)->endOfDay();
            $end   = $end->isFuture() ? now() : $end;
        } else {
            $start = now()->subDays((int) $request->input('range', 3))->startOfHour();
            $end   = now();
        }

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
                    'per_hour' => [
                        'date_histogram' => [
                            'field'           => 'timestamp',
                            'fixed_interval'  => '1h',
                            'time_zone'       => $tz,
                            'min_doc_count'   => 0,
                            'extended_bounds' => [
                                'min' => $start->getTimestamp() * 1000,
                                'max' => $end->getTimestamp() * 1000,
                            ],
                        ],
                        'aggs' => [
                            'visits' => ['sum' => ['field' => 'visits']],
                        ],
                    ],
                ],
            ],
        ]);

        $buckets = collect($response->asArray()['aggregations']['per_hour']['buckets']);

        return [
            'trafficCategories' => $buckets
                ->map(fn ($b) => Carbon::createFromTimestampMs($b['key'], $tz)->format('d M, H:00'))
                ->values(),
            'trafficVisits' => $buckets
                ->map(fn ($b) => $b['doc_count'] > 0 ? (int) $b['visits']['value'] : null)
                ->values(),
            'trafficHasData' => $buckets->sum('doc_count') > 0,
            'trafficPeriod' => $start->format('d M Y').' - '.$end->format('d M Y'),
        ];
    }
    private function getTopCountriesByRequests(Client $client, int $limit = 3): array
    {
        $response = $client->search([
            'index' => config('elasticsearch.country_index'),
            'body'  => [
                'size' => 0,
                'aggs' => [
                    'top_countries' => [
                        'terms' => [
                            'field' => 'country',
                            'size'  => $limit,
                            'order' => ['total_requests' => 'desc'],
                        ],
                        'aggs' => [
                            'peak_requests' => ['max' => ['field' => 'requests']],
                            'total_requests' => ['sum' => ['field' => 'requests']],
                        ],
                    ],
                ],
            ],
        ]);

        $buckets = $response['aggregations']['top_countries']['buckets'] ?? [];

        return [
            'categories' => array_column($buckets, 'key'),
            'data'       => array_map(
                fn ($b) => (int) $b['peak_requests']['value'],
                $buckets
            ),
        ];
    }
}