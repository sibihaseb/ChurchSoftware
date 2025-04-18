@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('build/assets/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
    <div class="container-fluid">
        <nav class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin/departments') }}">{{ __('All Departments') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Departments Report') }}</li>
            </ol>
        </nav>
        {{-- @if (isset($totalPoints, $currentMonthPoints))
        <div class="row">
            <div class="col-xxl-2 col-xl-2">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-top">
                            <div class="me-3">
                                <span class="avatar avatar-md p-2 bg-primary">
                                    <svg class="svg-white" fill="#000000" height="800px" width="800px" version="1.1"
                                        id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 370.04 370.04"
                                        xml:space="preserve">
                                        <g>
                                            <g id="Layer_5_21_">
                                                <g>
                                                    <path d="M341.668,314.412c0,0-41.071-70.588-48.438-83.248c8.382-2.557,17.311-4.815,21.021-11.221
            c6.183-10.674-4.823-28.184-1.933-39.625c2.977-11.775,20.551-21.964,20.551-33.933c0-11.661-18.169-25.284-21.148-36.99
            c-2.91-11.439,8.063-28.968,1.86-39.629c-6.203-10.662-26.864-9.786-35.369-17.97c-8.751-8.422-8.724-29.028-19.279-34.672
            c-10.598-5.665-27.822,5.784-39.589,3.072C207.711,17.515,197.318,0,185.167,0c-12.331,0-31.944,19.868-35.02,20.583
            c-11.761,2.734-29.007-8.687-39.594-2.998c-10.545,5.663-10.48,26.271-19.215,34.707c-8.491,8.199-29.153,7.361-35.337,18.035
            c-6.183,10.672,4.823,28.178,1.934,39.625c-2.897,11.476-21.083,23.104-21.083,36.376c0,11.97,17.618,22.127,20.613,33.896
            c2.911,11.439-8.062,28.966-1.859,39.631c3.377,5.805,11.039,8.188,18.691,10.479c0.893,0.267,2.582,1.266,1.438,2.933
            c-5.235,9.036-47.37,81.755-47.37,81.755c-3.352,5.784-0.63,10.742,6.047,11.023l32.683,1.363
            c6.677,0.281,15.053,5.133,18.617,10.786l17.44,27.674c3.564,5.653,9.219,5.547,12.57-0.236c0,0,48.797-84.246,48.817-84.27
            c0.979-1.144,1.963-0.909,2.434-0.509c5.339,4.546,12.782,9.081,18.994,9.081c6.092,0,11.733-4.269,17.313-9.03
            c0.454-0.387,1.559-1.18,2.367,0.466c0.013,0.026,48.756,83.811,48.756,83.811c3.36,5.776,9.016,5.874,12.569,0.214
            l17.391-27.707c3.554-5.657,11.921-10.528,18.598-10.819l32.68-1.424C342.315,325.152,345.028,320.187,341.668,314.412z
            M239.18,238.631c-36.136,21.023-79.511,18.77-112.641-2.127c-48.545-31.095-64.518-95.419-35.335-145.788
            c29.516-50.95,94.399-68.928,145.808-40.929c0.27,0.147,0.537,0.299,0.805,0.449c0.381,0.211,0.761,0.425,1.14,0.641
            c15.86,9.144,29.613,22.415,39.461,39.342C308.516,141.955,290.915,208.533,239.18,238.631z" />
                                                    <path d="M230.916,66.103c-0.15-0.087-0.302-0.168-0.452-0.254C203.002,49.955,168,48.793,138.665,65.86
            c-43.532,25.326-58.345,81.345-33.019,124.876c7.728,13.284,18.318,23.888,30.536,31.498c1.039,0.658,2.09,1.305,3.164,1.927
            c43.579,25.247,99.568,10.333,124.814-33.244C289.405,147.338,274.495,91.35,230.916,66.103z M241.818,137.344l-15.259,14.873
            c-4.726,4.606-7.68,13.698-6.563,20.203l3.602,21.001c1.116,6.505-2.75,9.314-8.592,6.243l-18.861-9.916
            c-5.842-3.071-15.401-3.071-21.243,0l-18.86,9.916c-5.842,3.071-9.709,0.262-8.593-6.243l3.602-21.001
            c1.116-6.505-1.838-15.597-6.564-20.203l-15.258-14.873c-4.727-4.606-3.249-9.152,3.282-10.102l21.086-3.064
            c6.531-0.949,14.265-6.568,17.186-12.486l9.43-19.107c2.921-5.918,7.701-5.918,10.621,0l9.431,19.107
            c2.921,5.918,10.654,11.537,17.186,12.486l21.086,3.064C245.067,128.192,246.544,132.738,241.818,137.344z" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <div class="d-flex mb-1 align-items-top justify-content-between">
                                    <a
                                        href="http://localhost:8000/appuser_report/date_from=2024-12-19&amp;date_to=2024-12-26">
                                        <h5 class="fw-semibold mb-0 lh-1">{{$totalPoints}}</h5>
                                    </a>
                                </div>
                                <p class="mb-0 fs-10 op-7 text-muted fw-semibold">Total Points</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-2 col-xl-2">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-top">
                            <div class="me-3">
                                <span class="avatar avatar-md p-2 bg-primary">
                                    <svg class="svg-white" fill="#000000" height="800px" width="800px" version="1.1"
                                        id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 370.04 370.04"
                                        xml:space="preserve">
                                        <g>
                                            <g id="Layer_5_21_">
                                                <g>
                                                    <path d="M341.668,314.412c0,0-41.071-70.588-48.438-83.248c8.382-2.557,17.311-4.815,21.021-11.221
            c6.183-10.674-4.823-28.184-1.933-39.625c2.977-11.775,20.551-21.964,20.551-33.933c0-11.661-18.169-25.284-21.148-36.99
            c-2.91-11.439,8.063-28.968,1.86-39.629c-6.203-10.662-26.864-9.786-35.369-17.97c-8.751-8.422-8.724-29.028-19.279-34.672
            c-10.598-5.665-27.822,5.784-39.589,3.072C207.711,17.515,197.318,0,185.167,0c-12.331,0-31.944,19.868-35.02,20.583
            c-11.761,2.734-29.007-8.687-39.594-2.998c-10.545,5.663-10.48,26.271-19.215,34.707c-8.491,8.199-29.153,7.361-35.337,18.035
            c-6.183,10.672,4.823,28.178,1.934,39.625c-2.897,11.476-21.083,23.104-21.083,36.376c0,11.97,17.618,22.127,20.613,33.896
            c2.911,11.439-8.062,28.966-1.859,39.631c3.377,5.805,11.039,8.188,18.691,10.479c0.893,0.267,2.582,1.266,1.438,2.933
            c-5.235,9.036-47.37,81.755-47.37,81.755c-3.352,5.784-0.63,10.742,6.047,11.023l32.683,1.363
            c6.677,0.281,15.053,5.133,18.617,10.786l17.44,27.674c3.564,5.653,9.219,5.547,12.57-0.236c0,0,48.797-84.246,48.817-84.27
            c0.979-1.144,1.963-0.909,2.434-0.509c5.339,4.546,12.782,9.081,18.994,9.081c6.092,0,11.733-4.269,17.313-9.03
            c0.454-0.387,1.559-1.18,2.367,0.466c0.013,0.026,48.756,83.811,48.756,83.811c3.36,5.776,9.016,5.874,12.569,0.214
            l17.391-27.707c3.554-5.657,11.921-10.528,18.598-10.819l32.68-1.424C342.315,325.152,345.028,320.187,341.668,314.412z
            M239.18,238.631c-36.136,21.023-79.511,18.77-112.641-2.127c-48.545-31.095-64.518-95.419-35.335-145.788
            c29.516-50.95,94.399-68.928,145.808-40.929c0.27,0.147,0.537,0.299,0.805,0.449c0.381,0.211,0.761,0.425,1.14,0.641
            c15.86,9.144,29.613,22.415,39.461,39.342C308.516,141.955,290.915,208.533,239.18,238.631z" />
                                                    <path d="M230.916,66.103c-0.15-0.087-0.302-0.168-0.452-0.254C203.002,49.955,168,48.793,138.665,65.86
            c-43.532,25.326-58.345,81.345-33.019,124.876c7.728,13.284,18.318,23.888,30.536,31.498c1.039,0.658,2.09,1.305,3.164,1.927
            c43.579,25.247,99.568,10.333,124.814-33.244C289.405,147.338,274.495,91.35,230.916,66.103z M241.818,137.344l-15.259,14.873
            c-4.726,4.606-7.68,13.698-6.563,20.203l3.602,21.001c1.116,6.505-2.75,9.314-8.592,6.243l-18.861-9.916
            c-5.842-3.071-15.401-3.071-21.243,0l-18.86,9.916c-5.842,3.071-9.709,0.262-8.593-6.243l3.602-21.001
            c1.116-6.505-1.838-15.597-6.564-20.203l-15.258-14.873c-4.727-4.606-3.249-9.152,3.282-10.102l21.086-3.064
            c6.531-0.949,14.265-6.568,17.186-12.486l9.43-19.107c2.921-5.918,7.701-5.918,10.621,0l9.431,19.107
            c2.921,5.918,10.654,11.537,17.186,12.486l21.086,3.064C245.067,128.192,246.544,132.738,241.818,137.344z" />
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <div class="d-flex mb-1 align-items-top justify-content-between">
                                    <a
                                        href="http://localhost:8000/appuser_report/date_from=2024-12-19&amp;date_to=2024-12-26">
                                        <h5 class="fw-semibold mb-0 lh-1">{{$currentMonthPoints}}</h5>
                                    </a>
                                </div>
                                <p class="mb-0 fs-10 op-7 text-muted fw-semibold"><?= date('F') ?> Points</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif --}}
        <!-- Tab Structure -->
        <div class="card custom-card">
            <div class="card-body">
                <!-- Row to hold both tabs and date picker -->
                <div class="row align-items-center justify-content-between">
                    <!-- Tabs -->
                    <div class="col-md-8 col-sm-12 mb-2">
                        <ul class="nav nav-pills flex-wrap" id="reportTabs">
                            <li class="nav-item">
                                <a href="{{ route('department.budget.report', ['code' => $user->id]) }}"
                                    class="nav-link {{ request()->routeIs('department.budget.report') ? 'active' : '' }}"
                                    id="personal-tab">{{ __('Department Budget Report') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('department.expenses.report', ['code' => $user->id]) }}"
                                    class="nav-link {{ request()->routeIs('department.expenses.report') ? 'active' : '' }}"
                                    id="coupon-tab">{{ __('Department Expense Report') }}</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('department.budgetVexpenses.report', ['code' => $user->id]) }}"
                                    class="nav-link {{ request()->routeIs('department.budgetVexpenses.report') ? 'active' : '' }}"
                                    id="coupon-tab">{{ __('Budget Vs Expense Report') }}</a>
                            </li> --}}
                        </ul>
                    </div>

                    <!-- Date Range Picker -->
                    <div class="col-md-4 col-sm-12 text-md-end text-start mb-2">
                        <div id="reportrange"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; display: inline-block;">
                            <i class="ri-calendar-2-line ri-lg mt-1"></i>&nbsp;
                            <span></span> <i class="ri-arrow-down-s-line ri-lg mt-1"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="reportTabsContent">
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                            {{ $dataTable->scripts() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            if (request()->routeIs('department.budget.report')) {
                $action = route('department.budget.report', ['code' => $user->id]);
            } elseif (request()->routeIs('department.expenses.report')) {
                $action = route('department.expenses.report', ['code' => $user->id]);
            }
        @endphp
        <form method="GET" id="datequery" action="{{ $action }}">
            <input type="hidden" value="" name="date_from" id="date_from" />
            <input type="hidden" value="" name="date_to" id="date_to" />
        </form>
    </div>
    </div>
    @php
        $startparam = Request::get('date_from');
        $endparam = Request::get('date_to');
    @endphp
@endsection

@section('scripts')
    <script src="{{ asset('build/assets/libs/datatables/datatables.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript">
        var paramstart = '<?php echo $startparam; ?>';
        var paramend = '<?php echo $endparam; ?>';
        console.log(paramstart)
        var start = paramstart ? moment(paramstart, 'YYYY-MM-DD') : moment().subtract(7, 'days');
        var end = paramend ? moment(paramend, 'YYYY-MM-DD') : moment();

        var initialLoad = true; // Flag to check if it's the initial load

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            // Log the selected dates
            console.log('Selected start date:', start.format('YYYY-MM-DD'));
            console.log('Selected end date:', end.format('YYYY-MM-DD'));

            // If it's not the initial load, set values and submit the form
            if (!initialLoad) {
                $('#date_from').val(start.format('YYYY-MM-DD'));
                $('#date_to').val(end.format('YYYY-MM-DD'));
                $('#datequery').submit();
            }
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            maxDate: moment(), // Disable future dates by setting maxDate to today
            ranges: {
                  // Day-based ranges (for finer granularity)
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                // Week-based ranges
                'This Week': [moment().startOf('week'), moment().endOf('week')],
                'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf(
                    'week')],
                'Last 2 Weeks': [moment().subtract(2, 'weeks').startOf('week'), moment().endOf('week')],
                // Month-based ranges
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')],
                'First Half of This Month': [moment().startOf('month'), moment().startOf('month').add(14, 'days')
                    .endOf('day')
                ],
                'Second Half of This Month': [moment().startOf('month').add(15, 'days'), moment().endOf('month')],

                // Year-based ranges
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf(
                    'year')],
                'Year to Date': [moment().startOf('year'), moment()],
                'First Half of This Year': [moment().startOf('year'), moment().startOf('year').add(5, 'months')
                    .endOf('month')
                ],
                'Second Half of This Year': [moment().startOf('year').add(6, 'months').startOf('month'), moment()
                    .endOf('year')
                ],
            }
        }, cb);

        // Set the initial date display without submitting the form
        cb(start, end);

        // Set initialLoad to false after the first callback to ensure subsequent changes trigger the form submission
        initialLoad = false;
    </script>
@endsection
