@extends('layouts.front-header')
@section('content')
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
                    <a href="{{ route('church.signup') }}" class="btn">Get Started</a>
                    <a href="#" class="btn-white" style="margin-left: 10px"> <i class="ri ri-play-circle-line"></i>
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
@endsection
