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
                <li class="breadcrumb-item active" aria-current="page">{{ __('Expenses') }}</li>
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
                            {{ __('Expenses') }}
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <a href="{{ route('expenses.create') }}"
                                    class="btn btn-success btn-sm">{{ __('Create Expense') }}</a>
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
                                    <div class="col-lg-6">
                                        <label class="control-label col-md-4" for="name">{{ __('Name') }}<span
                                                style="color: red;">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="enter name" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="control-label col-md-4" for="amount">{{ __('Amount') }}<span
                                                style="color: red;">*</span></label>
                                        <input type="text" name="amount" id="amount" class="form-control"
                                            placeholder="enter name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="control-label col-md-4 mt-3"
                                            id="plan_period_label">{{ __('Departments') }}<span
                                                style="color: red;">*</span></label>
                                        <select name="department_id[]"
                                            class="app_code_select @error('app_code') is-invalid @enderror"
                                            multiple="multiple" id="department_id">
                                            <option disabled>{{ __('Select') }}</option>
                                            @foreach ($departments as $data)
                                                <option value="{!! $data->id !!}">{{ $data->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="control-label col-md-4 mt-3"
                                            id="plan_period_label">{{ __('Expenses Types') }}<span
                                                style="color: red;">*</span></label>
                                        <select name="type_id[]"
                                            class="app_code_select @error('app_code') is-invalid @enderror"
                                            multiple="multiple" id="type_id">
                                            <option disabled>{{ __('Select') }}</option>
                                            @foreach ($types as $data)
                                                <option value="{!! $data->id !!}">{{ $data->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12 mt-8">
                                <div class="row">
                                    <div class="col-lg-12 mt-4">
                                        <label id="labelpass1" class="control-label col-md-4">
                                            {{ __('Purpose') }} <span style="color: red;">*</span>
                                        </label>
                                        <textarea name="purpose" id="purpose" class="form-control" placeholder="purpose" rows="3"></textarea>
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
@endsection

@section('scripts')
    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    @vite('resources/assets/js/select2.js')

    <script>
        var select2type = $('.app_code_select').select2({
            dropdownParent: $("#formModal"),
            placeholder: "Select",
            tags: true,
        });

        $(document).ready(function() {
            $('#create_record').click(function() {
                $('.modal-title').text('{{ __('Add New Expenses') }}');
                $('#action_button').val('{{ __('Add') }}');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#name').val("");
                $('#purpose').val("");
                $('#amount').val("");
                $('#department_id').val("");
                $('#type_id').val("");
                $('#hidden_id').val("");
                $('#formModal').modal('show');
            });



            $('#sample_form').on('submit', function(event) {
                event.preventDefault();
                var action_url = '';
                var formdata = new FormData(this);
                if ($('#action').val() == 'Add') {
                    action_url = "{{ route('expenses.store') }}";
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
                                window.LaravelDataTables["expenses-table"].ajax.reload();
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
                    action_url = "{{ url('admin/expenses') }}" + "/" + dataId;
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
                                var currentPage = window.LaravelDataTables["expenses-table"]
                                    .page.info()
                                    .page;
                                setTimeout(function() {
                                    $('#formModal').modal('hide'); // Hide the modal
                                }, 1000);
                                window.LaravelDataTables["expenses-table"].ajax.reload(function(
                                    json) {
                                    window.LaravelDataTables["expenses-table"].page(
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
                    url: "expenses/" + id,
                    dataType: "json",
                    success: function(data) {
                        $('#name').val(data.name);
                        $('#purpose').val(data.purpose);
                        $('#amount').val(data.amount);
                        $('#department_id').val(data.department_id);
                        if (data.department_id) {
                            var typearry = data.department_id.split(',');
                        }
                        select2type.val(typearry).trigger("change");
                        $('#type_id').val(data.type_id);
                        if (data.type_id) {
                            var typearry1 = data.type_id.split(',');
                        }
                        select2type.val(typearry1).trigger("change");
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
                    url: "expenses/" + user_id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    success: function(data) {
                        // Get the current page number of the DataTable
                        var currentPage = window.LaravelDataTables["expenses-table"].page.info()
                            .page;
                        setTimeout(function() {
                            $('#confirmModal').modal('hide');
                        }, 2000);
                        window.LaravelDataTables["expenses-table"].ajax.reload(function(json) {
                            window.LaravelDataTables["expenses-table"].page(currentPage)
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
     <script>
        $(document).ready(function() {
            $(document).on('click', '.edit', function() {
                var id = $(this).attr('id');
                var currentPage = window.LaravelDataTables["expenses-table"].page.info().page +
                    1; // Get current page (index is zero-based)
                // Redirect to the edit URL while passing the current page as a query parameter
                window.location.href = "/admin/expenses/" + id + "/edit?page=" + currentPage;
            });
        });
    </script>
@endsection
