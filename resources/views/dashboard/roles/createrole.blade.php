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
                <li class="breadcrumb-item active" aria-current="page"> {{ __('Create Role') }}
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            {{ __('Create Role') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('addrole') }}">
                            @csrf
                            <div class="col-lg-12">
                                <div class="form-group mb-2">
                                    <label>{{ __('Role Name') }}</label>
                                    <input type="text" name="rolename" class="form-control" id="rolename"
                                        placeholder="Enter Unique Role Name">
                                </div>
                                @if ($errors->has('rolename'))
                                    <div class="form-group">
                                        <span class="text-danger">{{ $errors->first('rolename') }}</span>
                                    </div>
                                @endif

                                <div class="form-group mt-4">
                                    <label>{{ __('Permissions') }} <input type="checkbox" id="select-all"></label>
                                </div>
                                <div class="form-group">
                                    <hr />
                                    <div class="row">
                                        <div class="col-lg-4 border-end border-2">
                                            @if ($allPermission['User Management'] == 'User Management' || $allPermission['Role Management'] == 'Role Management')
                                                <h5 class="text-primary">{{ __('User Management') }} <input type="checkbox"
                                                        id="check-all-user-management"></h5>

                                                <label class="m-2">
                                                    <input class="m-2 all-user-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['User Management'] }}">{{ $allPermission['User Management'] }}</label>
                                                <label class="m-2">
                                                    <input class="m-2 all-user-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Role Management'] }}">{{ $allPermission['Role Management'] }}</label>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 border-end border-2">
                                            @if ($allPermission['Church Management'] == 'Church Management')
                                                <h5 class="text-primary">{{ __('Church Management') }} <input
                                                        type="checkbox" id="check-all-church-management"></h5>

                                                <label class="m-2">
                                                    <input class="m-2 all-church-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Church Management'] }}">{{ $allPermission['Church Management'] }}</label>
                                                <label class="m-2">
                                                    <input class="m-2 all-church-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Language Management'] }}">{{ $allPermission['Language Management'] }}</label>
                                                <label class="m-2">
                                                    <input class="m-2 all-church-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Country Management'] }}">{{ $allPermission['Country Management'] }}</label>
                                                <label class="m-2">
                                                    <input class="m-2 all-church-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['State Management'] }}">{{ $allPermission['State Management'] }}</label>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 border-end border-2">
                                            @if ($allPermission['Account Management'] == 'Account Management')
                                                <h5 class="text-primary">{{ __('Account Management') }} <input
                                                        type="checkbox" id="check-all-account-management"></h5>

                                                <label class="m-2">
                                                    <input class="m-2 all-account-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Account Management'] }}">{{ $allPermission['Account Management'] }}</label>
                                                <label class="m-2">
                                                    <input class="m-2 all-account-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Deposit Account Management'] }}">{{ $allPermission['Deposit Account Management'] }}</label>
                                                <label class="m-2">
                                                    <input class="m-2 all-account-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Payment Method Management'] }}">{{ $allPermission['Payment Method Management'] }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-lg-4 border-end border-2">
                                            @if ($allPermission['Product Management'] == 'Product Management')
                                                <h5 class="text-primary">{{ __('Product Management') }} <input
                                                        type="checkbox" id="check-all-product-management"></h5>

                                                <label class="m-2">
                                                    <input class="m-2 all-product-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Product Management'] }}">{{ $allPermission['Product Management'] }}</label>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 border-end border-2">
                                            @if ($allPermission['Donor Management'] == 'Donor Management')
                                                <h5 class="text-primary">{{ __('Donor Management') }} <input
                                                        type="checkbox" id="check-all-donar-management"></h5>

                                                <label class="m-2">
                                                    <input class="m-2 all-donor-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Donor Management'] }}">{{ $allPermission['Donor Management'] }}</label>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 border-end border-2">
                                            @if ($allPermission['Department Management'] == 'Department Management')
                                                <h5 class="text-primary">{{ __('Department Management') }} <input
                                                        type="checkbox" id="check-all-department-management"></h5>

                                                <label class="m-2">
                                                    <input class="m-2 all-department-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Department Management'] }}">{{ $allPermission['Department Management'] }}</label>
                                                <label class="m-2">
                                                    <input class="m-2 all-department-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Expense Management'] }}">{{ $allPermission['Expense Management'] }}</label>
                                                <label class="m-2">
                                                    <input class="m-2 all-department-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Budget Management'] }}">{{ $allPermission['Budget Management'] }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-lg-4 border-end border-2">
                                            @if ($allPermission['Donation Management'] == 'Donation Management')
                                                <h5 class="text-primary">{{ __('Donation Management') }} <input
                                                        type="checkbox" id="check-all-donation-management"></h5>

                                                <label class="m-2">
                                                    <input class="m-2 all-donation-management all" type="checkbox"
                                                        name="permission[]"
                                                        value="{{ $allPermission['Donation Management'] }}">{{ $allPermission['Donation Management'] }}</label>
                                            @endif
                                        </div>
                                    </div>
                                    <hr />
                                </div>
                                @if ($errors->has('permission'))
                                    <div class="form-group">
                                        <span class="text-danger">{{ $errors->first('permission') }}</span>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success mr-2">{{ __('Submit') }}</button>
                                </div>
                            </div>
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
            });
            // for all user management
            $('#check-all-user-management').change(function() {
                $('.all-user-management').prop('checked', this.checked);
            });
            // for all Church Management
            $('#check-all-church-management').change(function() {
                $('.all-church-management').prop('checked', this.checked);
            });
            // for all Account Management
            $('#check-all-account-management').change(function() {
                $('.all-account-management').prop('checked', this.checked);
            });
            // for all Product Management
            $('#check-all-product-management').change(function() {
                $('.all-product-management').prop('checked', this.checked);
            });
            // for all Donor Management
            $('#check-all-donar-management').change(function() {
                $('.all-donor-management').prop('checked', this.checked);
            });
            // for all Department Management
            $('#check-all-department-management').change(function() {
                $('.all-department-management').prop('checked', this.checked);
            });
            // for all donation Management
            $('#check-all-donation-management').change(function() {
                $('.all-donation-management').prop('checked', this.checked);
            });
        });
    </script>
    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')
@endsection
