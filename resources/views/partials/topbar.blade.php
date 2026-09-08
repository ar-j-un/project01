<header class="u-header">
    <div class="u-header-left">
        <a class="u-header-logo" href="{{ url('/') }}">
            <img class="u-header-logo__icon" src="{{ asset('vendor/awesome-dashboard/svg/logo-prophaze.svg') }}" alt="Awesome Icon">
        </a>
    </div>

    <div class="u-header-middle">
        <div class="u-header-section">
            <a class="js-sidebar-invoker u-header-invoker u-sidebar-invoker" href="#"
               data-is-close-all-except-this="true"
               data-target="#sidebar">
                <span class="ti-align-left u-header-invoker__icon u-sidebar-invoker__icon--open"></span>
                <span class="ti-align-justify u-header-invoker__icon u-sidebar-invoker__icon--close"></span>
            </a>
        </div>

        <div class="u-header-section justify-content-sm-start flex-grow-1 py-0">
            <div class="u-header-search"
                 data-search-mobile-invoker="#headerSearchMobileInvoker"
                 data-search-target="#headerSearch">
                <a id="headerSearchMobileInvoker" class="u-header-search__mobile-invoker align-items-center" href="#">
                    <span class="ti-search"></span>
                </a>
                <div id="headerSearch" class="u-header-search-form">
                    <form action="/" class="w-100">
                        <div class="input-group h-100">
                            <button class="btn-link input-group-prepend u-header-search__btn" type="submit">
                                <span class="ti-search"></span>
                            </button>
                            <input class="form-control u-header-search__field" type="search" placeholder="Type to search…">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="u-header-section u-header-section--profile">
            @auth
                <div class="u-header-dropdown dropdown">
                    <a class="link-muted d-flex align-items-center" href="#" role="button" id="userProfileInvoker" aria-haspopup="true" aria-expanded="false"
                       data-toggle="dropdown"
                       data-offset="0">
                        <img class="u-header-avatar img-fluid rounded-circle mr-md-3" src="{{ asset('vendor/awesome-dashboard/img-temp/avatars/img1.jpg') }}" alt="User Profile">
                        <span class="text-dark d-none d-md-inline-flex align-items-center">
                            {{ auth()->user()->name }}
                            <span class="ti-angle-down text-muted ml-4"></span>
                        </span>
                    </a>

                    <div class="u-header-dropdown__menu dropdown-menu dropdown-menu-right" aria-labelledby="userProfileInvoker" style="width: 260px;">
                        <div class="card p-3">
                            <div class="card-body p-0">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3"><a class="link-dark" href="{{ route('profile.edit') }}">View Profile</a></li>
                                    <li class="mb-3"><a class="link-dark" href="{{ route('profile.edit') }}">Settings</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="link-dark btn btn-link p-0 border-0">Sign Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <a class="text-dark font-weight-semi-bold mr-3" href="{{ route('login') }}">Sign In</a>
                <a class="btn btn-primary btn-sm text-uppercase" href="{{ route('register') }}">Sign Up</a>
            @endauth
        </div>
    </div>
</header>