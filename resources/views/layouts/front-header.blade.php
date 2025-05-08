<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Donor Management Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    @yield('styles')
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo"><a href="/" style="text-decoration: none">Donorsmile</a></div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="{{ route('contact.create') }}">Contact</a></li>
                </ul>
            </nav>
            <div class="login-btn">
                <a href="{{ route('login') }}" style="text-decoration: none; margin-right:10px">Login</a>
                <a href="{{ route('register') }}" class="btn">Sign Up</a>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo"><a href="/"
                            style="text-decoration: none; color: white">Donorsmile</a></div>
                    <p class="footer-about">
                        We help nonprofits and organizations manage their donors and
                        fundraising efforts more effectively.
                    </p>
                    <div class="footer-social">
                        <a href="#">FB</a>
                        <a href="#">TW</a>
                        <a href="#">IG</a>
                        <a href="#">LI</a>
                    </div>
                </div>
                <div>
                    <h4 class="footer-heading">Company</h4>
                    <ul class="footer-links">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-heading">Resources</h4>
                    <ul class="footer-links">
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-heading">Legal</h4>
                    <ul class="footer-links">
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Donor Management Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
