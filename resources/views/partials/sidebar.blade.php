<aside id="sidebar" class="u-sidebar">
    <div class="u-sidebar-inner">
        <header class="u-sidebar-header">
            <a class="u-sidebar-logo" href="{{ url('/') }}">
                <img class="u-sidebar-logo__icon" src="{{ asset('vendor/awesome-dashboard/svg/logo-mini.svg') }}"
                    alt="Awesome Icon">
                <img class="u-sidebar-logo__text" src="{{ asset('vendor/awesome-dashboard/svg/logo-text-light.svg') }}"
                    alt="Awesome">
            </a>
        </header>

        <nav class="u-sidebar-nav">
            <ul class="u-sidebar-nav-menu u-sidebar-nav-menu--top-level">
                @auth
                    <!-- Dashboard -->
                    <li class="u-sidebar-nav-menu__item">
                        <a class="u-sidebar-nav-menu__link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <span class="ti-dashboard u-sidebar-nav-menu__item-icon"></span>
                            <span class="u-sidebar-nav-menu__item-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="u-sidebar-nav-menu__item">
                        <a class="u-sidebar-nav-menu__link {{ request()->routeIs('documents.*') ? 'active' : '' }}"
                            href="{{ route('documents.index') }}">
                            <span class="ti-files u-sidebar-nav-menu__item-icon"></span>
                            <span class="u-sidebar-nav-menu__item-title">My Documents</span>
                        </a>
                    </li>

                    <li class="u-sidebar-nav-menu__divider"></li>

                    <!-- Account -->
                    <li class="u-sidebar-nav-menu__item">
                        <a class="u-sidebar-nav-menu__link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                            href="{{ route('profile.edit') }}">
                            <span class="ti-user u-sidebar-nav-menu__item-icon"></span>
                            <span class="u-sidebar-nav-menu__item-title">Profile</span>
                        </a>
                    </li>

                    <li class="u-sidebar-nav-menu__item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="u-sidebar-nav-menu__link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <span class="ti-power-off u-sidebar-nav-menu__item-icon"></span>
                                <span class="u-sidebar-nav-menu__item-title">Sign Out</span>
                            </a>
                        </form>
                    </li>
                @else
                    <!-- Guest -->
                    <li class="u-sidebar-nav-menu__item">
                        <a class="u-sidebar-nav-menu__link {{ request()->routeIs('login') ? 'active' : '' }}"
                            href="{{ route('login') }}">
                            <span class="ti-lock u-sidebar-nav-menu__item-icon"></span>
                            <span class="u-sidebar-nav-menu__item-title">Sign In</span>
                        </a>
                    </li>
                    <li class="u-sidebar-nav-menu__item">
                        <a class="u-sidebar-nav-menu__link {{ request()->routeIs('register') ? 'active' : '' }}"
                            href="{{ route('register') }}">
                            <span class="ti-user u-sidebar-nav-menu__item-icon"></span>
                            <span class="u-sidebar-nav-menu__item-title">Sign Up</span>
                        </a>
                    </li>
                    <li class="u-sidebar-nav-menu__item">
                        <a class="u-sidebar-nav-menu__link {{ request()->routeIs('password.request') ? 'active' : '' }}"
                            href="{{ route('password.request') }}">
                            <span class="ti-key u-sidebar-nav-menu__item-icon"></span>
                            <span class="u-sidebar-nav-menu__item-title">Recover Password</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
    </div>
</aside>