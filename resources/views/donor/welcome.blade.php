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
                <span class="fs-semibold text-muted">Track your Donation activity here.</span>
            </div>
            <div class="btn-list mt-md-0 mt-2">
                {{-- <button type="button" class="btn btn-primary btn-wave">
                    <i class="ri-filter-3-fill me-2 align-middle d-inline-block"></i>Filters
                </button>
                <button type="button" class="btn btn-outline-secondary btn-wave">
                    <i class="ri-upload-cloud-line me-2 align-middle d-inline-block"></i>Export
                </button> --}}
            </div>
        </div>

        <!-- End::page-header -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
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
                                    <div id="donorChart"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <div>
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
            <div class="col-lg-3 col-md-6">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-top justify-content-between">
                            <div>
                                <span class="avatar avatar-md avatar-rounded bg-success">
                                    <i class="bx bxs-church side-menu__icon"></i>
                                </span>
                            </div>
                            <div class="flex-fill ms-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="text-muted mb-0">{{ __('Total Churches') }}</p>
                                        <h4 class="fw-semibold mt-1">{{ $totalDonations['this_month'] }}
                                        </h4>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-1" style="height: 50px">
                                    <div>
                                    </div>
                                    <div class="text-end">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
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
                                    <div id="total-donations"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <div>
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
            <div class="col-lg-3">
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
                            {{-- <div class="col-xxl-12 col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Recent Activity
                                        </div>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="p-2 fs-12 text-muted"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                View All<i
                                                    class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <ul class="list-unstyled mb-0 crm-recent-activity">
                                                <li class="crm-recent-activity-content">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span
                                                                class="avatar avatar-xs bg-primary-transparent avatar-rounded">
                                                                <i class="bi bi-circle-fill fs-8"></i>
                                                            </span>
                                                        </div>
                                                        <div class="crm-timeline-content">
                                                            <span class="fw-semibold">Update of calendar events
                                                                &amp;</span><span><a href="javascript:void(0);"
                                                                    class="text-primary fw-semibold"> Added new events in
                                                                    next week.</a></span>
                                                        </div>
                                                        <div class="flex-fill text-end">
                                                            <span class="d-block text-muted fs-11 op-7">4:45PM</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="crm-recent-activity-content">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span
                                                                class="avatar avatar-xs bg-secondary-transparent avatar-rounded">
                                                                <i class="bi bi-circle-fill fs-8"></i>
                                                            </span>
                                                        </div>
                                                        <div class="crm-timeline-content">
                                                            <span>New theme for <span class="fw-semibold">Spruko
                                                                    Website</span> completed</span>
                                                            <span class="d-block fs-12 text-muted">Lorem ipsum, dolor sit
                                                                amet.</span>
                                                        </div>
                                                        <div class="flex-fill text-end">
                                                            <span class="d-block text-muted fs-11 op-7">3 hrs</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="crm-recent-activity-content">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span
                                                                class="avatar avatar-xs bg-success-transparent avatar-rounded">
                                                                <i class="bi bi-circle-fill fs-8"></i>
                                                            </span>
                                                        </div>
                                                        <div class="crm-timeline-content">
                                                            <span>Created a <span class="text-success fw-semibold">New
                                                                    Task</span> today <span
                                                                    class="avatar avatar-xs bg-purple-transparent avatar-rounded ms-1"><i
                                                                        class="ri-add-fill text-purple fs-12"></i></span></span>
                                                        </div>
                                                        <div class="flex-fill text-end">
                                                            <span class="d-block text-muted fs-11 op-7">22 hrs</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="crm-recent-activity-content">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span
                                                                class="avatar avatar-xs bg-pink-transparent avatar-rounded">
                                                                <i class="bi bi-circle-fill fs-8"></i>
                                                            </span>
                                                        </div>
                                                        <div class="crm-timeline-content">
                                                            <span>New member <span
                                                                    class="badge bg-pink-transparent">@andreas
                                                                    gurrero</span> added today to AI Summit.</span>
                                                        </div>
                                                        <div class="flex-fill text-end">
                                                            <span class="d-block text-muted fs-11 op-7">Today</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="crm-recent-activity-content">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span
                                                                class="avatar avatar-xs bg-warning-transparent avatar-rounded">
                                                                <i class="bi bi-circle-fill fs-8"></i>
                                                            </span>
                                                        </div>
                                                        <div class="crm-timeline-content">
                                                            <span>32 New people joined summit.</span>
                                                        </div>
                                                        <div class="flex-fill text-end">
                                                            <span class="d-block text-muted fs-11 op-7">22 hrs</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="crm-recent-activity-content">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span
                                                                class="avatar avatar-xs bg-info-transparent avatar-rounded">
                                                                <i class="bi bi-circle-fill fs-8"></i>
                                                            </span>
                                                        </div>
                                                        <div class="crm-timeline-content">
                                                            <span>Neon Tarly added <span
                                                                    class="text-info fw-semibold">Robert Bright</span> to
                                                                AI summit project.</span>
                                                        </div>
                                                        <div class="flex-fill text-end">
                                                            <span class="d-block text-muted fs-11 op-7">12 hrs</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="crm-recent-activity-content">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span
                                                                class="avatar avatar-xs bg-dark-transparent avatar-rounded">
                                                                <i class="bi bi-circle-fill fs-8"></i>
                                                            </span>
                                                        </div>
                                                        <div class="crm-timeline-content">
                                                            <span>Replied to new support request <i
                                                                    class="ri-checkbox-circle-line text-success fs-16 align-middle"></i></span>
                                                        </div>
                                                        <div class="flex-fill text-end">
                                                            <span class="d-block text-muted fs-11 op-7">4 hrs</span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="crm-recent-activity-content">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span
                                                                class="avatar avatar-xs bg-purple-transparent avatar-rounded">
                                                                <i class="bi bi-circle-fill fs-8"></i>
                                                            </span>
                                                        </div>
                                                        <div class="crm-timeline-content">
                                                            <span>Completed documentation of <a href="javascript:void(0);"
                                                                    class="text-purple text-decoration-underline fw-semibold">AI
                                                                    Summit.</a></span>
                                                        </div>
                                                        <div class="flex-fill text-end">
                                                            <span class="d-block text-muted fs-11 op-7">4 hrs</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-xl-9">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Expense Vs Budget') }}
                        </div>
                        <div>
                            <select class="form-select" id="church_id">
                                <option selected disabled>Select a Church</option>
                                @foreach ($churches as $index => $church)
                                    <option value="{{ $church->id }}" {{ $index === 0 ? 'selected' : '' }}>
                                        {{ $church->name }}
                                    </option>
                                @endforeach
                            </select>
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
                            Deals Status
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="p-2 fs-12 text-muted" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                View All<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="fw-bold mb-0">4,289</h4>
                            <div class="ms-2">
                                <span class="badge bg-success-transparent">1.02<i
                                        class="ri-arrow-up-s-fill align-mmiddle ms-1"></i></span>
                                <span class="text-muted ms-1">compared to last week</span>
                            </div>
                        </div>
                        <div class="progress-stacked progress-animate progress-xs mb-4">
                            <div class="progress-bar" role="progressbar" style="width: 21%" aria-valuenow="21"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-info" role="progressbar" style="width: 26%" aria-valuenow="26"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 35%"
                                aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: 18%"
                                aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <ul class="list-unstyled mb-0 pt-2 crm-deals-status">
                            <li class="primary">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>Successful Deals</div>
                                    <div class="fs-12 text-muted">987 deals</div>
                                </div>
                            </li>
                            <li class="info">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>Pending Deals</div>
                                    <div class="fs-12 text-muted">1,073 deals</div>
                                </div>
                            </li>
                            <li class="warning">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>Rejected Deals</div>
                                    <div class="fs-12 text-muted">1,674 deals</div>
                                </div>
                            </li>
                            <li class="success">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>Upcoming Deals</div>
                                    <div class="fs-12 text-muted">921 deals</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- End::row-1 -->

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

    <!-- CRM-Dashboard -->
    @vite('resources/assets/js/crm-dashboard.js')
@endsection
