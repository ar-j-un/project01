<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <title>{{ $title ?? 'Sign In' }} | {{ config('app.name', 'Prophaze Dashboard') }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ asset('vendor/awesome-dashboard/favicon.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/awesome-dashboard/vendor/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/awesome-dashboard/css/theme.css') }}">

    @stack('styles')
</head>
<body>

    <main class="d-flex flex-column u-hero u-hero--end mnh-100vh" style="background-image: url({{ asset('vendor/awesome-dashboard/img-temp/bg/bg-1.png') }});">
        <div class="container py-11 my-auto">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-5 offset-lg-1 mb-4 mb-md-0">

                    <div class="card">
                        <div class="card-body p-4 p-lg-7">
                            {{ $slot }}
                        </div>
                    </div>

                </div>

                <div class="col-md-6 col-lg-5 offset-lg-1">
                    <h2 class="h1">Improve your business<br class="d-none d-md-block"> and&nbsp;site security</h2>
                    <p class="font-weight-semi-bold text-primary mb-5">More than 30,000 clients</p>

                    <ul class="list-unstyled mb-11">
                        <li class="mb-4">
                            <div class="media align-items-center">
                                <div class="u-icon u-icon-sm rounded-circle bg-white text-primary mr-3">
                                    <span class="ti-lock"></span>
                                </div>
                                <div class="media-body">
                                    <p class="text-dark mb-0">Businesses nowadays need a firewall</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4">
                            <div class="media align-items-center">
                                <div class="u-icon u-icon-sm rounded-circle bg-white text-primary mr-3">
                                    <span class="ti-briefcase"></span>
                                </div>
                                <div class="media-body">
                                    <p class="text-dark mb-0">Protect against threats from hackers</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-4">
                            <div class="media align-items-center">
                                <div class="u-icon u-icon-sm rounded-circle bg-white text-primary mr-3">
                                    <span class="ti-cup"></span>
                                </div>
                                <div class="media-body">
                                    <p class="text-dark mb-0">Once your website is live, it's time to introduce security</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </main>

    <script src="{{ asset('vendor/awesome-dashboard/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/vendor/jquery-migrate/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/awesome-dashboard/js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>