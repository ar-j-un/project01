<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <title>{{ $title ?? 'Dashboard' }} | {{ config('app.name', 'Prophaze Dashboard') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('vendor/awesome-dashboard/favicon.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/awesome-dashboard/vendor/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/awesome-dashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/awesome-dashboard/css/theme.css') }}">
    @stack('styles')
</head>

<body>
    @include('partials.topbar')
    <main class="u-main">
        @include('partials.sidebar')
        <div class="u-content">
            <div class="u-body">
                @isset($header)
                    <div class="mb-5">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
            </div>
            @include('partials.footer')
        </div>
    </main>
    @stack('modals')
    <script src="{{ asset('vendor/awesome-dashboard/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/vendor/jquery-migrate/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script
        src="{{ asset('vendor/awesome-dashboard/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script
        src="{{ asset('vendor/awesome-dashboard/vendor/chartjs-plugin-style/dist/chartjs-plugin-style.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/js/sidebar-nav.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>