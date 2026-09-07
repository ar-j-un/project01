<aside id="sidebar" class="u-sidebar">
    <div class="u-sidebar-inner">
        <header class="u-sidebar-header">
            <a class="u-sidebar-logo" href="{{ url('/') }}">
                <img class="u-sidebar-logo__icon" src="{{ asset('vendor/awesome-dashboard/svg/logo-mini.svg') }}" alt="Awesome Icon">
                <img class="u-sidebar-logo__text" src="{{ asset('vendor/awesome-dashboard/svg/logo-text-light.svg') }}" alt="Awesome">
            </a>
        </header>

        <nav class="u-sidebar-nav">
            <ul class="u-sidebar-nav-menu u-sidebar-nav-menu--top-level">
                <li class="u-sidebar-nav-menu__item">
                    <a class="u-sidebar-nav-menu__link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ url('/') }}">
                        <span class="ti-dashboard u-sidebar-nav-menu__item-icon"></span>
                        <span class="u-sidebar-nav-menu__item-title">Dashboard</span>
                    </a>
                </li>
                <li class="u-sidebar-nav-menu__divider"></li>
                <li class="u-sidebar-nav-menu__item">
                    <a class="u-sidebar-nav-menu__link" href="#" data-target="#menuItemAccountPages">
                        <span class="ti-layers-alt u-sidebar-nav-menu__item-icon"></span>
                        <span class="u-sidebar-nav-menu__item-title">Account Pages</span>
                        <span class="ti-angle-down u-sidebar-nav-menu__item-arrow"></span>
                    </a>
                    <ul id="menuItemAccountPages" class="u-sidebar-nav-menu u-sidebar-nav-menu--second-level" style="display: none;">
                        <li class="u-sidebar-nav-menu__item">
                            <a class="u-sidebar-nav-menu__link" href="{{ url('/account/profile') }}">
                                <span class="u-sidebar-nav-menu__item-icon">P</span>
                                <span class="u-sidebar-nav-menu__item-title">Profile</span>
                            </a>
                        </li>
                        <li class="u-sidebar-nav-menu__item">
                            <a class="u-sidebar-nav-menu__link" href="{{ Route::has('register') ? route('register') : url('/register') }}">
                                <span class="u-sidebar-nav-menu__item-icon">S</span>
                                <span class="u-sidebar-nav-menu__item-title">Sign Up</span>
                            </a>
                        </li>
                        <li class="u-sidebar-nav-menu__item">
                            <a class="u-sidebar-nav-menu__link" href="{{ Route::has('login') ? route('login') : url('/login') }}">
                                <span class="u-sidebar-nav-menu__item-icon">S</span>
                                <span class="u-sidebar-nav-menu__item-title">Sign In</span>
                            </a>
                        </li>
                        <li class="u-sidebar-nav-menu__item">
                            <a class="u-sidebar-nav-menu__link" href="{{ url('/password/recover') }}">
                                <span class="u-sidebar-nav-menu__item-icon">R</span>
                                <span class="u-sidebar-nav-menu__item-title">Recover Password</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>