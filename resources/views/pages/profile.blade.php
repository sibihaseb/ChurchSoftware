@extends('layouts.master')

@section('styles')
    <!-- GLIGHTBOX CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/glightbox/css/glightbox.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">{{ __('Profile') }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('Pages') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xxl-4 col-xl-12">
                <div class="card custom-card overflow-hidden">
                    @foreach ($result as $user)
                        <div class="card-body p-0">
                            <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">

                                <div class="flex-fill main-profile-info">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <h6 class="fw-semibold mb-1 text-fixed-white">{{ $user->name }}</h6>

                                    </div>
                                </div>
                            </div>

                            <div class="p-4 border-bottom border-block-end-dashed">
                                <p class="fs-15 mb-2 me-4 fw-semibold">Contact Information :</p>
                                <div class="text-muted">
                                    <p class="mb-2">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="ri-mail-line align-middle fs-14"></i>
                                        </span>
                                        {{ $user->email }}
                                    </p>
                                    <p class="mb-2">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="ri-phone-line align-middle fs-14"></i>
                                        </span>
                                        {{ $user->phone }}
                                    </p>
                                </div>
                            </div>



                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xxl-8 col-xl-12">
                <div class="row">

                    <div class="col-xl-12 col-xl-">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">
                                    {{ __('Update Profile') }}
                                    @if (session('success'))
                                        <div class="alert alert-success" id="hide">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger" id="hide">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">
                                <form id="sample_form" action="{{ url('/admin/profileupdate') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @foreach ($result as $user)
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <div class="me-2 fw-semibold">
                                                        {{ __('Name') }} :
                                                    </div>
                                                    <input type="text" class="form-control" name="name"
                                                        aria-describedby="text"
                                                        value="{{ old('name') ?? ($user->name ?? '') }}">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <div class="me-2 fw-semibold">
                                                        {{ __('Email') }} :
                                                    </div>
                                                    <input type="email" class="form-control" name="email"
                                                        aria-describedby="text"
                                                        value="{{ old('email') ?? ($user->email ?? '') }}">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <div class="me-2 fw-semibold">
                                                        {{ __('Phone') }} :
                                                    </div>
                                                    <input type="text" class="form-control" name="phone"
                                                        aria-describedby="text"
                                                        value="{{ old('phone') ?? ($user->phone ?? '') }}">
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <div class="me-2 fw-semibold">
                                                        {{ __('Please Enter New Password') }} :
                                                    </div>
                                                    <input type="password" class="form-control" name="password"
                                                        id="password" aria-describedby="text">
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <div class="me-2 fw-semibold">
                                                        {{ __('Please Confirm Password') }} :
                                                    </div>
                                                    <input type="password" class="form-control" name="password_confirmation"
                                                        id="password_confirmation" aria-describedby="text">
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </li>
                                        </ul>
                                    @endforeach
                                    <button type="submit" class="btn btn-success mt-3">{{ __('Update') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--End::row-1 -->

    </div>
@endsection

@section('scripts')
    <!-- GLIGHTBOX JS -->
    <script src="{{ asset('build/assets/libs/glightbox/js/glightbox.min.js') }}"></script>

    <!-- INTERNAL PROFILE JS -->
    @vite('resources/assets/js/profile.js')
    <script>
        setTimeout(() => {
            const div = document.getElementById('hide');
            div.style.display = 'none';
        }, 5000);
    </script>
@endsection
