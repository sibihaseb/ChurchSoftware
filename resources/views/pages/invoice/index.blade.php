@extends('layouts.master')

@section('styles')
    <!-- PRISM CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/prismjs/themes/prism-coy.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Toast Container -->
        <div id="toast-container" aria-live="polite" aria-atomic="true" class="position-fixed top-2 end-0 p-3"
            style="z-index: 1050;">
        </div>
        <nav class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Donor receipts') }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Donor receipts') }}
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <a href="{{ route('invoice.create') }}"
                                class="btn btn-success btn-sm">{{ __('Create receipt') }}</a>
                            <form id="delete_form" action="{{ route('common.deleteSelected', 'ServiceInvoice') }}"
                                class="mb-0" method="POST">
                                @csrf
                                <input type="hidden" name="ids" id="delete_ids">
                                <input type="hidden" name="page" id="page_id1">
                                <button type="button" id="delete_selected"
                                    class="btn btn-danger btn-sm">{{ __('Delete Selected Items') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table() }}
                            {{ $dataTable->scripts() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.modal.delete_modal')
    @include('pages.modal.multiple_delete_modal')
@endsection

@section('scripts')
    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- SELECT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let selectedIds = new Set();

        // Handle individual row selection
        $('#serviceinvoice-table').on('change', '.row-select', function() {
            let id = $(this).val();
            if (this.checked) {
                selectedIds.add(id);
            } else {
                selectedIds.delete(id);
            }
            console.log(selectedIds);
        });

        $('#checkall').on('click', function() {
            // Get the checked status of the "Select All" checkbox
            const isChecked = $(this).prop('checked');

            $('.row-select').each(function() {
                let id = $(this).val();

                // Check or uncheck each checkbox based on "Select All" checkbox state
                $(this).prop('checked', isChecked);

                // Update the selected IDs set
                if (isChecked) {
                    selectedIds.add(id);
                } else {
                    selectedIds.delete(id); // Remove the ID if unchecked
                }
            });
            console.log(selectedIds); // Log the current selected IDs
        });

        $(document).ready(function() {
            $(document).on('click', '#delete_selected', function() {
                if (selectedIds.size === 0) {
                    // Show a toast notification when no records are selected
                    showToast('No records selected for deletion.', 'danger');
                } else {
                    // Show the confirmation modal if IDs are selected
                    $('#confirmMultipleDelete').modal('show');
                }
            });

            // When the user clicks "OK" in the modal
            $('#ok_btn').on('click', function() {
                var currentPage = window.LaravelDataTables["serviceinvoice-table"].page.info().page + 1;
                // Set the hidden field with the selected IDs as a comma-separated string
                $('#delete_ids').val(Array.from(selectedIds).join(','));
                $('#page_id1').val(currentPage);

                // Submit the form after confirmation
                $('#delete_form').submit();
            });

            // Handle the Change Status button click
            $(document).on('click', '#change_status', function() {
                if (selectedIds.size === 0) {
                    // Show a toast notification when no records are selected
                    showToast('No records selected for status change.', 'danger');
                } else {
                    // Show the confirmation modal if IDs are selected
                    $('#multiplestatusmodal').modal('show');
                }
            });

            // When the user clicks "OK" in the modal to confirm the status change
            $('#ok_status').on('click', function() {
                var currentPage = window.LaravelDataTables["serviceinvoice-table"].page.info().page + 1;
                // Set the hidden field with the selected IDs as a comma-separated string
                $('#status_ids').val(Array.from(selectedIds).join(','));
                $('#page_id').val(currentPage);

                // Submit the status change form
                $('#status_form').submit();
            });
            // Ensure the DataTable is initialized
            var currentPage1 = new URLSearchParams(window.location.search).get('page') || 1;
            // Wait for the DataTable to be fully initialized
            $('#serviceinvoice-table').on('init.dt', function() {
                // Get the DataTable instance once initialized
                var table = window.LaravelDataTables["serviceinvoice-table"];

                // Ensure the table is available
                if (table) {
                    // Reload the table and set to the specified page
                    table.ajax.reload(function(json) {
                        console.log("Page: " + currentPage1);
                        table.page(currentPage1 - 1).draw(false); // Adjust for 0-based indexing
                    }, false);
                } else {
                    console.error("DataTable 'serviceinvoice-table' is not initialized.");
                }
            });
        });

        function showToast(message, type) {
            // Create a toast element
            const toastHtml = `
                <div class="toast align-items-center text-bg-${type} border-0 fade show mb-4" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            // Append the toast to the toast container
            $('#toast-container').append(toastHtml);

            // Automatically remove the toast after a few seconds
            setTimeout(() => {
                $('#toast-container .toast').last().fadeOut(300, function() {
                    $(this).remove();
                }); // Remove after fading out
            }, 3000);
        }
    </script>
@endsection
