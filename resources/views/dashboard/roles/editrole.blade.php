@extends('layouts.master')

@section('styles')
    <!-- PRISM CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/prismjs/themes/prism-coy.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <nav class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/roletable') }}">{{ __('Role Table') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{ __('Edit Role') }}
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Edit Role') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('role.update') }}">
                            @csrf
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('Role Name') }}</label>
                                    @foreach ($roledetail as $roledet)
                                        <input type="text" name="rolename" class="form-control" id="rolename"
                                            placeholder="Enter Unique Role Name" value="{{ $role->name }}" disabled>
                                    @endforeach
                                    <input type="hidden" name="hidden_id" id="hidden_id" class="form-control"
                                        value="{{ $role->id }}">
                                    @if ($errors->has('rolename'))
                                        <span class="text-danger">{{ $errors->first('rolename') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mt-4">
                                    <label>{{ __('Permissions') }} <input type="checkbox" id="select-all"></label>
                                </div>
                                <div class="form-group">
                                    {{-- @foreach ($permissionall as $key => $permissionfe)
                                        <label class="m-2">
                                            <input class="m-2" type="checkbox" name="permission[]"
                                                @foreach ($permissions as $rolepermission) 
                                                @if ($permissionfe->id == $rolepermission->id)
                                            checked="checked" 
                                            @endif 
                                        @endforeach
                                                value="{{ $permissionfe->name }}"> {{ $permissionfe->name }}
                                            </label>
                                    @endforeach --}}
                                    <hr />
                                    <div class="row">
                                        <div class="col-lg-4">
                                            @if (
                                                $allPermission['User Management'] == 'User Management' || $allPermission['Role Management'] == 'Role Management'
                                                )
                                                <h5 class="text-primary">{{ __('User Management') }} <input
                                                        type="checkbox" id="check-all-user-management"></h5>

                                                <label class="m-2">
                                                    <input class="m-2 all-user-management all" type="checkbox"
                                                        name="permission[]"
                                                        @if (isset($Permissioncheck['User Management']) &&
                                                                $Permissioncheck['User Management'] == $allPermission['User Management']
                                                        ) checked="checked" @endif
                                                        value="{{ $allPermission['User Management'] }}">{{ $allPermission['User Management'] }}</label>
                                               
                                                <label class="m-2">
                                                    <input class="m-2 all-user-management all" type="checkbox"
                                                        name="permission[]"
                                                        @if (isset($Permissioncheck['Role Management']) &&
                                                                $Permissioncheck['Role Management'] == $allPermission['Role Management']
                                                        ) checked="checked" @endif
                                                        value="{{ $allPermission['Role Management'] }}">{{ $allPermission['Role Management'] }}</label>
                                               
                                            @endif
                                        </div>

                                    </div>
                            
                                    <hr />
                                   
                                    @if ($errors->has('permission'))
                                        <span class="text-danger">{{ $errors->first('permission') }}</span>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mr-2">{{ __('Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // for select all
            $('#select-all').change(function() {
                $('.all').prop('checked', this.checked);
                let selectedValues = [];
                $('.all:checked').each(function() {
                    selectedValues.push($(this).val());
                });
                // print all values  
                console.log(selectedValues);

            });
            // for all user management
            $('#check-all-user-management').change(function() {
                $('.all-user-management').prop('checked', this.checked);
            });
        });
    </script>
    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')
@endsection
