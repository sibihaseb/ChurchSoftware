@extends('layouts.custom-master')

@section('styles')
    <!-- SWIPER CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endsection

@section('content')
@section('title', 'Register')
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
                        <p class="h5 fw-semibold mb-2">Sign Up</p>
                        <p class="mb-3 text-muted op-7 fw-normal">Welcome & Join us by creating a free account !</p>
                        {{-- <div class="btn-list">
                            <button class="btn btn-light"><svg class="google-svg" xmlns="http://www.w3.org/2000/svg"
                                    width="2443" height="2500" preserveAspectRatio="xMidYMid" viewBox="0 0 256 262">
                                    <path fill="#4285F4"
                                        d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" />
                                    <path fill="#34A853"
                                        d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" />
                                    <path fill="#FBBC05"
                                        d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" />
                                    <path fill="#EB4335"
                                        d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" />
                                </svg>Sign up with google</button>
                            <button class="btn btn-icon btn-light"><i class="ri-facebook-fill"></i></button>
                            <button class="btn btn-icon btn-light"><i class="ri-twitter-fill"></i></button>
                        </div>
                        <div class="text-center my-5 authentication-barrier">
                            <span>OR</span>
                        </div> --}}
                        <div class="row gy-3">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row gy-3">
                                    <!-- Existing Fields -->
                                    <div class="col-md-6">
                                        <label for="signup-name" class="form-label">First & Last Name</label>
                                        <input type="text" class="form-control" id="signup-name" name="name"
                                            placeholder="Enter your name">
                                        @error('name')
                                            <div class="mt-4 mb-4">
                                                <span class="alert-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="signup-email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="signup-email" name="email"
                                            placeholder="Email">
                                        @error('email')
                                            <div class="mt-4 mb-4">
                                                <span class="alert-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="signup-password" class="form-label text-default">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg"
                                                id="signup-password" placeholder="password" name="password">
                                            <button class="btn btn-light"
                                                onclick="createpassword('signup-password',this)" type="button"
                                                id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                        </div>
                                        @error('password')
                                            <div class="mt-4 mb-4">
                                                <span class="alert-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12 mb-3">
                                        <label for="signup-confirmpassword" class="form-label text-default">Confirm
                                            Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg"
                                                id="signup-confirmpassword" placeholder="confirm password"
                                                name="password_confirmation">
                                            <button class="btn btn-light"
                                                onclick="createpassword('signup-confirmpassword',this)" type="button"
                                                id="button-addon21"><i
                                                    class="ri-eye-off-line align-middle"></i></button>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label for="phone-number" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone-number" name="phone"
                                            placeholder="Phone Number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-control" id="country" name="country_id">
                                            <option value="">{{ __('Select Country') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">
                                                    {{ $country->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6" id="state-div" style="display: none;">
                                        <label for="state_id" class="form-label">State</label>
                                        <select class="form-control" id="state" name="state_id">
                                            <option value="">{{ __('Select State') }}</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}">
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    {{-- <div class="col-md-6">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            placeholder="City">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="zip" class="form-label">Postal Code</label>
                                        <input type="text" class="form-control" id="postal_code"
                                            name="postal_code" placeholder="Postal Code">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Street Address">
                                    </div> --}}
                                    {{-- <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="defaultCheck1">
                                        <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                            By creating a account you agree to our <a
                                                href="{{ url('terms-conditions') }}" class="text-success"><u>Terms
                                                    &
                                                    Conditions</u></a> and <a class="text-success"><u>Privacy
                                                    Policy</u></a>
                                        </label>
                                    </div> --}}
                                    <!-- Submission Button -->
                                    <div class="col-xl-12 d-grid mt-4">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="text-center">
                            <p class="fs-12 text-muted mt-4">Already have an account? <a href="{{ route('login') }}"
                                    class="text-primary">Sign In</a></p>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#country').select2({});
        $('#country').on('change', function() {
            var country_id = $(this).val();

            if (country_id == '1') {
                $('#state').select2({});
                $('#state-div').show();
            } else {
                if ($('#state').data('select2')) {
                    $('#state').select2('destroy'); // Destroy Select2 if initialized
                }
                $('#state-div').hide();
            }
        });
    </script>
@endsection
