@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-sm-6 col-xl-3 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center py-2">
                        <div class="media-body">
                            <h5 class="h5 text-muted mb-2">Total Budget</h5>
                            <span class="h2 font-weight-normal mb-0">$162,400</span>
                        </div>
                        <div class="text-right ml-2" style="max-width: 70px;">
                            <div class="mb-2">
                                <canvas class="js-area-chart-small" width="100" height="20"
                                        data-extend='[{"data": [20, 0, 40, 40, 100, 60, 100, 90, 80], "borderColor": "#444bf8"}]'></canvas>
                            </div>
                            <span class="text-success">+5.2% <span class="ti-arrow-up"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center py-2">
                        <div class="media-body">
                            <h5 class="h5 text-muted mb-2">Total sales</h5>
                            <span class="h2 font-weight-normal mb-0">$48,800</span>
                        </div>
                        <div class="text-right ml-2" style="max-width: 70px;">
                            <div class="mb-2">
                                <canvas class="js-area-chart-small" width="100" height="20"
                                        data-extend='[{"data": [90, 80, 100, 40, 40, 0, 20, 10, 30], "borderColor": "#2cd2f6"}]'></canvas>
                            </div>
                            <span class="text-success">+9.0% <span class="ti-arrow-up"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center py-2">
                        <div class="media-body">
                            <h5 class="h5 text-muted mb-2">New clients</h5>
                            <span class="h2 font-weight-normal mb-0">484</span>
                        </div>
                        <div class="text-right ml-2" style="max-width: 70px;">
                            <div class="mb-2">
                                <canvas class="js-area-chart-small" width="100" height="20"
                                        data-extend='[{"data": [80, 100, 50, 50, 0, 60, 60, 100, 80], "borderColor": "#f12559"}]'></canvas>
                            </div>
                            <span class="text-danger">-4.2% <span class="ti-arrow-down"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center py-2">
                        <div class="media-body">
                            <h5 class="h5 text-muted mb-2">Total Income</h5>
                            <span class="h2 font-weight-normal mb-0">$36,900</span>
                        </div>
                        <div class="text-right ml-2" style="max-width: 70px;">
                            <div class="mb-2">
                                <canvas class="js-area-chart-small" width="100" height="20"
                                        data-extend='[{"data": [80, 100, 50, 50, 0, 60, 60, 100, 80], "borderColor": "#f1be25"}]'></canvas>
                            </div>
                            <span class="text-success">+6.2% <span class="ti-arrow-up"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-5">
            <div class="card h-100">
                <header class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="h4 card-header-title">Revenue</h2>
                </header>
                <div class="card-body pt-0">
                    <ul class="list-inline mb-4">
                        <li class="list-inline-item d-inline-flex align-items-center mr-4">
                            <span class="u-indicator u-indicator-xxs position-static bg-primary border-0 mr-2"></span>Revenue
                        </li>
                        <li class="list-inline-item d-inline-flex align-items-center mr-4">
                            <span class="u-indicator u-indicator-xxs position-static bg-success border-0 mr-2"></span>Profit
                        </li>
                    </ul>
                    <div class="mx-n3" style="height: 340px;">
                        <canvas class="js-area-chart" width="100" height="320"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <div class="card h-100">
                <header class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="h4 card-header-title">Performance</h2>
                </header>
                <div class="card-body">
                    <div class="mx-auto mb-6" style="max-width: 240px; max-height: 240px;">
                        <canvas class="js-doughnut-chart" width="240" height="240"></canvas>
                    </div>
                    <ul class="list-inline d-flex align-items-center justify-content-center text-center mb-0">
                        <li class="list-inline-item px-5 mr-0">
                            <div class="h2 font-weight-normal text-primary mb-1">45%</div>
                            <div class="text-muted">Total Sales</div>
                        </li>
                        <li class="list-inline-item px-5 mr-0">
                            <div class="h2 font-weight-normal text-info mb-1">15%</div>
                            <div class="text-muted">New Customers</div>
                        </li>
                        <li class="list-inline-item px-5 mr-0">
                            <div class="h2 font-weight-normal text-success mb-1">15%</div>
                            <div class="text-muted">Conversion</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-5 mb-md-0">
            <div class="card h-100">
                <header class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="h4 card-header-title">Active Tasks</h2>
                </header>
                <div class="card-body py-0">
                    <div class="list-group list-group-flush">
                        @foreach ([
                            ['icon' => 'ti-dribbble', 'bg' => 'bg-danger', 'title' => 'Direct Mail Advertising How', 'due' => '05 Sep 2018', 'checked' => false],
                            ['icon' => 'ti-twitter-alt', 'bg' => 'bg-info', 'title' => 'Advertising On A Budget Part 3', 'due' => '30 Jun 2018', 'checked' => true],
                            ['icon' => 'ti-soundcloud', 'bg' => 'bg-success', 'title' => 'Why Join An Affiliate Network', 'due' => '02 Dec 2018', 'checked' => true],
                        ] as $i => $task)
                            <div class="list-group-item border-0 px-0">
                                <div class="media align-items-center">
                                    <span class="custom-control custom-checkbox custom-checkbox-bordered custom-checkbox-empty mr-4">
                                        <input id="task{{ $i }}" class="custom-control-input" type="checkbox" @checked($task['checked'])>
                                        <label class="custom-control-label" for="task{{ $i }}"></label>
                                    </span>
                                    <div class="u-icon rounded-circle {{ $task['bg'] }} text-white mr-3">
                                        <span class="{{ $task['icon'] }}"></span>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="font-weight-normal mb-0">{{ $task['title'] }}</h4>
                                        <small class="text-muted">Due to: <span class="font-weight-semi-bold">{{ $task['due'] }}</span></small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <footer class="card-footer border-0">
                    <a class="font-weight-semi-bold" href="#">All tasks</a>
                </footer>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <header class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="h4 card-header-title">Recent Activity</h2>
                    <span class="text-muted">25 updates</span>
                </header>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="card-table">
                            <thead>
                                <tr class="small">
                                    <th class="font-weight-normal text-muted pb-3">Name</th>
                                    <th class="font-weight-normal text-muted pb-3">Type</th>
                                    <th class="font-weight-normal text-muted pb-3">Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ([
                                    ['icon' => 'ti-dropbox', 'bg' => 'bg-primary', 'name' => 'Dropbox', 'time' => '1 hour ago', 'type' => 'Preapproved payment', 'net' => '-7.99 EUR'],
                                    ['icon' => 'ti-github', 'bg' => 'bg-secondary', 'name' => 'Github', 'time' => '2 hours ago', 'type' => 'Refund', 'net' => '+8.99 EUR'],
                                    ['icon' => 'ti-trello', 'bg' => 'bg-danger', 'name' => 'Trello', 'time' => '15 minutes ago', 'type' => 'Payment', 'net' => '-14.5 EUR'],
                                    ['icon' => 'ti-twitter', 'bg' => 'bg-info', 'name' => 'Twitter', 'time' => '30 minutes ago', 'type' => 'Approved payment', 'net' => '-4.99 EUR'],
                                ] as $activity)
                                    <tr>
                                        <td class="py-3">
                                            <div class="media align-items-center">
                                                <div class="u-icon rounded-circle {{ $activity['bg'] }} text-white mr-3">
                                                    <span class="{{ $activity['icon'] }}"></span>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="font-weight-normal mb-0">{{ $activity['name'] }}</h4>
                                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">{{ $activity['type'] }}</td>
                                        <td class="py-3">{{ $activity['net'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <footer class="card-footer border-0">
                    <a class="font-weight-semi-bold" href="#">All activities</a>
                </footer>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/awesome-dashboard/js/charts/area-chart.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/js/charts/area-chart-small.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/js/charts/doughnut-chart.js') }}"></script>
@endpush