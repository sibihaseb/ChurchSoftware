<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Donor Management Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI",
                Roboto, sans-serif;
        }

        body {
            color: #333;
            line-height: 1.6;
            background-color: #f9f9fb;
        }

        /* Container */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background-color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #6c5ce7;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .login-btn {
            margin-left: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c5ce7;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #5649c0;
        }

        .btn-white {
            display: inline-block;
            padding: 10px 20px;
            background-color: white;
            color: black;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            border: 1px solid #6c5ce7;
            border-color: #6c5ce7;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-white:hover {
            background-color: #5649c0;
            color: white;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid #6c5ce7;
            color: #6c5ce7;
        }

        .btn-outline:hover {
            background-color: #f0eeff;
        }

        /* Hero Section */
        .hero {
            padding: 80px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hero-content {
            flex: 1;
            padding-right: 40px;
        }

        .hero-image {
            flex: 1;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 42px;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #666;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .section-title p {
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            padding: 30px;
            border-radius: 10px;
            background-color: #f9f9fb;
        }

        .feature-card h3 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
        }

        /* Dashboard Section */
        .dashboard {
            padding: 80px 0;
        }

        .dashboard-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dashboard-text {
            flex: 1;
            padding-right: 40px;
        }

        .dashboard-image {
            flex: 1;
        }

        .dashboard-image img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-list {
            margin-top: 30px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .feature-icon {
            margin-right: 15px;
            color: #6c5ce7;
            font-size: 20px;
        }

        /* Stats Section */
        .stats {
            padding: 80px 0;
            background-color: #f0eeff;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 50px;
        }

        .stat-card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #6c5ce7;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #666;
        }

        /* Management Section */
        .management {
            padding: 80px 0;
        }

        .management-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 50px;
        }

        .management-card {
            text-align: center;
            padding: 30px;
        }

        .management-icon {
            width: 60px;
            height: 60px;
            background-color: #f0eeff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #6c5ce7;
            font-size: 24px;
        }

        /* Filtering Section */
        .filtering {
            padding: 80px 0;
            background-color: white;
        }

        .filtering-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .filtering-text {
            flex: 1;
            padding-right: 40px;
        }

        .filtering-image {
            flex: 1;
        }

        .filtering-image img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Profiles Section */
        .profiles {
            padding: 80px 0;
        }

        /* Reporting Section */
        .reporting {
            padding: 80px 0;
            background-color: white;
        }

        /* CTA Section */
        .cta {
            padding: 80px 0;
            text-align: center;
            background-color: #f0eeff;
        }

        .cta h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .cta p {
            max-width: 700px;
            margin: 0 auto 40px;
            color: #666;
        }

        /* Footer */
        footer {
            background-color: #2d3748;
            color: white;
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .footer-about {
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .footer-social {
            display: flex;
            gap: 15px;
        }

        .footer-social a {
            color: white;
            text-decoration: none;
        }

        .footer-heading {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid #4a5568;
            padding-top: 30px;
            text-align: center;
            color: #cbd5e0;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 992px) {

            .features-grid,
            .stats-grid,
            .management-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {

            .hero,
            .dashboard-content,
            .filtering-content {
                flex-direction: column;
            }

            .hero-content,
            .dashboard-text,
            .filtering-text {
                padding-right: 0;
                margin-bottom: 40px;
            }

            h1 {
                font-size: 32px;
            }

            .features-grid,
            .stats-grid,
            .management-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">Donorsmile</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
            <div class="login-btn">
                <a href="{{ route('login') }}" style="text-decoration: none; margin-right:10px">Login</a>
                <a href="{{ route('register') }}" class="btn">Sign Up</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div style="display: flex">
                <div class="hero-content">
                    <h1>Simplify Your Donor Management</h1>
                    <p>
                        Track, manage, and engage with donors all in one place. Boost your
                        fundraising with intelligent donor insights.
                    </p>
                    <a href="#" class="btn">Get Started</a>
                    <a href="#" class="btn-white" style="margin-left: 10px"> <i
                            class="ri ri-play-circle-line"></i>
                        Watch Demo</a>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('assets/image/hero-img.png') }}" alt="Donor Management Dashboard" />
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Powerful Features for Donor Management</h2>
                <p>
                    Everything you need to track, manage, and engage with your donors
                    effectively.
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <img src="{{ asset('assets/image/user-heart.svg') }}" />
                    <h3>Donor Tracking</h3>
                    <p>
                        Keep track of all your donors and their donation history. Get
                        insights into donor behavior and preferences.
                    </p>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('assets/image/camp-manage.svg') }}" />
                    <h3>Campaign Management</h3>
                    <p>
                        Create and manage fundraising campaigns with ease. Track progress
                        and optimize your campaigns.
                    </p>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('assets/image/reporting.svg') }}" />
                    <h3>Donor Reporting</h3>
                    <p>
                        Generate comprehensive reports on your fundraising efforts. Get
                        insights into your donor base and campaign performance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Section -->
    <section class="dashboard">
        <div class="container">
            <div class="dashboard-content">
                <div class="dashboard-text">
                    <h2>Powerful Dashboard at Your Fingertips</h2>
                    <p>
                        Get a complete overview of your fundraising efforts with our
                        intuitive dashboard. Track donations, donor engagement, and
                        campaign progress all in one place.
                    </p>
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Real-time Donation Metrics</h4>
                                <p>Track donations as they come in with real-time updates.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Donor Activity Tracking</h4>
                                <p>
                                    Monitor donor engagement and activity to identify your most
                                    valuable supporters.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Smart Filtering Options</h4>
                                <p>
                                    Filter and segment your donor base to create targeted
                                    campaigns.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashboard-image">
                    <img src="{{ asset('assets/image/powerfuldashboard.png') }}" />
                </div>
            </div>
        </div>
    </section>

    <!-- Management Section -->
    <section class="management">
        <div class="container">
            <div class="section-title">
                <h2>Everything You Need to Manage Donors</h2>
                <p>
                    Our comprehensive donor management platform provides all the tools
                    you need to track, manage, and grow your donor base.
                </p>
            </div>
            <div class="management-grid">
                <div class="management-card">
                    <div class="management-icon"><img src="{{ asset('assets/image/DIV-261.svg') }}" /></div>
                    <h3>Donor Records</h3>
                    <p>
                        Store, access, and update donor information in a secure and
                        organized database.
                    </p>
                </div>
                <div class="management-card">
                    <div class="management-icon"><img src="{{ asset('assets/image/DIV-272.svg') }}" /></div>
                    <h3>Donor Management</h3>
                    <p>
                        Manage your donor relationships with ease. Track interactions and
                        engagement.
                    </p>
                </div>
                <div class="management-card">
                    <div class="management-icon"><img src="{{ asset('assets/image/DIV-283.svg') }}" /></div>
                    <h3>Donation Tracking</h3>
                    <p>
                        Record and track all donations. Generate tax receipts and
                        acknowledgments.
                    </p>
                </div>
                <div class="management-card">
                    <div class="management-icon"><img src="{{ asset('assets/image/DIV-294.svg') }}" /></div>
                    <h3>Donor Donation Tracking</h3>
                    <p>
                        Understand your donors' giving history and patterns to improve
                        fundraising strategies.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filtering Section -->
    <section class="filtering">
        <div class="container">
            <div class="filtering-content">
                <div class="filtering-text">
                    <h2>Smart Filtering System</h2>
                    <p>
                        Our advanced filtering system allows you to segment your donor
                        base and create targeted campaigns.
                    </p>
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Multiple Filtering Options</h4>
                                <p>
                                    Filter donors by donation amount, frequency, location, and
                                    more.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Saved Filters</h4>
                                <p>
                                    Save your commonly used filters for quick access to your
                                    segmented donor lists.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Export Filtered Lists</h4>
                                <p>
                                    Export your filtered donor lists for use in other
                                    applications or for offline analysis.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filtering-image">
                    <img src="{{ asset('assets/image/smart-filter.png') }}" />
                </div>
            </div>
        </div>
    </section>

    <!-- Profiles Section -->
    <section class="filtering">
        <div class="container">
            <div class="filtering-content">
                <div class="filtering-image">
                    <img src="{{ asset('assets/image/comprehensive.png') }}" width="90%" />
                </div>
                <div class="filtering-text" style="padding-left: 40px">
                    <h2>Comprehensive Donor Profiles</h2>
                    <p>
                        Get a complete view of each donor, including their giving history,
                        preferences, and engagement.
                    </p>
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Complete Donation History</h4>
                                <p>
                                    View a complete history of each donor's contributions and
                                    engagement.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Contact Preferences</h4>
                                <p>
                                    Track each donor's preferred communication channels and
                                    frequency.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Relationship Notes</h4>
                                <p>
                                    Add notes and reminders to keep track of your interactions
                                    with each donor.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Reporting Section -->
    <section class="filtering">
        <div class="container">
            <div class="filtering-content">
                <div class="filtering-text">
                    <h2>Powerful Reporting Tools</h2>
                    <p>
                        Generate comprehensive reports that provide valuable insights into
                        your fundraising efforts.
                    </p>
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Customizable Reports</h4>
                                <p>
                                    Create custom reports that focus on the metrics that matter
                                    most to your organization.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Real-time Dashboards</h4>
                                <p>
                                    Monitor your fundraising progress in real-time with
                                    interactive dashboards.
                                </p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <h4>Exportable Reports</h4>
                                <p>
                                    Export your reports in various formats for presentation and
                                    analysis.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filtering-image">
                    <img src="{{ asset('assets/image/reportingtool.png') }}" />
                </div>
            </div>
        </div>
    </section>


    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <h2>Making a Difference Together</h2>
            <p>
                Join thousands of organizations who are making a difference with our
                donor management platform.
            </p>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">$42M+</div>
                    <div class="stat-label">Donations Processed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">5,400+</div>
                    <div class="stat-label">Active Organizations</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Customer Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" style="background-color: white">
        <div class="container">
            <div style="display: flex;">
                <div class="hero-content">
                    <h1>Start Managing Your Donors Smarter</h1>
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <p>Complete donor tracking and management</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <p>Powerful reporting and analytics</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <p>Smart donor filtering and segmentation</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <div>
                                <p>14-day free trial, no credit card required</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('assets/image/DIV-944.png') }}" alt="CTA Image" />
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo">Donorsmile</div>
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
