@extends('layouts.master')

@section('styles')
    <!-- PRISM CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/prismjs/themes/prism-coy.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/libs/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/libs/quill/quill.bubble.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Toast Container -->
        <div id="toast-container" aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-5"
            style="z-index: 1050;">
        </div>
        <nav class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Departments') }}</li>
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
                            {{ __('Departments') }}
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">
                                {{ __('Create Department') }}</button>
                                <form id="delete_form" action="{{ route('common.deleteSelected', 'Department') }}" class="mb-0"
                                method="POST">
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
    <div id="formModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">{{ __('Add New User') }}</h4>
                <button type="button" class="btn-close" id="closemodalbyicon" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="control-label col-md-4" for="name">{{ __('Name') }}<span
                                            style="color: red;">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="enter name" />
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="form-group" align="center">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="button" id="closemybt" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        {{-- <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}"/> --}}
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                            value="{{ __('Add') }}" />
                    </div>
                </form>
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
    <script>
        let selectedIds = new Set();

        // Handle individual row selection
        $('#departments-table').on('change', '.row-select', function() {
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
                var currentPage = window.LaravelDataTables["departments-table"].page.info().page + 1;
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
                var currentPage = window.LaravelDataTables["departments-table"].page.info().page + 1;
                // Set the hidden field with the selected IDs as a comma-separated string
                $('#status_ids').val(Array.from(selectedIds).join(','));
                $('#page_id').val(currentPage);

                // Submit the status change form
                $('#status_form').submit();
            });
            // Ensure the DataTable is initialized
            var currentPage1 = new URLSearchParams(window.location.search).get('page') || 1;
            // Wait for the DataTable to be fully initialized
            $('#departments-table').on('init.dt', function() {
                // Get the DataTable instance once initialized
                var table = window.LaravelDataTables["departments-table"];

                // Ensure the table is available
                if (table) {
                    // Reload the table and set to the specified page
                    table.ajax.reload(function(json) {
                        console.log("Page: " + currentPage1);
                        table.page(currentPage1 - 1).draw(false); // Adjust for 0-based indexing
                    }, false);
                } else {
                    console.error("DataTable 'departments-table' is not initialized.");
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
 
    <script>
        
        $(document).ready(function() {
            $('#create_record').click(function() {
                $('.modal-title').text('{{ __('Add New Departments') }}');
                $('#action_button').val('{{ __('Add') }}');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#name').val("");
                $('#hidden_id').val("");
                $('#formModal').modal('show');
            });



            $('#sample_form').on('submit', function(event) {
                event.preventDefault();
                var action_url = '';
                var formdata = new FormData(this);
                if ($('#action').val() == 'Add') {
                    action_url = "{{ route('departments.store') }}";
                    $.ajax({
                        url: action_url,
                        method: "POST",
                        data: formdata,
                        mimeType: "multipart/form-data",
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(data) {

                            var html = '';
                            if (data.message) {
                                html = '<div class="alert alert-success">' + data.message +
                                    '</div>';
                                $('#sample_form')[0].reset();
                                window.LaravelDataTables["departments-table"].ajax.reload();
                                setTimeout(function() {
                                    $('#formModal').modal('hide'); // Hide the modal
                                }, 1000);
                            }
                            $('#form_result').html(html);
                        },
                        error: function(data) {
                            console.log('data', data)
                            if (data.responseJSON.message) {
                                html = '<div class="alert alert-danger">';
                                html += '<span>' + data.responseJSON.message + '</span>'
                                // for (var count = 0; count < data.errors.length; count++) {
                                //     html += '<p>' + data.errors[count] + '</p>';
                                // }
                                html += '</div>';
                                $('#form_result').html(html);
                            }

                        }

                    });
                }

                if ($('#action').val() == 'Edit') {
                    var dataId = $('#hidden_id').val();
                    action_url = "{{ url('admin/departments') }}" + "/" + dataId;
                    formdata.append("_method", "PATCH");
                    $.ajax({
                        url: action_url,
                        method: "POST",
                        data: formdata,
                        mimeType: "multipart/form-data",
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(data) {

                            var html = '';
                            if (data.message) {
                                html = '<div class="alert alert-success">' + data.message +
                                    '</div>';
                                $('#sample_form')[0].reset();
                                // Get the current page number of the DataTable
                                var currentPage = window.LaravelDataTables["departments-table"]
                                    .page.info()
                                    .page;
                                setTimeout(function() {
                                    $('#formModal').modal('hide'); // Hide the modal
                                }, 1000);
                                window.LaravelDataTables["departments-table"].ajax.reload(function(
                                    json) {
                                    window.LaravelDataTables["departments-table"].page(
                                            currentPage)
                                        .draw(false);
                                }, false);
                            }
                            $('#form_result').html(html);
                        },
                        error: function(data) {
                            console.log('data', data)
                            if (data.responseJSON.message) {
                                html = '<div class="alert alert-danger">';
                                html += '<span>' + data.responseJSON.message + '</span>'
                                // for (var count = 0; count < data.errors.length; count++) {
                                //     html += '<p>' + data.errors[count] + '</p>';
                                // }
                                html += '</div>';
                                $('#form_result').html(html);
                            }

                        }


                    });
                }
            });
            $(document).on('click', '.edit', function() {
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url: "departments/" + id,
                    dataType: "json",
                    success: function(data) {
                        $('#name').val(data.name);
                        $('#location').val(data.location);
                        $('#oldimage').val(data.logo);
                        $('#hidden_id').val(id);
                        $('.modal-title').text('{{ __('Update Record') }}');
                        $('#action_button').val('{{ __('Update') }}');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');
                    }
                })
            });

            $(document).on('click', '.view', function(event) {
                event.preventDefault();
                $("#paitentmodal").modal('show');
            });

            var user_id;

            $(document).on('click', '.delete', function() {
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function() {
                $.ajax({
                    url: "departments/" + user_id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    success: function(data) {
                        // Get the current page number of the DataTable
                        var currentPage = window.LaravelDataTables["departments-table"].page.info()
                            .page;
                        setTimeout(function() {
                            $('#confirmModal').modal('hide');
                        }, 2000);
                        window.LaravelDataTables["departments-table"].ajax.reload(function(json) {
                            window.LaravelDataTables["departments-table"].page(currentPage)
                                .draw(false);
                        }, false);
                    }
                })
            });
        });
        $("#closemybt").click(function() {
            $('#sample_form').trigger('reset');
        });
        $("#closemodalbyicon").click(function() {
            $('#sample_form').trigger('reset');
        });
    </script>
@endsection
