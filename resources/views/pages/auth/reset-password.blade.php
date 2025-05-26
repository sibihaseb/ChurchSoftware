@extends('layouts.custom-master')

@section('styles')

    <!-- SWIPER CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}">
  <style>
        .authentication {
            min-height: 100vh;
            display: flex;
        }

        .authentication-cover {
            height: 100vh;
            overflow: hidden;
        }

        .authentication-image {
            width: 100%;
            height: 100%;
            object-fit: fill;
        }

        .swiper,
        .swiper-wrapper,
        .swiper-slide {
            height: 100%;
        }

        .authentication .authentication-cover .aunthentication-cover-content img {
            margin-top: 0;
        }
    </style>
@endsection

@section('content')
@section('title', 'Reset Password')
@section('error-body')

    <body class="bg-white">
    @endsection

    <div class="row authentication mx-0">

        <div class="col-xxl-6 col-xl-6 col-lg-12">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-xxl-6 col-xl-7 col-lg-7 col-md-7 col-sm-8 col-12">
                    <div class="p-5">
                        <div class="mb-3">
                            <a class="fs-1 fw-bold" href="{{ url('') }}">
                                {{ env('APP_NAME') }}
                            </a>
                        </div>
                        <div class="mb-4">
                            <p class="h5 fw-semibold">{{ __('Reset Password') }}</p>
                        </div>
                        <div class="row gy-3">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="col-xl-12 mt-0">
                                    <label for="email" class="form-label text-default">Email Address</label>
                                    <input type="email" class="form-control form-control-lg" id="email"
                                        name="email" required value="{{ old('email') }}"
                                        placeholder="Enter Your Email">
                                    @error('email')
                                        <div class="mt-4 mb-4">
                                            <span class="alert-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-12 mt-3">
                                    <label for="password" class="form-label text-default">New Password</label>
                                    <input type="password" class="form-control form-control-lg" id="password"
                                        name="password" required placeholder="Enter New Password">
                                    @error('password')
                                        <div class="mt-4 mb-4">
                                            <span class="alert-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-12 mt-3">
                                    <label for="password_confirmation" class="form-label text-default">Confirm
                                        Password</label>
                                    <input type="password" class="form-control form-control-lg"
                                        id="password_confirmation" name="password_confirmation" required
                                        placeholder="Confirm New Password">
                                </div>

                                <div class="col-xl-12 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Reset Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Image Side (Left) -->
        <div class="col-xxl-6 col-xl-6 col-lg-6 d-xl-block d-none px-0">
            <div class="authentication-cover">
                <div class="swiper keyboard-control h-100">
                    <div class="swiper-wrapper h-100">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/first.jpeg') }}" class="authentication-image" alt="">
                        </div>
                        {{-- <div class="swiper-slide">
                            <img src="{{ asset('images/second.jpeg') }}" class="authentication-image" alt="">
                        </div> --}}
                        <div class="swiper-slide">
                            <img src="{{ asset('images/third.jpeg') }}" class="authentication-image" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

    <!-- SWIPER JS -->
    <script src="{{ asset('build/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- INTERNAL AUTHENTICATION JS -->
    @vite('resources/assets/js/authentication.js')


    <!-- SHOW PASSWORD JS -->
    <script src="{{ asset('build/assets/show-password.js') }}"></script>

@endsection
