@extends('layouts.master')

@section('styles')
    <!-- PRISM CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/prismjs/themes/prism-coy.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/libs/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/libs/quill/quill.bubble.css') }}">
    <!-- SELECT2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <nav class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('admin/budgets') }}">{{ __('Budget') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ isset($data) ? __('Update') : __('Create') }} {{ __('Budget') }}
                </li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            @if (Route::currentRouteNamed('budgets.create'))
                                {{ __('Create Budget') }}
                            @else
                                {{ __('Update Budget') }}
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <span id="form_result"></span>

                        <form method="POST"
                            action="{{ isset($data) ? route('budgets.update', $data->id) : route('budgets.store') }}"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @if (isset($data))
                                @method('PUT')
                            @endif

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <!-- Name Input -->
                                        <div class="col-lg-6">
                                            <label class="control-label" for="name">{{ __('Name') }} <span style="color: red;">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Enter name" value="{{ old('name', $data->name ?? '') }}" />
                                        </div>

                                        <!-- Amount Input -->
                                        <div class="col-lg-6">
                                            <label class="control-label" for="amount">{{ __('Amount') }} <span style="color: red;">*</span></label>
                                            <input type="text" name="amount" id="amount" class="form-control"
                                                placeholder="Enter amount" value="{{ old('amount', $data->amount ?? '') }}" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Departments Multi-Select -->
                                <div class="col-lg-12 mt-3">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="control-label">{{ __('Departments') }} <span style="color: red;">*</span></label>
                                            <select name="department_id[]" id="department_id" class="app_code_select" multiple="multiple">
                                                <option disabled>{{ __('Select') }}</option>
                                                @foreach ($departments as $department)
                                                    @php
                                                        $selected = collect(old('department_id', isset($data) ? explode(',', $data->department_id) : []))
                                                                    ->contains($department->id) ? 'selected' : '';
                                                    @endphp
                                                    <option value="{{ $department->id }}" {{ $selected }}>
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Budget Types Multi-Select -->
                                        <div class="col-lg-6">
                                            <label class="control-label">{{ __('Budget Types') }} <span style="color: red;">*</span></label>
                                            <select name="type_id[]" id="type_id" class="app_code_select" multiple="multiple">
                                                <option disabled>{{ __('Select') }}</option>
                                                @foreach ($types as $type)
                                                    @php
                                                        $selected = collect(old('type_id', isset($data) ? explode(',', $data->type_id) : []))
                                                                    ->contains($type->id) ? 'selected' : '';
                                                    @endphp
                                                    <option value="{{ $type->id }}" {{ $selected }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Purpose Textarea -->
                                <div class="col-lg-12 mt-4">
                                    <label class="control-label">{{ __('Purpose') }} <span style="color: red;">*</span></label>
                                    <textarea name="purpose" id="purpose" class="form-control" placeholder="Enter purpose" rows="3">{{ old('purpose', $data->purpose ?? '') }}</textarea>
                                </div>
                            </div>

                            <br />
                            <!-- Submit and Close Buttons -->
                            <div class="form-group text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    {{ __('Close') }}
                                </button>
                                <input type="submit" class="btn btn-warning" value="{{ isset($data) ? __('Update') : __('Add') }}" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- PRISM JS -->
    <script src="{{ asset('build/assets/libs/prismjs/prism.js') }}"></script>
    @vite('resources/assets/js/prism-custom.js')

    <!-- QUILL EDITOR JS -->
    <script src="{{ asset('build/assets/libs/quill/quill.min.js') }}"></script>

    <!-- SELECT2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
         $(".app_code_select").select2({
            tags: true,
            placeholder: "Select",
            maximumSelectionLength: 15,
        });
    </script>
@endsection
