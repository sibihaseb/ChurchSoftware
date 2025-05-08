@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('build/assets/libs/prismjs/themes/prism-coy.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div id="toast-container" aria-live="polite" aria-atomic="true" class="position-fixed top-2 end-0 p-3"
            style="z-index: 1050;"></div>

        <nav class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Contact Submissions') }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="card-header justify-content-between">
                        <div class="card-title">{{ __('Contact Messages') }}</div>
                        <button id="bulkDeleteBtn" class="btn btn-danger btn-sm">{{ __('Delete Selected') }}</button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-bordered table-striped'], true) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.modal.delete_modal')
@endsection

@section('scripts')
    <script>
        let contactId;

        $(document).on('click', '.delete', function() {
            contactId = $(this).data('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function() {
                    $.ajax({
                        url: "/admin/contact/" + contactId,
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        success: function(response) {
                            console.log("Deleted:", response);
                            $('#confirmModal').modal('hide');
                            $('#contact-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            console.error("AJAX delete failed:", xhr.responseText);
                            alert('Failed to delete contact. Check console for details.');
                        }
                    });

                    $('#bulkDeleteBtn').on('click', function() {
                                let ids = $('.row-select:checked').map(function() {
                                    return $(this).val();
                                }).get();

                                if (ids.length === 0) {
                                    alert('No messages selected');
                                    return;
                                }

                                if (confirm('Delete selected messages?')) {
                                    $.ajax({
                                        url: '/admin/contact/bulk-delete',
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                                        },
                                        data: {
                                            ids: ids
                                        },
                                        success: function(data) {
                                            console.log("Bulk deleted:", data);
                                            $('#contact-table').DataTable().ajax.reload();
                                        },
                                        error: function(xhr) {
                                            console.error("Bulk delete error:", xhr.responseText);
                                            alert('Bulk delete failed. Check console.');
                                        }
                                    });
    </script>

    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{ $dataTable->scripts() }}
@endsection
