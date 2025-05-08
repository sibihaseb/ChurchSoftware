@extends('layouts.front-header')

@section('title', 'Privacy Policy')

@section('content')
    <style>
        .hero-section {
            background: #6c5ce7;
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 36px;
            margin-bottom: 15px;
        }

        .hero-content p {
            font-size: 16px;
            max-width: 800px;
            margin: 0 auto;
        }

        .page-content {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            font-size: 16px;
            line-height: 1.7;
            color: #333;
        }

        .page-content h2 {
            margin-top: 30px;
            font-size: 22px;
            color: #222;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 28px;
            }

            .hero-content p {
                font-size: 14px;
            }
        }
    </style>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Privacy Policy</h1>
            <p>Your privacy is important to us. This policy outlines how we collect, use, and protect your information.</p>
        </div>
    </div>

    <div class="page-content">
        <h2>1. Information We Collect</h2>
        <p>
            We collect personal information that you provide to us such as name, email address, and contact details.
            We also collect data automatically through cookies and analytics tools to improve our services.
        </p>

        <h2>2. How We Use Your Information</h2>
        <p>
            Your information is used to provide and improve our services, respond to inquiries, send updates or
            promotional content, and comply with legal obligations.
        </p>

        <h2>3. Sharing of Information</h2>
        <p>
            We do not sell or rent your personal data. We may share information with trusted third parties who assist
            us in operating our website, conducting business, or servicing you, as long as those parties agree to keep
            this information confidential.
        </p>

        <h2>4. Cookies and Tracking</h2>
        <p>
            Our website uses cookies to enhance your browsing experience. You can choose to disable cookies through
            your browser settings, but this may affect the functionality of the website.
        </p>

        <h2>5. Data Security</h2>
        <p>
            We implement security measures to protect your personal data, including encryption and secure servers.
            However, no method of transmission over the internet is 100% secure.
        </p>

        <h2>6. Your Rights</h2>
        <p>
            You have the right to access, update, or delete your personal data. To exercise these rights, please contact us
            at privacy@yourdomain.com.
        </p>

        <h2>7. Changes to This Policy</h2>
        <p>
            We may update this privacy policy from time to time. We encourage users to frequently check this page for
            any changes.
        </p>
    </div>
@endsection
