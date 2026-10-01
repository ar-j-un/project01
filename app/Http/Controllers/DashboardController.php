<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $rows = DB::table('sales')
            ->selectRaw("
                DATE_FORMAT(created_at, '%Y-%m') as ym,
                DATE_FORMAT(created_at, '%b %Y') as label,
                SUM(revenue) as revenue,
                SUM(revenue - cost) as profit
            ")
            ->whereYear('created_at', now()->year)
            ->groupBy('ym', 'label')
            ->orderBy('ym')
            ->get();

        return view('dashboard', [
            'categories' => $rows->pluck('label'),
            'revenue'    => $rows->pluck('revenue')->map(fn ($v) => (float) $v)->values(),
            'profit'     => $rows->pluck('profit')->map(fn ($v) => (float) $v)->values(),
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
