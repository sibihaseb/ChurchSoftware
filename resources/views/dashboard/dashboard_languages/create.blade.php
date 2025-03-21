@extends('layouts.master')

@section('styles')
    <!-- PRISM CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/prismjs/themes/prism-coy.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid mt-2">
        <nav class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('dashboard/languages') }}">{{ __('All Languages') }}</a></li>
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
                            {{ __('Create Language') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <span id="form_result"></span>
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-red-600">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('dash.lang') }}" id="single_email_form"
                            class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="control-label col-md-4">{{ __('Title') }}<span
                                                    style="color: red;">*</span> :
                                            </label>
                                            <input type="text" name="title" id="title" class="form-control" />
                                            @error('title')
                                                <span class="text-danger fw-bold my-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="control-label col-md-4">{{ __('Code') }}<span
                                                    style="color: red;">*</span> :
                                            </label>
                                            <input type="text" name="code" id="code" class="form-control" />
                                            @error('code')
                                                <span class="text-danger fw-bold my-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <label class="control-label col-md-4">{{ __('Flag Image') }}</label>
                                            <div class="col-md-8">
                                                <input type="file" name="flag_image" id="flag_image"
                                                    class="form-control" />
                                                @error('flag_image')
                                                    <span class="text-danger fw-bold my-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="form-group" align="center">
                                <a href="{{ url('dashboard/languages') }}"
                                    class="btn btn-secondary">{{ __('Close') }}</a>
                                <button type="submit" class="btn btn-warning">{{ __('Add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
