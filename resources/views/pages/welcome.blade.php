@extends('layouts.master')

@section('styles')
    <style>
        #donorChart .apexcharts-grid line,
        #donorChart .apexcharts-xaxis line,
        #donorChart .apexcharts-yaxis line,
        #donorChart .apexcharts-grid-borders line {
            display: none !important;
        }

        #total-revenue .apexcharts-grid line,
        #total-revenue .apexcharts-xaxis line,
        #total-revenue .apexcharts-yaxis line,
        #total-revenue .apexcharts-grid-borders line {
            display: none !important;
        }

        #total-donations .apexcharts-grid line,
        #total-donations .apexcharts-xaxis line,
        #total-donations .apexcharts-yaxis line,
        #total-donations .apexcharts-grid-borders line {
            display: none !important;
        }

        #all-users .apexcharts-grid line,
        #all-users .apexcharts-xaxis line,
        #all-users .apexcharts-yaxis line,
        #all-users .apexcharts-grid-borders line {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Start::page-header -->

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <p class="fw-semibold fs-18 mb-0">Welcome back,
                    {{ Auth::user()->name }} !
                </p>
                <span class="fs-semibold text-muted">Track your sales activity, leads and deals here.</span>
            </div>
            <div class="btn-list mt-md-0 mt-2">
            </div>
        </div>

        <!-- End::page-header -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xxl-9 col-xl-12">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="row">
                        </div>
                        <div class="col-xl-12">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">Top Donors</div>
                                    <div class="dropdown">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled crm-top-deals mb-0" id="donorsList">
                                        <!-- Top Donors will appear here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <span class="avatar avatar-md avatar-rounded bg-primary">
                                                    <i class="ti ti-users fs-16"></i>
                                                </span>
                                            </div>
                                            <div class="flex-fill ms-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div>
                                                        <p class="text-muted mb-0">{{ __('Total Donors') }}</p>
                                                        <h4 class="fw-semibold">{{ $alldonars['this_month'] }}
                                                        </h4>
                                                    </div>
                                                    {{-- <div id="donorChart"></div> --}}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mt-1">
                                                    <div>
                                                        <a class="text-primary"
                                                            href="{{ route('doners.index') }}">{{ __('View                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               All') }}<i
                                                                class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                                    </div>
                                                    <div class="text-end">
                                                        @if (str_starts_with($alldonars['percentage_change'], '+'))
                                                            <p class="mb-0 fw-semibold text-success">
                                                                {{ $alldonars['percentage_change'] }}
                                                            </p>
                                                        @elseif(str_starts_with($alldonars['percentage_change'], '-'))
                                                            <p class="mb-0 fw-semibold text-danger">
                                                                {{ $alldonars['percentage_change'] }}
                                                            </p>
                                                        @else
                                                            <p class="mb-0 fw-semibold text-muted">
                                                                {{ $alldonars['percentage_change'] }}
                                                            </p>
                                                        @endif
                                                        <p class="text-muted op-7 fs-11">{{ __('this month') }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <span class="avatar avatar-md avatar-rounded bg-secondary">
                                                    <i class="ti ti-wallet fs-16"></i>
                                                </span>
                                            </div>
                                            <div class="flex-fill ms-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div>
                                                        <p class="text-muted mb-0">{{ __('Total Revenue') }}</p>
                                                        <h4 class="fw-semibold mt-1">${{ $totalRevenue['this_month'] }}
                                                        </h4>
                                                    </div>
                                                    {{-- <div id="total-revenue"></div> --}}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mt-1">
                                                    <div>
                                                        <a class="text-secondary"
                                                            href="{{ route('invoice.index') }}">{{ __('View All') }}<i
                                                                class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                                    </div>
                                                    <div class="text-end">
                                                        @if (str_starts_with($totalRevenue['percentage_change'], '+'))
                                                            <p class="mb-0 fw-semibold text-success">
                                                                {{ $totalRevenue['percentage_change'] }}
                                                            </p>
                                                        @elseif(str_starts_with($totalRevenue['percentage_change'], '-'))
                                                            <p class="mb-0 fw-semibold text-danger">
                                                                {{ $totalRevenue['percentage_change'] }}
                                                            </p>
                                                        @else
                                                            <p class="mb-0 fw-semibold text-muted">
                                                                {{ $totalRevenue['percentage_change'] }}
                                                            </p>
                                                        @endif
                                                        <p class="text-muted op-7 fs-11">{{ __('this month') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <span class="avatar avatar-md avatar-rounded bg-success">
                                                    <i class="ti ti-users fs-16"></i>
                                                </span>
                                            </div>
                                            <div class="flex-fill ms-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div>
                                                        <p class="text-muted mb-0">{{ __('Total Users') }}</p>
                                                        <h4 class="fw-semibold">{{ $allUsers['this_month'] }}
                                                        </h4>
                                                    </div>
                                                    {{-- <div id="all-users"></div> --}}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mt-1">
                                                    <div>
                                                        <a class="text-success"
                                                            href="{{ route('adminuser.index') }}">{{ __('View                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               All') }}<i
                                                                class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                                    </div>
                                                    <div class="text-end">
                                                        @if (str_starts_with($allUsers['percentage_change'], '+'))
                                                            <p class="mb-0 fw-semibold text-success">
                                                                {{ $allUsers['percentage_change'] }}
                                                            </p>
                                                        @elseif(str_starts_with($allUsers['percentage_change'], '-'))
                                                            <p class="mb-0 fw-semibold text-danger">
                                                                {{ $allUsers['percentage_change'] }}
                                                            </p>
                                                        @else
                                                            <p class="mb-0 fw-semibold text-muted">
                                                                {{ $allUsers['percentage_change'] }}
                                                            </p>
                                                        @endif
                                                        <p class="text-muted op-7 fs-11">{{ __('this month') }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 col-md-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-body">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <span class="avatar avatar-md avatar-rounded bg-warning">
                                                    <i class="ri-hand-coin-line"></i>
                                                </span>
                                            </div>
                                            <div class="flex-fill ms-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div>
                                                        <p class="text-muted mb-0">{{ __('Total Donations') }}</p>
                                                        <h4 class="fw-semibold mt-1">{{ $totalDonations['this_month'] }}
                                                        </h4>
                                                    </div>
                                                    {{-- <div id="total-donations"></div> --}}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mt-1">
                                                    <div>
                                                        <a class="text-warning"
                                                            href="{{ route('invoice.index') }}">{{ __('View All') }}<i
                                                                class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                                    </div>
                                                    <div class="text-end">
                                                        @if (str_starts_with($totalDonations['percentage_change'], '+'))
                                                            <p class="mb-0 fw-semibold text-success">
                                                                {{ $totalDonations['percentage_change'] }}
                                                            </p>
                                                        @elseif(str_starts_with($totalDonations['percentage_change'], '-'))
                                                            <p class="mb-0 fw-semibold text-danger">
                                                                {{ $totalDonations['percentage_change'] }}
                                                            </p>
                                                        @else
                                                            <p class="mb-0 fw-semibold text-muted">
                                                                {{ $totalDonations['percentage_change'] }}
                                                            </p>
                                                        @endif
                                                        <p class="text-muted op-7 fs-11">{{ __('this month') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-12">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Leads By Products
                                        </div>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-sm btn-light" data-bs-toggle="dropdown">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Week</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Month</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Year</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 overflow-hidden">
                                        <div class="leads-source-chart d-flex align-items-center justify-content-center">
                                            <canvas id="top-products-chart" class="chartjs-chart w-100 p-4"></canvas>
                                            <div class="lead-source-value">
                                                <span class="d-block fs-14">{{ __('Total Donataion Items') }}</span>
                                                <span class="d-block fs-25 fw-bold">{{ 1 }}</span>
                                            </div>
                                        </div>
                                        <div class="row row-cols-12 border-top border-block-start-dashed">
                                            @if (isset($topProducts['topProducts'][0]))
                                                <div class="col p-0">
                                                    <div
                                                        class="ps-4 py-3 pe-3 text-center border-end border-inline-end-dashed">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend mobile d-inline-block">{{ $topProducts['topProducts'][0]->product->name ?? '' }}
                                                        </span>
                                                        <div><span
                                                                class="fs-16 fw-semibold">{{ $topProducts['topProducts'][0]['total_count'] ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (isset($topProducts['topProducts'][1]))
                                                <div class="col p-0">
                                                    <div class="p-3 text-center border-end border-inline-end-dashed">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend desktop d-inline-block">{{ $topProducts['topProducts'][1]->product->name ?? '' }}
                                                        </span>
                                                        <div><span
                                                                class="fs-16 fw-semibold">{{ $topProducts['topProducts'][1]['total_count'] ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (isset($topProducts['topProducts'][2]))
                                                <div class="col p-0">
                                                    <div class="p-3 text-center border-end border-inline-end-dashed">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend laptop d-inline-block">{{ $topProducts['topProducts'][2]->product->name ?? '' }}
                                                        </span>
                                                        <div><span
                                                                class="fs-16 fw-semibold">{{ $topProducts['topProducts'][2]['total_count'] ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (isset($topProducts['topProducts'][3]))
                                                <div class="col p-0">
                                                    <div class="p-3 text-center">
                                                        <span
                                                            class="text-muted fs-12 mb-1 crm-lead-legend tablet d-inline-block">Tabl{{ $topProducts['topProducts'][3]->product->name ?? '' }}et
                                                        </span>
                                                        <div><span
                                                                class="fs-16 fw-semibold">{{ $topProducts['topProducts'][3]['total_count'] ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-9">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Expense Vs Budget') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content-wrapper">
                            <div id="crm-expense-analytics"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Product And Services') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold mb-2">${{ number_format($allProductFive['totalAmount'], 0) }}</h4>
                        <div class="progress-stacked progress-animate progress-xs mb-4">
                            @foreach ($allProductFive['topProducts'] as $index => $product)
                                @php
                                    $percentage =
                                        $allProductFive['totalAmount'] > 0
                                            ? round(
                                                ($product['total_amount'] / $allProductFive['totalAmount']) * 100,
                                                2,
                                            )
                                            : 0;
                                    $colors = ['primary', 'info', 'warning', 'success', 'danger'];
                                @endphp
                                <div class="progress-bar bg-{{ $colors[$index] }}" role="progressbar"
                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            @endforeach
                        </div>

                        <ul class="list-unstyled mb-0 pt-2 crm-deals-status">
                            @foreach ($allProductFive['topProducts'] as $index => $product)
                                @php $colors = ['primary', 'info', 'warning', 'success', 'danger']; @endphp
                                <li class="{{ $colors[$index] }}">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>{{ $product['name'] }}</div>
                                        <div class="fs-12 text-muted">${{ number_format($product['total_amount'], 2) }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            </div>
        </div>
        <!-- End::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Monthly Revenue') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content-wrapper">
                            <div id="crm-revenue-month"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Total Donations') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content-wrapper">
                            <div id="donation-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <!-- JSVECTOR MAPS JS -->
    <script src="{{ asset('build/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('build/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!-- APEX CHARTS JS -->
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- CHARTJS CHART JS -->
    <script src="{{ asset('build/assets/libs/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/anaylitics.js') }}"></script>

    <!-- CRM-Dashboard -->
    @vite('resources/assets/js/crm-dashboard.js')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var donorOptions = {
                chart: {
                    type: "line",
                    height: 30,
                    width: 100,
                    sparkline: {
                        enabled: !0
                    }, // Enable sparkline mode (no axis)
                },

                stroke: {
                    show: !0,
                    curve: "smooth",
                    lineCap: "butt",
                    colors: void 0,
                    width: 1.5,
                    dashArray: 0,
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.9,
                        opacityTo: 0.9,
                        stops: [0, 98]
                    },
                },
                series: [{
                    name: "Donors",
                    data: [{{ $alldonars['last_month'] }}, {{ $alldonars['this_month'] }}]
                }],
                yaxis: {
                    min: 0,
                    show: !0,
                    axisBorder: {
                        show: !0
                    }
                },
                xaxis: {
                    show: !0,
                    axisBorder: {
                        show: !0
                    }
                },
                tooltip: {
                    enabled: !1
                },
                colors: [
                    "{{ str_starts_with($alldonars['percentage_change'], '+') ? 'green' : (str_starts_with($alldonars['percentage_change'], '-') ? 'red' : 'gray') }}"
                ],
            };

            new ApexCharts(document.querySelector("#donorChart"), donorOptions).render();

            var revenueOptions = {
                chart: {
                    type: "line",
                    height: 30,
                    width: 100,
                    sparkline: {
                        enabled: !0
                    }, // Enable sparkline mode (no axis)
                },

                stroke: {
                    show: !0,
                    curve: "smooth",
                    lineCap: "butt",
                    colors: void 0,
                    width: 1.5,
                    dashArray: 0,
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.9,
                        opacityTo: 0.9,
                        stops: [0, 98]
                    },
                },
                series: [{
                    name: "Donors",
                    data: [{{ $totalRevenue['last_month'] }}, {{ $totalRevenue['this_month'] }}]
                }],
                yaxis: {
                    min: 0,
                    show: !0,
                    axisBorder: {
                        show: !0
                    }
                },
                xaxis: {
                    show: !0,
                    axisBorder: {
                        show: !0
                    }
                },
                tooltip: {
                    enabled: !1
                },
                colors: [
                    "{{ str_starts_with($totalRevenue['percentage_change'], '+') ? 'green' : (str_starts_with($totalRevenue['percentage_change'], '-') ? 'red' : 'gray') }}"
                ],
            };

            new ApexCharts(document.querySelector("#total-revenue"), revenueOptions).render();

            var donationOptions = {
                chart: {
                    type: "line",
                    height: 30,
                    width: 100,
                    sparkline: {
                        enabled: !0
                    }, // Enable sparkline mode (no axis)
                },

                stroke: {
                    show: !0,
                    curve: "smooth",
                    lineCap: "butt",
                    colors: void 0,
                    width: 1.5,
                    dashArray: 0,
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.9,
                        opacityTo: 0.9,
                        stops: [0, 98]
                    },
                },
                series: [{
                    name: "Donors",
                    data: [{{ $totalDonations['last_month'] }}, {{ $totalDonations['this_month'] }}]
                }],
                yaxis: {
                    min: 0,
                    show: !0,
                    axisBorder: {
                        show: !0
                    }
                },
                xaxis: {
                    show: !0,
                    axisBorder: {
                        show: !0
                    }
                },
                tooltip: {
                    enabled: !1
                },
                colors: [
                    "{{ str_starts_with($totalDonations['percentage_change'], '+') ? 'green' : (str_starts_with($totalDonations['percentage_change'], '-') ? 'red' : 'gray') }}"
                ],
            };

            new ApexCharts(document.querySelector("#total-donations"), donationOptions).render();

            var usersOptions = {
                chart: {
                    type: "line",
                    height: 30,
                    width: 100,
                    sparkline: {
                        enabled: !0
                    }, // Enable sparkline mode (no axis)
                },

                stroke: {
                    show: !0,
                    curve: "smooth",
                    lineCap: "butt",
                    colors: void 0,
                    width: 1.5,
                    dashArray: 0,
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.9,
                        opacityTo: 0.9,
                        stops: [0, 98]
                    },
                },
                series: [{
                    name: "Donors",
                    data: [{{ $allUsers['last_month'] }}, {{ $allUsers['this_month'] }}]
                }],
                yaxis: {
                    min: 0,
                    show: !0,
                    axisBorder: {
                        show: !0
                    }
                },
                xaxis: {
                    show: !0,
                    axisBorder: {
                        show: !0
                    }
                },
                tooltip: {
                    enabled: !1
                },
                colors: [
                    "{{ str_starts_with($allUsers['percentage_change'], '+') ? 'green' : (str_starts_with($allUsers['percentage_change'], '-') ? 'red' : 'gray') }}"
                ],
            };

            new ApexCharts(document.querySelector("#all-users"), usersOptions).render();

            const topProducts = @json($topProducts['topProducts']);

            const productLabels = topProducts.map(item => item.product.name);
            const productCounts = topProducts.map(item => item.total_count);
            const backgroundColors = [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(75, 192, 192)',
                'rgb(153, 102, 255)'
            ];

            new Chart(document.getElementById("top-products-chart"), {
                type: 'doughnut',
                data: {
                    // labels: productLabels,
                    datasets: [{
                        label: 'Top Products',
                        data: productCounts,
                        backgroundColor: backgroundColors
                    }]
                },
                options: {
                    cutout: '90%', // Adjust this to make arcs thinner (higher value = thinner arc)
                },
                plugins: [{
                    afterUpdate: function(chart) {
                        const arcs = chart.getDatasetMeta(0).data;

                        arcs.forEach(function(arc) {
                            arc.round = {
                                x: (chart.chartArea.left + chart.chartArea.right) /
                                    2,
                                y: (chart.chartArea.top + chart.chartArea.bottom) /
                                    2,
                                radius: (arc.outerRadius + arc.innerRadius) / 2,
                                thickness: (arc.outerRadius - arc.innerRadius) / 4,
                                backgroundColor: arc.options.backgroundColor
                            }
                        });
                    },
                    afterDraw: (chart) => {
                        const {
                            ctx,
                            canvas
                        } = chart;

                        chart.getDatasetMeta(0).data.forEach(arc => {
                            const startAngle = Math.PI / 2 - arc.startAngle;
                            const endAngle = Math.PI / 2 - arc.endAngle;

                            ctx.save();
                            ctx.translate(arc.round.x, arc.round.y);
                            ctx.fillStyle = arc.options.backgroundColor;
                            ctx.beginPath();
                            ctx.arc(arc.round.radius * Math.sin(endAngle), arc.round
                                .radius * Math.cos(endAngle), arc.round.thickness,
                                0, 2 * Math.PI);
                            ctx.closePath();
                            ctx.fill();
                            ctx.restore();
                        });
                    }
                }]
            });
        });
    </script>
@endsection
