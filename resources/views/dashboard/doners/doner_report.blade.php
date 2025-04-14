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
                <li class="breadcrumb-item"><a href="{{ url('admin/doners') }}">{{ __('All Doners') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Doner Report') }}</li>
            </ol>
        </nav>
        <!-- Tab Structure -->
        <div class="card custom-card">
            <div class="card-body">
                <!-- Row to hold both tabs and date picker -->
                <div class="row align-items-center justify-content-between">
                    <!-- Tabs -->
                    <div class="col-md-8 col-sm-12 mb-2">
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
            if (request()->routeIs('doner.report')) {
                $action = route('doner.report', ['code' => $user->id]);
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
