@extends('layouts.custom-master')

@section('styles')

    <!-- SWIPER CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}">

@endsection

@section('content')
@section('title', 'Reset Password')
@section('error-body')

    <body class="bg-white">
    @endsection

    <div class="row authentication mx-0">

        <div class="col-xxl-7 col-xl-7 col-lg-12">
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
        <div class="col-xxl-5 col-xl-5 col-lg-5 d-xl-block d-none px-0">
            <div class="authentication-cover">
                <div class="aunthentication-cover-content rounded">
                    <div class="swiper keyboard-control">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div
                                    class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="mb-5">
                                            <img src="{{ asset('images/54465.png') }}" class="authentication-image"
                                                alt="">
                                        </div>
                                        <h6 class="fw-semibold text-fixed-white">The Power of Donation</h6>
                                        <p class="fw-normal fs-14 op-7">Donations have the incredible ability to create
                                            meaningful change in the lives of individuals and communities. Whether it's
                                            providing essential resources like food, shelter, or medical care, donations
                                            help bridge the gap between scarcity and sufficiency. A simple act of giving
                                            can uplift those in need, providing hope and a chance for a better future.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="mb-5">
                                            <img src="{{ asset('images/10252702.png') }}" class="authentication-image"
                                                alt="">
                                        </div>
                                        <h6 class="fw-semibold text-fixed-white">Building Stronger Communities Through
                                            Giving</h6>
                                        <p class="fw-normal fs-14 op-7">When people come together to support a common
                                            cause, communities grow stronger and more united. Donations not only address
                                            immediate needs but also contribute to long-term solutions, such as
                                            educational programs and sustainable development projects. By donating,
                                            individuals become part of a collective effort to create a positive impact,
                                            making their communities more resilient and self-sustaining.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="mb-5">
                                            <img src="{{ asset('images/4125377.png') }}" class="authentication-image"
                                                alt="">
                                        </div>
                                        <h6 class="fw-semibold text-fixed-white">The Personal Rewards of Donating</h6>
                                        <p class="fw-normal fs-14 op-7">Beyond the tangible benefits to recipients,
                                            donating has a profound impact on the giver as well. It fosters a sense of
                                            empathy, purpose, and fulfillment. Knowing that one's contribution has the
                                            power to change lives can be deeply rewarding and motivating. Additionally,
                                            donating promotes a culture of kindness and generosity, inspiring others to
                                            give back and support meaningful causes.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
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
