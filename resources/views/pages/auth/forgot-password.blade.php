@extends('layouts.custom-master')

@section('styles')

    <!-- SWIPER CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/css/authentication.css') }}">
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
@section('title', 'Forgot Password')

@section('error-header')
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('build/assets/css/authentication.css') }}">

@endsection
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
                            <p class="h5 fw-semibold">Forgot Password</p>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <label class="form-label text-default d-block" for="email">Email Address</label>
                                <div class="input-group">
                                    <input type="email" placeholder="Enter Your Email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email" required>

                                    @error('email')
                                        <div class="mt-2">
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-12 d-grid mt-3">
                                    <button type="submit" class="btn btn-lg btn-primary w-100">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="text-primary">← Back to Login</a>
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
