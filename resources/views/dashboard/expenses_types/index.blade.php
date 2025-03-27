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
                <li class="breadcrumb-item active" aria-current="page">{{ __('ExpensesTypes') }}</li>
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
                            {{ __('ExpensesTypes') }}
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">
                                {{ __('Create ExpensesTypes') }}</button>
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
@endsection

@section('scripts')
    
    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')
 
    <script>
        
        $(document).ready(function() {
            $('#create_record').click(function() {
                $('.modal-title').text('{{ __('Add New ExpensesTypes') }}');
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
                    action_url = "{{ route('expenses_types.store') }}";
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
                                window.LaravelDataTables["expensestypes-table"].ajax.reload();
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
                    action_url = "{{ url('admin/expenses_types') }}" + "/" + dataId;
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
                                var currentPage = window.LaravelDataTables["expensestypes-table"]
                                    .page.info()
                                    .page;
                                setTimeout(function() {
                                    $('#formModal').modal('hide'); // Hide the modal
                                }, 1000);
                                window.LaravelDataTables["expensestypes-table"].ajax.reload(function(
                                    json) {
                                    window.LaravelDataTables["expensestypes-table"].page(
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
                    url: "expenses_types/" + id,
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
                    url: "expenses_types/" + user_id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    success: function(data) {
                        // Get the current page number of the DataTable
                        var currentPage = window.LaravelDataTables["expensestypes-table"].page.info()
                            .page;
                        setTimeout(function() {
                            $('#confirmModal').modal('hide');
                        }, 2000);
                        window.LaravelDataTables["expensestypes-table"].ajax.reload(function(json) {
                            window.LaravelDataTables["expensestypes-table"].page(currentPage)
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
