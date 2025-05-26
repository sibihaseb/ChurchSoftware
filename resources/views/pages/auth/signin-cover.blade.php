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
@section('title', 'Login')
@section('error-body')

    <body class="bg-white">
    @endsection

    <div class="row authentication mx-0">
        <!-- Login Form Side (Right) -->
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
                            <p class="h5 fw-semibold">Sign In</p>
                        </div>
                        <div class="row gy-3">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="col-xl-12 mt-0">
                                    <label for="signin-email" class="form-label text-default">User Name</label>
                                    <input type="text" class="form-control form-control-lg" id="signin-email"
                                        placeholder="Enter Your email" name="email">
                                    @error('email')
                                        <div class="mt-4 mb-4">
                                            <span class="alert-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-12 mb-3 mt-3">
                                    <label for="signin-password" class="form-label text-default d-block">Password
                                        <a href="{{ route('password.request') }}" class="float-end text-danger">
                                            Forget password ?
                                        </a>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="signin-password"
                                            placeholder="password" name="password">
                                        <button class="btn btn-light" type="button"
                                            onclick="createpassword('signin-password',this)" id="button-addon2">
                                            <i class="ri-eye-off-line align-middle"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="mt-4 mb-4">
                                            <span class="alert-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                    @enderror
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="defaultCheck1">
                                            <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                                Remember password?
                                            </label>
                                        </div>
                                        <a href="{{ url('register') }}" class="text-primary">Sign Up</a>
                                    </div>
                                </div>
                                <div class="col-xl-12 d-grid mt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                    <a href="{{ route('church.signup') }}" class="btn btn-lg btn-primary mt-2">Register
                                        Church</a>
                                </div>
                            </form>
                        </div>
                        <div></div>
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
