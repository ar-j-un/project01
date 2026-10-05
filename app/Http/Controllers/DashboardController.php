<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Elastic\Elasticsearch\Client;

class DashboardController extends Controller
{
    public function index(Client $client)
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
}
