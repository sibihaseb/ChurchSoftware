<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ url('index') }}" class="header-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                class="desktop-dark">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-dark.png') }}" alt="logo"
                class="toggle-dark">
            <img src="{{ asset('build/assets/images/brand-logos/desktop-white.png') }}" alt="logo"
                class="desktop-white">
            <img src="{{ asset('build/assets/images/brand-logos/toggle-white.png') }}" alt="logo"
                class="toggle-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">{{ __('Main') }}</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                {{-- <li class="slide">
                    <a href="{{ url('admin/adminuser') }}" class="side-menu__item">
                        <i class="bx bx-layer side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('User Management') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                    </a>
                </li> --}}
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('ANALATICS') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">{{ __('Dashboards') }}ANALATICS</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('index') }}" class="side-menu__item">{{ __('View Analytics') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('index') }}" class="side-menu__item">{{ __('Analytics Report') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-fingerprint side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('USER Management') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">{{ __('Dashboards') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('admin/adminuser') }}" class="side-menu__item">{{ __('Admin Users') }}</a>
                        </li>
                        <li class="slide">

                        </li>
                        <li class="slide">
                            <a href="{{ url('admin/roletable') }}"
                                class="side-menu__item">{{ __('View All Roles') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('admin/createrole') }}"
                                class="side-menu__item">{{ __('Create Role') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bxs-church side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('Church Management') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">{{ __('Dashboards') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('admin/church') }}" class="side-menu__item">{{ __('All Churches') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('admin/dashboard/languages') }}"
                                class="side-menu__item {{ request()->is('dashboard/languages*', 'dashboard/languages/create') ? 'active' : '' }}">{{ __('Dashboard Languages') }}</a>
                        </li>
                        <li class="slide">

                        </li>

                    </ul>
                </li>
                <!-- End::slide -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('invoice.index') }}" class="side-menu__item">
                        <i class="bx bx-layer side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('Donor') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                    </a>
                </li>
                <!-- End::slide -->

                {{-- <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ url('admin/projects') }}" class="side-menu__item">
                        <i class="bx bx-layer side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('Projects') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                    </a>
                </li>
                <!-- End::slide --> --}}

                <!-- Start::slide -->
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
