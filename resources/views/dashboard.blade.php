<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="row">
        <div class="col-sm-6 col-xl-2 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center py-2">
                        <div class="media-body">
                            <h5 class="h5 text-muted mb-2">TOTAL REQUESTS</h5>
                            <span
                                class="h2 font-weight-normal mb-0">{{ number_format($stats['total_requests']) }}</span>
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
                            <h5 class="h5 text-muted mb-2">TOTAL SECURITY EVENTS</h5>
                            <span
                                class="h2 font-weight-normal mb-0">{{ number_format($stats['security_events']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-2 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center py-2">
                        <div class="media-body">
                            <h5 class="h5 text-muted mb-2">ATTACKS BLOCKED</h5>
                            <span
                                class="h2 font-weight-normal mb-0">{{ number_format($stats['attacks_blocked']) }}</span>
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
                            <h5 class="h5 text-muted mb-2">EVENTS MONITORED</h5>
                            <span
                                class="h2 font-weight-normal mb-0">{{ number_format($stats['events_monitored']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center py-2">
                        <div class="media-body">
                            <h5 class="h5 text-muted mb-2">RULES TRIGGERED</h5>
                            <span
                                class="h2 font-weight-normal mb-0">{{ number_format($stats['rules_triggered']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="traffic-chart" style="width:100%; height:400px;"></div>

    <div class="col-sm-12 col-xl-6 mb-5 mt-4">
        <div class="position-relative">
            <div id="top-sources-toggle" class="btn-group btn-group-sm position-absolute"
                style="top: 10px; right: 10px; z-index: 2;" role="group">
                <button type="button" class="btn btn-primary" data-view="countries">Country</button>
                <button type="button" class="btn btn-outline-primary" data-view="ips">IP Address</button>
            </div>
            <div id="top-sources-chart" style="width:100%; height:400px;"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-5">
            <div class="card h-100">
                <header class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="h4 card-header-title">Revenue</h2>
                </header>
                <div class="card-body pt-0" id="revenue-profit-chart"></div>
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <div class="card h-100">
                <header class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="h4 card-header-title">Performance</h2>
                </header>
                <div class="card-body" id="performance-chart">
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
                                    <span
                                        class="custom-control custom-checkbox custom-checkbox-bordered custom-checkbox-empty mr-4">
                                        <input id="task{{ $i }}" class="custom-control-input" type="checkbox"
                                            @checked($task['checked'])>
                                        <label class="custom-control-label" for="task{{ $i }}"></label>
                                    </span>
                                    <div class="u-icon rounded-circle {{ $task['bg'] }} text-white mr-3">
                                        <span class="{{ $task['icon'] }}"></span>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="font-weight-normal mb-0">{{ $task['title'] }}</h4>
                                        <small class="text-muted">Due to: <span
                                                class="font-weight-semi-bold">{{ $task['due'] }}</span></small>
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
    @push('scripts')
        <script>
            Highcharts.chart('revenue-profit-chart', {
                chart: { type: 'column' },
                title: { text: 'Revenue vs Profit by Month' },
                xAxis: { categories: @json($categories) },
                yAxis: { title: { text: 'Amount' } },
                tooltip: { shared: true, valueDecimals: 2 },
                plotOptions: {
                    column: { borderRadius: 3 }
                },
                series: [
                    { name: 'Revenue', data: @json($revenue) },
                    { name: 'Profit', data: @json($profit) }
                ]
            });
            Highcharts.chart('traffic-chart', {
                chart: { type: 'line' },
                title: { text: 'TRAFFIC TREND' },
                subtitle: { text: @json($trafficChart['trafficPeriod']) },
                xAxis: {
                    title: { text: 'Date Time' },
                    categories: @json($trafficChart['trafficCategories']),
                    tickInterval: 1,
                    labels: {
                        step: 1,
                        rotation: -45,
                        autoRotation: false,
                        allowOverlap: true,
                        style: { fontSize: '10px' },
                        formatter: function () {
                            const [date, time] = this.axis.categories[this.pos].split(', ');
                            const previous = this.pos > 0
                                ? this.axis.categories[this.pos - 1].split(', ')[0]
                                : null;

                            return date !== previous ? `${date}, ${time}` : time;
                        },
                    },
                },
                yAxis: {
                    title: { text: 'Count' },
                    min: 0,
                    tickInterval: 2,
                },
                series: [{ name: 'Count', data: @json($trafficChart['trafficVisits']) }],
            });
            Highcharts.chart('performance-chart', {
                chart: { type: 'pie' },
                title: {
                    text: '{{ $overall }}%<br>of target',
                    align: 'center',
                    verticalAlign: 'middle',
                    y: 0
                },
                legend: { enabled: false },
                tooltip: {
                    pointFormat: '<span style="color:{point.color}">●</span> {point.name}<br/><b>{point.display}</b> ({point.y}% of target)'
                },
                plotOptions: {
                    pie: {
                        innerSize: '75%',
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}<br>{point.display}'
                        }
                    }
                },
                series: [{
                    name: 'Performance',
                    data: @json($performance)
                }]
            });
            const topSourceViews = {
                countries: {
                    axisTitle: 'Country',
                    categories: @json($topCountries['categories']),
                    data: @json($topCountries['data']),
                },
                ips: {
                    axisTitle: 'IP Address',
                    categories: @json($topIps['categories']),
                    data: @json($topIps['data']),
                },
            };
            const topSourcesChart = Highcharts.chart('top-sources-chart', {
                chart: { type: 'bar' },
                title: { text: 'TOP REQUEST SOURCES', align: 'left' },
                xAxis: {
                    categories: topSourceViews.countries.categories.slice(),
                    title: { text: topSourceViews.countries.axisTitle }
                },
                yAxis: { min: 0, allowDecimals: false, title: { text: 'Count' } },
                tooltip: { valueSuffix: ' counts' },
                legend: { enabled: false },
                credits: { enabled: false },
                plotOptions: {
                    bar: {
                        borderRadius: { radius: 12, scope: 'point', where: 'end' }
                    }
                },
                series: [{ name: 'Count', data: topSourceViews.countries.data.slice() }]
            });
            document.querySelectorAll('#top-sources-toggle button').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const view = topSourceViews[btn.dataset.view];

                    topSourcesChart.xAxis[0].update({
                        categories: view.categories.slice(),
                        title: { text: view.axisTitle }
                    }, false);
                    topSourcesChart.series[0].setData(view.data.slice(), false);
                    topSourcesChart.redraw();

                    document.querySelectorAll('#top-sources-toggle button').forEach((b) => {
                        b.classList.toggle('btn-primary', b === btn);
                        b.classList.toggle('btn-outline-primary', b !== btn);
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>