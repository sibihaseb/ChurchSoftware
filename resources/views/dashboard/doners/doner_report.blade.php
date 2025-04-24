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
                        <form id="filterForm" method="GET">
                            <div class="row g-2">
                                <!-- Amount Filter (acts as MAX amount) -->
                                <div class="col-md-4">
                                    <label class="control-label col-md-12">{{ __('Amount Filter') }}:</label>
                                    <input type="text" name="amount" class="form-control"
                                        placeholder="Show records below this amount" value="{{ request('amount') }}">
                                </div>

                                <!-- Payment Method Filter -->
                                <div class="col-md-4">
                                    <label class="control-label col-md-12">{{ __('Payment Method Filter') }}:</label>
                                    <select name="payment_method" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($paymentmethod as $method)
                                            <option value="{{ $method->id }}"
                                                {{ request('payment_method') == $method->id ? 'selected' : '' }}>
                                                {{ $method->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-2 mt-4">
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Date Range Picker -->
                    <div class="col-md-4 col-sm-12 text-md-end text-start mb-2">
                        <div id="reportrange"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; display: inline-block;">
                            <i class="ri-calendar-2-line ri-lg mt-1"></i> 
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
            // Use doner.report.date for the date picker form
            $action = route('doner.report.date', [
                'code' => $user->id,
                'date_from' => 'DATE_FROM',
                'date_to' => 'DATE_TO',
            ]);
        @endphp
        <form method="GET" id="datequery" action="{{ $action }}">
            <input type="hidden" value="" name="date_from" id="date_from" />
            <input type="hidden" value="" name="date_to" id="date_to" />
        </form>
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
        var paramamount = '<?php echo request('amount'); ?>';
        var parampaymentmethod = '<?php echo request('payment_method'); ?>';
        var userId = '<?php echo $user->id; ?>';
        console.log('Initial start date:', paramstart);
        console.log('Initial end date:', paramend);
        console.log('Initial amount:', paramamount);
        console.log('Initial payment method:', parampaymentmethod);

        var start = paramstart ? moment(paramstart, 'YYYY-MM-DD') : moment().subtract(7, 'days');
        var end = paramend ? moment(paramend, 'YYYY-MM-DD') : moment();

        var initialLoad = true; // Flag to check if it's the initial load

        // Helper function to construct the route URL
        function buildRouteUrl(filterType, params) {
            var routeTemplate;
            if (filterType === 'date') {
                routeTemplate = '{{ route('doner.report.date', ['code' => '__CODE__', 'date_from' => '__DATE_FROM__', 'date_to' => '__DATE_TO__']) }}';
                return routeTemplate
                    .replace('__CODE__', encodeURIComponent(params.code))
                    .replace('__DATE_FROM__', encodeURIComponent(params.date_from))
                    .replace('__DATE_TO__', encodeURIComponent(params.date_to));
            } else if (filterType === 'amount') {
                routeTemplate = '{{ route('doner.report.amount', ['code' => '__CODE__', 'amount' => '__AMOUNT__']) }}';
                return routeTemplate
                    .replace('__CODE__', encodeURIComponent(params.code))
                    .replace('__AMOUNT__', encodeURIComponent(params.amount));
            } else if (filterType === 'payment_method') {
                routeTemplate = '{{ route('doner.report.payment', ['code' => '__CODE__', 'payment_method' => '__PAYMENT_METHOD__']) }}';
                return routeTemplate
                    .replace('__CODE__', encodeURIComponent(params.code))
                    .replace('__PAYMENT_METHOD__', encodeURIComponent(params.payment_method));
            } else if (filterType === 'amount_payment_method') {
                routeTemplate = '{{ route('doner.report.amount_payment', ['code' => '__CODE__', 'amount' => '__AMOUNT__', 'payment_method' => '__PAYMENT_METHOD__']) }}';
                return routeTemplate
                    .replace('__CODE__', encodeURIComponent(params.code))
                    .replace('__AMOUNT__', encodeURIComponent(params.amount))
                    .replace('__PAYMENT_METHOD__', encodeURIComponent(params.payment_method));
            } else {
                // Base route with no filters
                routeTemplate = '{{ route('doner.report.base', ['code' => '__CODE__']) }}';
                return routeTemplate
                    .replace('__CODE__', encodeURIComponent(params.code));
            }
        }

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            // Log the selected dates
            console.log('Selected start date:', start.format('YYYY-MM-DD'));
            console.log('Selected end date:', end.format('YYYY-MM-DD'));

            // If it's not the initial load, redirect to the date filter route
            if (!initialLoad) {
                var url = buildRouteUrl('date', {
                    code: userId,
                    date_from: start.format('YYYY-MM-DD'),
                    date_to: end.format('YYYY-MM-DD')
                });
                console.log('Date picker redirecting to:', url);
                window.location.href = url;
            }
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            maxDate: moment(), // Disable future dates by setting maxDate to today
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'This Week': [moment().startOf('week'), moment().endOf('week')],
                'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                'Last 2 Weeks': [moment().subtract(2, 'weeks').startOf('week'), moment().endOf('week')],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'First Half of This Month': [moment().startOf('month'), moment().startOf('month').add(14, 'days').endOf('day')],
                'Second Half of This Month': [moment().startOf('month').add(15, 'days'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                'Year to Date': [moment().startOf('year'), moment()],
                'First Half of This Year': [moment().startOf('year'), moment().startOf('year').add(5, 'months').endOf('month')],
                'Second Half of This Year': [moment().startOf('year').add(6, 'months').startOf('month'), moment().endOf('year')],
            }
        }, cb);

        // Set the initial date display without submitting
        cb(start, end);

        // Set initialLoad to false after the first callback
        initialLoad = false;

        // Handle filter form submission
        $('#filterForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            // Get form values
            var amount = $('input[name="amount"]').val() || '';
            var payment_method = $('select[name="payment_method"]').val() || '';

            var url;
            // Determine which route to call based on form inputs
            if (amount && payment_method) {
                // Both amount and payment method
                url = buildRouteUrl('amount_payment_method', {
                    code: userId,
                    amount: amount,
                    payment_method: payment_method
                });
            } else if (amount) {
                // Amount only
                url = buildRouteUrl('amount', {
                    code: userId,
                    amount: amount
                });
            } else if (payment_method) {
                // Payment method only
                url = buildRouteUrl('payment_method', {
                    code: userId,
                    payment_method: payment_method
                });
            } else {
                // No filters
                url = buildRouteUrl('base', {
                    code: userId
                });
            }

            console.log('Filter form redirecting to:', url);
            window.location.href = url;
        });
    </script>
@endsection