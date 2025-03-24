<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ url('/') }}" class="header-logo text-white" style="font-size: 1rem">
            {{-- <img src="{{ asset('images/chruchlogo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('images/chruchlogo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('images/chruchlogo.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('images/chruchlogo.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('images/chruchlogo.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('images/chruchlogo.png') }}" alt="logo" class="toggle-white"> --}}
            {{ env('APP_NAME') }}
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
                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ url('admin/home') }}" class="side-menu__item">
                        <i class="bx bx-layer side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('Dashboard') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                    </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('invoice.index') }}" class="side-menu__item">
                        <i class="bx bx-donate-heart side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('Donors') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                    </a>
                </li>
                <!-- End::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-fingerprint side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('User Setting') }}<span
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
                        <span class="side-menu__label">{{ __('Church Setting') }}<span
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
                            <a href="{{ url('admin/country') }}" class="side-menu__item {{ request()->is('country*') ? 'active' : '' }}">{{ __('Countries') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('admin/us-states') }}" class="side-menu__item {{ request()->is('country*') ? 'active' : '' }}">{{ __('US States') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-cog side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('Account Setting') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">{{ __('Dashboards') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('admin/deposite-account') }}"
                                class="side-menu__item">{{ __('Deposite Account') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('admin/payment-method') }}"
                                class="side-menu__item">{{ __('Payment Method') }}</a>
                        </li>
                        <li class="slide">

                        </li>

                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-store side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('Product Setting') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">{{ __('Dashboards') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('admin/product') }}" class="side-menu__item">{{ __('All Products') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('admin/tag') }}" class="side-menu__item">{{ __('All Tags') }}</a>
                        </li>
                        <li class="slide">

                        </li>

                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="bx bx-group side-menu__icon"></i>
                        <span class="side-menu__label">{{ __('Donor Setting') }}<span
                                class="badge bg-warning-transparent ms-2"></span></span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">{{ __('Dashboards') }}</a>
                        </li>

                        <li class="slide">
                            <a href="{{ url('admin/family-member-type') }}"
                                class="side-menu__item">{{ __('Family Donor Type') }}</a>
                        </li>
                        <li class="slide">
                            <a href="{{ url('admin/member-type') }}"
                                class="side-menu__item">{{ __('Donor Type') }}</a>
                        </li>
                        <li class="slide">
                            <a href="#" class="side-menu__item">{{ __('Donors') }}</a>
                        </li>
                </li>

            </ul>
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
