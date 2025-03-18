@extends('layouts.master')

@section('styles')
    <!-- PRISM CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/prismjs/themes/prism-coy.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Role Table
                        </div>
                        <a href="{{ url('admin/createrole') }}" class="btn btn-success btn-sm">Create
                            Record</a>
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
<div id="formModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Add New Record</h4>
                <button id="crtcncl" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4">Type : </label>
                        <div class="col-md-8">
                            <input type="text" name="type" id="type" class="form-control" />
                        </div>
                    </div>
                    <br />

                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="button" id="closemybt" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        {{-- <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}"/> --}}
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                            value="Add" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('pages.modal.delete_modal')

@section('scripts')
    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')
    <script>
        $(document).ready(function() {


            $('#create_record').click(function() {
                $('.modal-title').text('Add Type');
                $('#type').val("");
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');

                $('#formModal').modal('show');
            });



            $('#sample_form').on('submit', function(event) {
                event.preventDefault();
                var action_url = '';

                if ($('#action').val() == 'Add') {
                    action_url = "{{ url('storerole') }}";
                }

                if ($('#action').val() == 'Edit') {
                    action_url = "";
                }



                var formdata = new FormData(this);

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
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success +
                                '</div>';
                            $('#sample_form')[0].reset();
                            $('#user_table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    }

                });



            });

            $(document).on('click', '.edit', function() {
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url: "role/" + id + "/edit",
                    dataType: "json",
                    success: function(data) {
                        if (data.result.id == 1) {
                            alert('Cant Edit Super Admin');
                        } else {
                            window.location = 'role/editpage/' + data.result.id;
                        }

                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function() {
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

          // Handle the deletion
          $('#ok_button').click(function() {
                $.ajax({
                    url: "role/destroy/" + user_id,
                    beforeSend: function() {
                        $('#ok_button').text('Deleting...');
                    },
                    success: function(data) {
                        // Get the current page number of the DataTable
                        var currentPage = window.LaravelDataTables["role-table"].page
                            .info()
                            .page;
                        setTimeout(function() {
                            $('#confirmModal').modal('hide');
                        }, 2000);
                        window.LaravelDataTables["role-table"].ajax.reload(function(
                            json) {
                            window.LaravelDataTables["role-table"].page(
                                    currentPage)
                                .draw(false);
                        }, false);
                    }
                });
            });

            $(document).on('click', '#cncl_btn', function() {
                $('#confirmModal').modal('hide');
            });

            $(document).on('click', '#delcncl', function() {
                $('#confirmModal').modal('hide');
            });

            $(document).on('click', '#crtcncl', function() {
                $('#formModal').modal('hide');
            });

            $(document).on('click', '#closemybt', function() {
                $('#formModal').modal('hide');
            });

            //  $('#cncl_btn').click(function{
            //      $('#formModal').hide();
            //  });


        });
    </script>
@endsection
