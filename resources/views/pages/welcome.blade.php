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
            <div class="col-xxl-9 col-xl-12">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="row">
                            {{-- <div class="col-xl-12">
                                <div class="card custom-card crm-highlight-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="fw-semibold fs-18 text-fixed-white mb-2">Your target is
                                                    incomplete</div>
                                                <span class="d-block fs-12 text-fixed-white"><span class="op-7">You have
                                                        completed</span> <span class="fw-semibold text-warning">48%</span>
                                                    <span class="op-7">of the given target, you can also check your
                                                        status</span>.</span>
                                                <span class="d-block fw-semibold mt-1"><a class="text-fixed-white"
                                                        href="javascript:void(0);"><u>Click here</u></a></span>
                                            </div>
                                            <div>
                                                <div id="crm-main"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-xl-12">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">Top Donors</div>
                                    <div class="dropdown">
                                        <select class="form-select" id="churchSelect">
                                            <option selected disabled>Select a Church</option>
                                            @foreach ($churches as $church)
                                                <option value="{{ $church->id }}">{{ $church->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled crm-top-deals mb-0" id="donorsList">
                                        <!-- Top Donors will appear here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">Profit Earned</div>
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
                                <div class="card-body py-0 ps-0">
                                    <div id="crm-profits-earned"></div>
                                </div>
                            </div>
                        </div> --}}
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
                                                    <div id="donorChart"></div>
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
                                                    <div id="total-revenue"></div>
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
                                                    <div id="all-users"></div>
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
                                                    <div id="total-donations"></div>
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
                    {{-- <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Deals Statistics
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <div>
                                        <input class="form-control form-control-sm" type="text"
                                            placeholder="Search Here" aria-label=".form-control-sm example">
                                    </div>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary btn-sm btn-wave waves-effect waves-light"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Sort By<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">New</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Popular</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Relevant</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-hover border table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="row" class="ps-4"><input class="form-check-input"
                                                        type="checkbox" id="checkboxNoLabel1" value=""
                                                        aria-label="..."></th>
                                                <th scope="col">Sales Rep</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Mail</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="ps-4"><input class="form-check-input"
                                                        type="checkbox" id="checkboxNoLabel2" value=""
                                                        aria-label="..."></th>
                                                <td>
                                                    <div class="d-flex align-items-center fw-semibold">
                                                        <span class="avatar avatar-sm me-2 avatar-rounded">
                                                            <img src="{{ asset('build/assets/images/faces/4.jpg') }}"
                                                                alt="img">
                                                        </span>Mayor Kelly
                                                    </div>
                                                </td>
                                                <td>Manufacture</td>
                                                <td>mayorkelly@gmail.com</td>
                                                <td>
                                                    <span class="badge bg-info-transparent">Germany</span>
                                                </td>
                                                <td>Sep 15 - Oct 12, 2023</td>
                                                <td>
                                                    <div class="hstack gap-2 fs-15">
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon btn-wave waves-effect waves-light btn-sm btn-success-light"><i
                                                                class="ri-download-2-line"></i></a>
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon btn-wave waves-effect waves-light btn-sm btn-primary-light"><i
                                                                class="ri-edit-line"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="ps-4"><input class="form-check-input"
                                                        type="checkbox" id="checkboxNoLabel13" value=""
                                                        aria-label="..." checked></th>
                                                <td>
                                                    <div class="d-flex align-items-center fw-semibold">
                                                        <span class="avatar avatar-sm me-2 avatar-rounded">
                                                            <img src="{{ asset('build/assets/images/faces/15.jpg') }}"
                                                                alt="img">
                                                        </span>Andrew Garfield
                                                    </div>
                                                </td>
                                                <td>Development</td>
                                                <td>andrewgarfield@gmail.com</td>
                                                <td>
                                                    <span class="badge bg-primary-transparent">Canada</span>
                                                </td>
                                                <td>Apr 10 - Dec 12, 2023</td>
                                                <td>
                                                    <div class="hstack gap-2 fs-15">
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon waves-effect waves-light btn-sm btn-success-light"><i
                                                                class="ri-download-2-line"></i></a>
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon waves-effect waves-light btn-sm btn-primary-light"><i
                                                                class="ri-edit-line"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="ps-4"><input class="form-check-input"
                                                        type="checkbox" id="checkboxNoLabel4" value=""
                                                        aria-label="..."></th>
                                                <td>
                                                    <div class="d-flex align-items-center fw-semibold">
                                                        <span class="avatar avatar-sm me-2 avatar-rounded">
                                                            <img src="{{ asset('build/assets/images/faces/11.jpg') }}"
                                                                alt="img">
                                                        </span>Simon Cowel
                                                    </div>
                                                </td>
                                                <td>Service</td>
                                                <td>simoncowel234@gmail.com</td>
                                                <td>
                                                    <span class="badge bg-danger-transparent">Europe</span>
                                                </td>
                                                <td>Sep 15 - Oct 12, 2023</td>
                                                <td>
                                                    <div class="hstack gap-2 fs-15">
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon waves-effect waves-light btn-sm btn-success-light"><i
                                                                class="ri-download-2-line"></i></a>
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon waves-effect waves-light btn-sm btn-primary-light"><i
                                                                class="ri-edit-line"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="ps-4"><input class="form-check-input"
                                                        type="checkbox" id="checkboxNoLabel5" value=""
                                                        aria-label="..." checked></th>
                                                <td>
                                                    <div class="d-flex align-items-center fw-semibold">
                                                        <span class="avatar avatar-sm me-2 avatar-rounded">
                                                            <img src="{{ asset('build/assets/images/faces/8.jpg') }}"
                                                                alt="img">
                                                        </span>Mirinda Hers
                                                    </div>
                                                </td>
                                                <td>Marketing</td>
                                                <td>mirindahers@gmail.com</td>
                                                <td>
                                                    <span class="badge bg-warning-transparent">USA</span>
                                                </td>
                                                <td>Apr 14 - Dec 14, 2023</td>
                                                <td>
                                                    <div class="hstack gap-2 fs-15">
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon waves-effect waves-light btn-sm btn-success-light"><i
                                                                class="ri-download-2-line"></i></a>
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon waves-effect waves-light btn-sm btn-primary-light"><i
                                                                class="ri-edit-line"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="ps-4"><input class="form-check-input"
                                                        type="checkbox" id="checkboxNoLabel3" value=""
                                                        aria-label="..." checked></th>
                                                <td>
                                                    <div class="d-flex align-items-center fw-semibold">
                                                        <span class="avatar avatar-sm me-2 avatar-rounded">
                                                            <img src="{{ asset('build/assets/images/faces/9.jpg') }}"
                                                                alt="img">
                                                        </span>Jacob Smith
                                                    </div>
                                                </td>
                                                <td>Social Plataform</td>
                                                <td>jacobsmith@gmail.com</td>
                                                <td>
                                                    <span class="badge bg-success-transparent">Singapore</span>
                                                </td>
                                                <td>Feb 25 - Nov 25, 2023</td>
                                                <td>
                                                    <div class="hstack gap-2 fs-15">
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon waves-effect waves-light btn-sm btn-success-light"><i
                                                                class="ri-download-2-line"></i></a>
                                                        <a aria-label="anchor" href="javascript:void(0);"
                                                            class="btn btn-icon waves-effect waves-light btn-sm btn-primary-light"><i
                                                                class="ri-edit-line"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center">
                                    <div>
                                        Showing 5 Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i>
                                    </div>
                                    <div class="ms-auto">
                                        <nav aria-label="Page navigation" class="pagination-style-4">
                                            <ul class="pagination mb-0">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="javascript:void(0);">
                                                        Prev
                                                    </a>
                                                </li>
                                                <li class="page-item active"><a class="page-link"
                                                        href="javascript:void(0);">1</a></li>
                                                <li class="page-item"><a class="page-link"
                                                        href="javascript:void(0);">2</a></li>
                                                <li class="page-item">
                                                    <a class="page-link text-primary" href="javascript:void(0);">
                                                        next
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
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
        <div class="row">
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
        </div>
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
