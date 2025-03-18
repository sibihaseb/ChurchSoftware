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
                <li class="breadcrumb-item active" aria-current="page">{{ __('Admin User') }}</li>
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
                            {{ __('Admin User') }}
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <button type="button" name="create_record" id="create_record"
                                class="btn btn-success btn-sm">{{ __('Create Admin User') }}</button>
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
@endsection

<div id="formModal" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">{{ __('Add New User') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="control-label col-md-4">{{ __('Name') }}<span
                                            style="color: red;">*</span> :
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control" />
                                </div>
                                <div class="col-lg-6">
                                    <label class="control-label col-md-4">{{ __('Email') }}<span
                                            style="color: red;">*</span> :
                                    </label>
                                    <input type="text" name="email" id="email" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="control-label col-md-4 mt-3">{{ __('Password') }}<span
                                            style="color: red;">*</span></label>
                                    <input type="text" name="password" id="password" class="form-control" />
                                </div>
                                <div class="col-lg-6">
                                    <label class="control-label col-md-4 mt-3">{{ __('Confirm Password') }}<span
                                            style="color: red;">*</span></label>
                                    <input type="text" name="password_confirmation" id="password_confirmation"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="control-label col-md-4 mt-3"
                                        id="plan_period_label">{{ __('App Name') }}<span
                                            style="color: red;">*</span></label>
                                    <select name="app_code[]"
                                        class="app_code_select @error('app_code') is-invalid @enderror"
                                        multiple="multiple" id="tvapp">
                                        <option disabled>{{ __('Select') }}</option>
                                        @foreach ($church as $app)
                                            {{-- @if (auth()->user()->account_type === 'S')
                                                <option value="{!! $app->id !!}">{{ $app->name }}</option>
                                            @else
                                                @php
                                                    $userAppCodes = explode(',', auth()->user()->app_code);
                                                @endphp
                                                @if (in_array($app->id, $userAppCodes))
                                                    <option value="{!! $app->id !!}">{{ $app->name }}
                                                    </option>
                                                @endif
                                            @endif --}}
                                            <option value="{!! $app->id !!}">{{ $app->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label class="control-label col-md-4 mt-3">{{ __('Account Type') }}</label>
                                    <select name="account_type" id="account_type" class="form-control">
                                        <option disabled selected> {{ __('Select Type') }}</option>
                                        {{-- @if (auth()->user()->account_type == 'S')
                                            <option value="S">{{ __('Super Admin') }}</option>
                                            <option value="A">{{ __('Admin') }}</option>
                                        @endif --}}
                                        <option value="S">{{ __('Super Admin') }}</option>
                                        <option value="A">{{ __('Admin') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="role"
                                        class="control-label col-md-4 mt-3">{{ __('Role') }}</label>
                                    <select name="role" id="role" class="form-control">
                                        <option disabled selected>{{ __('Select role') }}</option>
                                        @foreach ($role as $roles)
                                            {{-- @if (auth()->user()->account_type === 'S' || ($roles->name !== 'Superadmin' && $roles->name !== 'Admin'))
                                                @if ($roles->name === 'Content Partner')
                                                    @can('Content Partner')
                                                        <option value="{{ $roles->name }}">{{ $roles->name }}</option>
                                                    @endcan
                                                @else
                                                    <option value="{{ $roles->name }}">{{ $roles->name }}</option>
                                                @endif
                                            @endif --}}
                                            <option value="{{ $roles->name }}">{{ $roles->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="button" id="closemybt" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="code" id="code" value="" />
                        <input type="hidden" name="oldpassword" id="oldpassword" value="" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                            value="{{ __('Add') }}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('pages.modal.delete_modal')
{{-- @include('pages.modal.multiple_delete_modal')
@include('pages.modal.status_modal')
@include('pages.modal.multiple_status_modal') --}}
@section('scripts')
    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- SELECT2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- INTERNAL SELECT2 JS -->
    @vite('resources/assets/js/select2.js')
    <script>
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
        var select2type = $('.app_code_select').select2({
            tags: true,
            placeholder: "Select",
            dropdownParent: $("#formModal")
        });

        $(document).ready(function() {

            $('#create_record').click(function() {

                $('.modal-title').text('{{ __('Add New Admin User') }}');
                $('#action_button').val('{{ __('Add') }}');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#name').val("");
                $('#email').val("");
                // $('#phone').val("");
                $('#password').val("");
                $('#password_confirmation').val("");
                $('#oldpassword').val("");
                // $('#status').val("1");
                $('#account_type').val("");
                 $('#tvapp').val("");
                // $('#day').val("");
                // $('.select2-selection__choice').remove();
                $('#hidden_id').val("");
                $('#formModal').modal('show');
                $('#sample_form')[0].reset();
            });



            $('#sample_form').on('submit', function(event) {
                event.preventDefault();
                var action_url = '';
                var formdata = new FormData(this);
                if ($('#action').val() == 'Add') {
                    action_url = "{{ route('adminuser.store') }}";
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
                                window.LaravelDataTables["tvadminuser-table"].ajax.reload();
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
                    action_url = "{{ url('admin/adminuser') }}" + "/" + dataId;
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
                                var currentPage = window.LaravelDataTables["tvadminuser-table"]
                                    .page.info()
                                    .page;
                                setTimeout(function() {
                                    $('#formModal').modal('hide'); // Hide the modal
                                }, 1000);
                            }
                            window.LaravelDataTables["tvadminuser-table"].ajax.reload(function(
                                json) {
                                window.LaravelDataTables["tvadminuser-table"].page(
                                        currentPage)
                                    .draw(false);
                            }, false);
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
                    url: "adminuser/" + id,
                    dataType: "json",
                    success: function(data) {
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        // $('#phone').val(data.phone);
                        $('#oldpassword').val(data.password);
                        // $('#status').val(data.status);
                         $('#role').val(data.role);
                        // $('#day').val(data.day);
                         $('#account_type').val(data.account_type);
                        // $('#tvapp').val(data.app_code);
                        // if (data.app_code) {
                        //     var typearry = data.app_code.split(',');
                        // }
                        // select2type.val(typearry).trigger("change");
                        // $('#code').val(data.code);
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
                    url: "admin/adminuser/" + user_id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    success: function(data) {
                        // Get the current page number of the DataTable
                        var currentPage = window.LaravelDataTables["tvadminuser-table"].page
                            .info()
                            .page;
                        setTimeout(function() {
                            $('#confirmModal').modal('hide');
                        }, 2000);
                        window.LaravelDataTables["tvadminuser-table"].ajax.reload(function(
                            json) {
                            window.LaravelDataTables["tvadminuser-table"].page(
                                    currentPage)
                                .draw(false);
                        }, false);
                    }
                })
            });
        });
        $("#closemybt").click(function() {
            $('#sample_form').trigger('reset');
        });
    </script>
@endsection
