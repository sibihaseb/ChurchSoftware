@extends('layouts.front-header')

@section('styles')
    <style>
        .contact-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            display: flex;
            gap: 40px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .left-section {
            flex: 1;
            min-width: 300px;
        }

        .left-section img {
            width: 100%;
            border-radius: 5px;
        }

        .contact-info {
            background: #ffffff;
            border-radius: 10px;
            color: #000000;
            padding: 20px;
            margin-top: 10px;
            padding-top: 25px;
            padding-bottom: 55px;
        }

        .contact-info h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .contact-info p {
            font-size: 14px;
            margin-bottom: 6px;
        }

        .about-section {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .about-section h2 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .about-section p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .form-section {
            flex: 1;
            min-width: 300px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .form-section h2 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        form textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #5b42f3;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #422ce0;
        }

        .success-message {
            background-color: #e6ffed;
            border: 1px solid #a4f3bd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            color: #267a40;
        }

        @media (max-width: 768px) {
            .contact-wrapper {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <!-- 👇 Add this Hero Header Section -->
    <div style="background-color: #f9f9fb; padding: 20px 20px; text-align: center;">
        <h1 style="font-size: 36px; color: #333; margin-bottom: 15px;">Get In Touch</h1>
        <p style="font-size: 16px; color: #666; max-width: 800px; margin: 0 auto;">
            We’d love to hear from you! Whether you have a question about features, pricing, or anything else,
            our team is ready to answer all your questions.
        </p>
    </div>
    <div class="contact-wrapper">

        <div class="left-section">
            <!-- Top Image -->
            <div class="about-image">
                <img src="{{ asset('assets/image/agent2.jpg') }}" alt="About Us Image">
            </div>

            <!-- About Section -->
            {{-- <div class="about-section">
                <h2>About Our Company</h2>
                <p>
                    We help nonprofits and organizations manage their donors and fundraising efforts more effectively.
                </p>
                <p>
                    Our platform is designed to simplify donation tracking, enhance communication with supporters,
                    and give you insights that drive growth. Whether you're running a small community initiative or a
                    large-scale nonprofit,
                    we provide the tools to make your fundraising smarter and more impactful.
                </p>
                <p>
                    Contact us today to learn how we can support your mission.
                </p>
            </div> --}}

            <!-- Inquiry Info -->
            {{-- <div class="contact-info">
                <h3>Email Us</h3>
                <p>General Inquiries: <a href="mailto:info@donorsmile.com">info@donorsmile.com</a></p>
                <p>Support: <a href="mailto:info@donorsmile.com">info@donorsmile.com</a></p>
            </div> --}}
        </div>


        {{-- Form Section --}}
        <div class="form-section">
            <h2>Send Us a Message</h2>

            @if (session('success'))
                <div id="successMessage" class="success-message">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" placeholder="Full Name" value="{{ old('name') }}"
                    required>
                @error('name')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}"
                    required>
                @error('email')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <label for="subject">Subject</label>
                <input type="text" name="subject" id="subject" placeholder="Subject" value="{{ old('subject') }}"
                    required>
                @error('subject')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <label for="message">Your Message</label>
                <textarea name="message" id="message" placeholder="Your Message" required>{{ old('message') }}</textarea>
                @error('message')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 10000);
            }
        });
    </script>
@endsection
