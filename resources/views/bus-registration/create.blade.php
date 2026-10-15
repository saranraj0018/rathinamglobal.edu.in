@extends('layouts.base')

@section('title', 'New Air Conditioned Bus Service | Rathinam Global Deemed to be University')
@section('description', 'Ride Smart. Ride Comfort. Ride AC. Introducing the brand new Air Conditioned Bus Service by Rathinam Global Deemed to be University. Reserve your seat today!')

@push('head')
  <meta name="theme-color" content="#2c146c">

  <!-- Google Fonts: Poppins & Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

  <script src="https://unpkg.com/lucide@1.28.0/dist/umd/lucide.min.js" defer></script>

  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="{{ versioned_asset('css/acbus/style.css') }}">

  <!-- Cloudflare Turnstile Official API -->
  <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endpush

@section('body')
  <!-- Scroll Progress Indicator Bar -->
  <div class="scroll-progress-bar" id="scrollProgressBar"></div>

  <!-- Announcement Top Bar -->
  <div class="top-bar">
    <div class="container">
      <div class="top-bar-message">
        <span class="top-bar-badge">New Launch</span>
        <span class="top-bar-tail"><strong>Rathinam AC Bus Service</strong> — Special Early Bird Offer for the First 300 Students!</span>
      </div>
      <div class="top-bar-contact">
        
      </div>
    </div>
  </div>

  <!-- Main Navigation Header -->
  <header class="navbar" id="mainNavbar">
    <div class="container navbar-container">
      <a href="#hero" class="navbar-brand" aria-label="Rathinam Global Deemed to be University — home">
        <!-- Logo SVG Representation for Rathinam University -->
        <svg width="42" height="42" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
          <defs>
            <linearGradient id="brandMark" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="#4a238a"/>
              <stop offset="100%" stop-color="#2c146c"/>
            </linearGradient>
          </defs>
          <rect width="100" height="100" rx="24" fill="url(#brandMark)"/>
          <path d="M30 25H70V42C70 53.0457 61.0457 62 50 62C38.9543 62 30 53.0457 30 42V25Z" fill="#F58220"/>
          <circle cx="50" cy="42" r="12" fill="#FFC72C"/>
          <path d="M50 62L68 80H32L50 62Z" fill="#FFFFFF"/>
        </svg>
        <span class="brand-text">
          <span class="brand-name">RATHIN<span>A</span>M</span>
          <span class="brand-sub">Global Deemed to be University</span>
        </span>
      </a>

      <ul class="nav-menu" id="navMenu">
        <li><a href="#features" class="nav-link">Features</a></li>
        <li><a href="#why-choose" class="nav-link">Why AC Bus</a></li>
        <li><a href="#experience" class="nav-link">Timeline</a></li>
        <li><a href="#comparison" class="nav-link">Comparison</a></li>
        <li><a href="#earlybird" class="nav-link">Early Bird</a></li>
        <li><a href="#feedback" class="nav-link">Feedback</a></li>
        <li><a href="#faq" class="nav-link">FAQ</a></li>
        <li class="mobile-only-item"><a href="#reserve" class="nav-cta-btn">Register Now</a></li>
      </ul>

      <a href="#reserve" class="nav-cta-btn header-cta-desktop">Register Now</a>

      <button class="mobile-nav-toggle" id="mobileNavToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="navMenu">
        <i data-lucide="menu" class="icon-open"></i>
        <i data-lucide="x" class="icon-close"></i>
      </button>
    </div>
  </header>

  <div class="nav-backdrop" id="navBackdrop" hidden></div>

  <!-- Hero Section -->
  <section class="hero" id="hero">
    <div class="container hero-grid">
      <!-- Left Column: Title, Subtitle, Bus Image with Overlap & Floating Badges -->
      <div class="hero-content">
        <div class="campaign-badge" data-reveal>
          <i data-lucide="sparkles"></i> A Move Towards Comfort, Care &amp; Campus Excellence
        </div>

        <h1 class="hero-title" data-reveal style="--reveal-delay:80ms">
          Ride Smart.<br>
          Ride Comfort.<br>
          <span class="highlight-orange">Ride AC.</span>
        </h1>

        <p class="hero-description" data-reveal style="--reveal-delay:160ms">
          Introducing our new Air Conditioned Bus Service — because your journey matters as much as your destination.
        </p>

        <div class="hero-actions" data-reveal style="--reveal-delay:240ms">
          <a href="#reserve" class="btn-primary">
            Register Now <i data-lucide="arrow-right"></i>
          </a>
          <a href="#features" class="btn-secondary">
            Learn More <i data-lucide="chevron-down"></i>
          </a>
        </div>

        <!-- AC Bus Graphic Container with 3D Overlap & Floating Badges -->
        <div class="hero-bus-wrapper" data-reveal style="--reveal-delay:320ms">
          <div class="hero-bus-image-box">
            <!-- Modern AC coach photograph -->
            <img src="{{ storage_asset('acbus/assets/images/bus.png') }}" alt="Rathinam Global University AC bus service coach" class="hero-bus-img" decoding="async">
            <div class="bus-overlay-tag">
              <i data-lucide="badge-check"></i> Rathinam Official Fleet 2026
            </div>
          </div>

          <!-- Animated Floating AC Icons (reflow into a static row on small screens) -->
          <div class="hero-bus-badges">
            <div class="floating-icon-badge badge-ac">
              <i data-lucide="snowflake"></i> Fully Air Conditioned
            </div>
            <div class="floating-icon-badge badge-wifi">
              <i data-lucide="wifi"></i> Free Wi-Fi Onboard
            </div>
            <div class="floating-icon-badge badge-gps">
              <i data-lucide="map-pin"></i> Live GPS Tracking
            </div>
            <div class="floating-icon-badge badge-charger">
              <i data-lucide="zap"></i> C-Type Phone Chargers
            </div>
          </div>
        </div>

        <!-- Key Features Grid (Relocated to hero section left of form) -->
        <div class="hero-features-strip" data-reveal style="--reveal-delay:400ms">
          <div class="hero-features-grid" data-reveal-stagger>
            <div class="hero-feature-item" data-reveal>
              <div class="hero-feature-icon"><i data-lucide="user-check"></i></div>
              <span class="hero-feature-text">Designed for Students</span>
            </div>
            <div class="hero-feature-item" data-reveal>
              <div class="hero-feature-icon"><i data-lucide="clock-4"></i></div>
              <span class="hero-feature-text">Reliable Transport</span>
            </div>
            <div class="hero-feature-item" data-reveal>
              <div class="hero-feature-icon"><i data-lucide="building-2"></i></div>
              <span class="hero-feature-text">Campus Connectivity</span>
            </div>
            <div class="hero-feature-item" data-reveal>
              <div class="hero-feature-icon"><i data-lucide="sparkles"></i></div>
              <span class="hero-feature-text">Comfort First</span>
            </div>
            <div class="hero-feature-item" data-reveal>
              <div class="hero-feature-icon"><i data-lucide="navigation"></i></div>
              <span class="hero-feature-text">GPS Enabled</span>
            </div>
            <div class="hero-feature-item" data-reveal>
              <div class="hero-feature-icon"><i data-lucide="leaf"></i></div>
              <span class="hero-feature-text">Eco Friendly</span>
            </div>
          </div>
        </div>

        <!-- Commute Highlights Card (Fills remaining vertical space left of form) -->
        <div class="hero-benefits-card" data-reveal style="--reveal-delay:480ms">
          <div class="benefits-card-header">
            <h3 class="benefits-title">Why Upgrade to the AC Bus?</h3>
            <div class="benefits-badge"><i data-lucide="sparkles"></i> Commute Highlights</div>
          </div>

          <div class="benefits-list">
            <div class="benefit-item">
              <div class="benefit-icon-box"><i data-lucide="thermometer-snowflake"></i></div>
              <div class="benefit-info">
                <strong>21°C Climate Controlled Cabin</strong>
                <span>Beat Coimbatore's 34°C+ heat &amp; arrive 100% fresh for morning lectures.</span>
              </div>
            </div>

            <div class="benefit-item">
              <div class="benefit-icon-box"><i data-lucide="zap"></i></div>
              <div class="benefit-info">
                <strong>Fast C-Type Charging &amp; Wi-Fi</strong>
                <span>Keep your laptop &amp; smartphone fully charged while studying on the go.</span>
              </div>
            </div>

            <div class="benefit-item">
              <div class="benefit-icon-box"><i data-lucide="shield-check"></i></div>
              <div class="benefit-info">
                <strong>Live GPS Tracking &amp; 360° CCTV</strong>
                <span>Know exact bus arrival times on your phone app with complete safety.</span>
              </div>
            </div>
          </div>

          <div class="benefits-footer">
           
          </div>
        </div>
      </div>

      <!-- Right Column: Registration Card Form -->
      <div class="hero-form-card" id="reserve" data-reveal style="--reveal-delay:120ms">
        <div class="form-header">
          <h2 class="form-title">Reserve Your Seat</h2>
          <p class="form-subtitle">Register interest for the new AC Bus Service</p>
          <span class="form-seats-left">
            <i data-lucide="flame"></i> Only 300 Early Bird seats
          </span>
        </div>

        <form class="registration-form" id="heroRegistrationForm" novalidate>
          <div class="form-group">
            <label for="fullName">Full Name <span class="req" aria-hidden="true">*</span></label>
            <input type="text" id="fullName" name="fullName" class="form-control" placeholder="e.g. Rahul Sharma" autocomplete="name" pattern="[A-Za-z\s.'-]+" title="Please enter letters only. Numbers are not allowed." required>
            <span class="error-text" id="fullNameError" role="alert"></span>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="studentId">Student / Roll ID <span class="req" aria-hidden="true">*</span></label>
              <input type="text" id="studentId" name="studentId" class="form-control" placeholder="e.g. 23BCS042" required>
              <span class="error-text" id="studentIdError" role="alert"></span>
            </div>

            <div class="form-group">
              <label for="department">Department <span class="req" aria-hidden="true">*</span></label>
              <input type="text" id="department" name="department" class="form-control" placeholder="e.g. Computer Science" pattern="[A-Za-z\s.&'-]+" title="Please enter letters only. Numbers are not allowed." required>
              <span class="error-text" id="departmentError" role="alert"></span>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="phoneNumber">Phone Number <span class="req" aria-hidden="true">*</span></label>
              <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="10-digit Mobile" inputmode="numeric" autocomplete="tel" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit mobile number." required>
              <span class="error-text" id="phoneNumberError" role="alert"></span>
            </div>

            <div class="form-group">
              <label for="email">University Email <span class="req" aria-hidden="true">*</span></label>
              <input type="email" id="email" name="email" class="form-control" placeholder="student@rathinam.in" autocomplete="email" autocapitalize="none" spellcheck="false" pattern="[a-z0-9._%+-]+@rathinam\.in" title="Please enter your official university email ending with @rathinam.in." required>
              <span class="error-text" id="emailError" role="alert"></span>
            </div>
          </div>

          <fieldset class="form-group form-fieldset">
            <legend>Are you interested in upgrading to AC Bus? <span class="req" aria-hidden="true">*</span></legend>
            <div class="radio-group">
              <label class="radio-option opt-in-option">
                <input type="checkbox" name="acUpgrade" id="acUpgrade" value="Yes"> Yes
              </label>
            </div>
            <p class="ac-gate-note" id="acGateNote">
              <i data-lucide="info"></i>
              Tick <strong>Yes</strong> to choose your route and pickup stop, then register.
            </p>
          </fieldset>

          <!-- Everything below is gated on the AC upgrade answer above. -->
          <div class="ac-dependent" id="acDependentFields">
            <div class="form-group">
              <label for="busNo">Existing Bus No. / Pass No. <span class="opt-text">(If available)</span></label>
              <input type="text" id="busNo" name="busNo" class="form-control" placeholder="e.g. Bus 12 / Pass No." disabled>
              <span class="error-text" id="busNoError" role="alert"></span>
            </div>

            <!-- Route is chosen first; it determines which stops are offered. -->
            <div class="form-group">
              <label for="preferredRoute">Preferred Route <span class="req" id="routeReq" aria-hidden="true">*</span></label>
              <select id="preferredRoute" name="preferredRoute" class="form-control" disabled required>
                <option value="">Select your route</option>
              </select>
              <span class="error-text" id="preferredRouteError" role="alert"></span>
            </div>

            <div class="form-group">
              <label for="pickupLocation">Pickup Location <span class="req" id="pickupReq" aria-hidden="true">*</span></label>
              <select id="pickupLocation" name="pickupLocation" class="form-control" disabled required>
                <option value="">Select a route first</option>
              </select>
              <span class="form-hint" id="pickupHint">Stops are listed for your selected route.</span>
              <span class="error-text" id="pickupLocationError" role="alert"></span>
            </div>
          </div>

          <fieldset class="form-group form-fieldset ac-dependent" id="earlyBirdFieldset">
            <legend>Will You Register for Early Bird Offer?</legend>
            <div class="radio-group">
              <label class="radio-option">
                <input type="radio" name="earlyBirdOffer" value="Yes" checked> Yes
              </label>
              <label class="radio-option">
                <input type="radio" name="earlyBirdOffer" value="No"> No
              </label>
            </div>
          </fieldset>

          <!-- Anti-Spam Honeypot (Hidden from real users, tricks spam bots) -->
          <input type="text" name="website_hp" id="websiteHp" style="display:none !important;" tabindex="-1" autocomplete="off">

          <!-- Cloudflare Turnstile Security CAPTCHA Widget -->
          <div class="turnstile-wrapper">
            <div class="cf-turnstile" data-sitekey="{{ config('rgu.bus_registration.turnstile_site_key') }}" data-callback="onTurnstileSuccess" data-expired-callback="onTurnstileExpired" data-error-callback="onTurnstileError" data-theme="light"></div>
            <span class="error-text" id="turnstileError" role="alert"></span>
          </div>

          <button type="submit" class="btn-submit" id="submitBtn">
            <span class="spinner" id="btnSpinner"></span>
            <span id="btnText">Submit Response</span>
          </button>

          <p class="form-footnote">
            <i data-lucide="lock"></i> Your details are used only for transport planning.
          </p>
        </form>

        <!-- Dynamic Success Card Message -->
        <div class="form-success-message" id="formSuccessMessage" role="status">
          <div class="success-icon-box">
            <i data-lucide="check" style="width:34px; height:34px;"></i>
          </div>
          <h3 class="success-title" id="successTitle">Response Submitted!</h3>
          <p class="success-desc" id="successDesc">
            Thank you for submitting your response. Your details have been recorded.
          </p>
          <div class="ac-features-pop" id="acFeaturesPop" style="display:none;">
            <div class="pop-features-grid">
              <div class="pop-feature-item"><i data-lucide="snowflake"></i> 21°C Climate Control</div>
              <div class="pop-feature-item"><i data-lucide="wifi"></i> Free Onboard Wi-Fi</div>
              <div class="pop-feature-item"><i data-lucide="zap"></i> C-Type Fast Charger</div>
              <div class="pop-feature-item"><i data-lucide="shield-check"></i> GPS &amp; CCTV Safety</div>
            </div>
          </div>
          <a href="#features" class="btn-secondary" style="margin-top:1.25rem;">Explore AC Features</a>
        </div>
      </div>
    </div>
  </section>



  <!-- Features Section -->
  <section class="features-section section-padding" id="features">
    <div class="container">
      <div class="section-header" data-reveal>
        <span class="section-tag">Premium Amenities</span>
        <h2 class="section-title">Features That Make Every Ride Awesome</h2>
        <p class="section-subtitle">Engineered specifically to give students a relaxed, productive and comfortable commute.</p>
      </div>

      <div class="features-grid" data-reveal-stagger>
        <div class="feature-card" data-reveal>
          <div class="feature-icon-wrapper">
            <i data-lucide="snowflake"></i>
          </div>
          <h3 class="feature-title">Fully Air Conditioned</h3>
          <p class="feature-description">
            Experience optimal 21°C climate control throughout your daily commute, keeping heat, dust and humidity away.
          </p>
        </div>

        <div class="feature-card" data-reveal>
          <div class="feature-icon-wrapper">
            <i data-lucide="armchair"></i>
          </div>
          <h3 class="feature-title">Spacious &amp; Comfy Seats</h3>
          <p class="feature-description">
            Ergonomic high-back cushioned seats with ample legroom, designed for maximum relaxation and posture support.
          </p>
        </div>

        <div class="feature-card" data-reveal>
          <div class="feature-icon-wrapper">
            <i data-lucide="zap"></i>
          </div>
          <h3 class="feature-title">USB Type-C Charging</h3>
          <p class="feature-description">
            Dedicated fast-charging C-Type ports at every seat row, so your laptop and phone never run out of juice.
          </p>
        </div>

        <div class="feature-card" data-reveal>
          <div class="feature-icon-wrapper">
            <i data-lucide="wifi"></i>
          </div>
          <h3 class="feature-title">Free Wi-Fi on Board</h3>
          <p class="feature-description">
            High-speed campus Wi-Fi connectivity on the go. Complete assignments, stream lectures or catch up on news.
          </p>
        </div>

        <div class="feature-card" data-reveal>
          <div class="feature-icon-wrapper">
            <i data-lucide="shield-check"></i>
          </div>
          <h3 class="feature-title">CCTV Surveillance</h3>
          <p class="feature-description">
            360-degree HD CCTV security monitoring ensures safety and peace of mind for every student and staff member.
          </p>
        </div>

        <div class="feature-card" data-reveal>
          <div class="feature-icon-wrapper">
            <i data-lucide="map-pin"></i>
          </div>
          <h3 class="feature-title">GPS Tracking</h3>
          <p class="feature-description">
            Live bus location tracking integrated with the university student app, so you never miss your pickup time.
          </p>
        </div>

        <div class="feature-card is-wide" data-reveal>
          <div class="feature-icon-wrapper">
            <i data-lucide="leaf"></i>
          </div>
          <div>
            <h3 class="feature-title">Eco-Friendly &amp; Smooth Ride</h3>
            <p class="feature-description">
              BS-VI compliant engines with modern suspension deliver a whisper-quiet cabin and a minimal carbon footprint — comfort that is kinder to Coimbatore's air.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Choose AC Bus (Zig-Zag Layout) -->
  <section class="why-section section-padding" id="why-choose">
    <div class="container">
      <div class="section-header" data-reveal>
        <span class="section-tag">The Rathinam Difference</span>
        <h2 class="section-title">Why You'll Love The AC Bus Experience</h2>
        <p class="section-subtitle">Say goodbye to sweaty morning travel and start your academic day energised and refreshed.</p>
      </div>

      <div class="zigzag-container">
        <!-- Row 1 -->
        <div class="zigzag-row">
          <div class="zigzag-image-box" data-reveal>
            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80" alt="Students studying comfortably together" class="zigzag-img" loading="lazy" decoding="async">
            <span class="zigzag-badge">Cool &amp; Refreshing</span>
          </div>
          <div class="zigzag-content" data-reveal style="--reveal-delay:120ms">
            <h3 class="zigzag-title">No More Heat, Sweat or Travel Hassles</h3>
            <p class="zigzag-description">
              Coimbatore summers can be exhausting. Our AC bus service ensures you arrive at lectures cool, composed and ready to learn — eliminating heat exhaustion from daily travel.
            </p>
            <ul class="zigzag-list">
              <li class="zigzag-list-item">
                <span class="zigzag-list-icon"><i data-lucide="check"></i></span>
                Climate controlled 21°C cabin temperature
              </li>
              <li class="zigzag-list-item">
                <span class="zigzag-list-icon"><i data-lucide="check"></i></span>
                Dust-free &amp; quiet interior for peaceful commuting
              </li>
              <li class="zigzag-list-item">
                <span class="zigzag-list-icon"><i data-lucide="check"></i></span>
                Arrive energised for early morning lectures
              </li>
            </ul>
          </div>
        </div>

        <!-- Row 2 (Reversed) -->
        <div class="zigzag-row reverse">
          <div class="zigzag-image-box" data-reveal>
            <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?auto=format&fit=crop&w=800&q=80" alt="University campus connection" class="zigzag-img" loading="lazy" decoding="async">
            <span class="zigzag-badge">Student First</span>
          </div>
          <div class="zigzag-content" data-reveal style="--reveal-delay:120ms">
            <h3 class="zigzag-title">Punctual, Reliable &amp; Student-Friendly Service</h3>
            <p class="zigzag-description">
              Designed by the university, for your future. Schedules are synchronised with class hours, guaranteeing timely arrival and stress-free evening return trips.
            </p>
            <ul class="zigzag-list">
              <li class="zigzag-list-item">
                <span class="zigzag-list-icon"><i data-lucide="check"></i></span>
                Synchronised with the Rathinam timetable
              </li>
              <li class="zigzag-list-item">
                <span class="zigzag-list-icon"><i data-lucide="check"></i></span>
                Special Early Bird discount for the first 300 registrations
              </li>
              <li class="zigzag-list-item">
                <span class="zigzag-list-icon"><i data-lucide="check"></i></span>
                Full CCTV safety coverage &amp; trained professional drivers
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Experience Section (Animated Timeline) -->
  <section class="timeline-section section-padding" id="experience">
    <div class="container">
      <div class="section-header" data-reveal>
        <span class="section-tag">A Day In The Life</span>
        <h2 class="section-title">Your Daily Journey Reimagined</h2>
        <p class="section-subtitle">Follow how the Rathinam AC Bus transforms a student's daily routine from sunrise to sunset.</p>
      </div>

    </div>
  </section>

  <!-- Comfort Comparison Matrix -->
  <section class="comparison-section section-padding" id="comparison">
    <div class="container">
      <div class="section-header" data-reveal>
        <span class="section-tag">Head To Head</span>
        <h2 class="section-title">Regular Bus vs Rathinam AC Bus</h2>
        <p class="section-subtitle">Compare the side-by-side specs and see why upgrading your commute is the best decision for your semester.</p>
      </div>

      <div class="comparison-table-wrapper" data-reveal>
        <table class="comparison-table">
          <thead>
            <tr>
              <th class="col-feature" scope="col">Feature / Attribute</th>
              <th class="col-regular" scope="col">Regular Bus Service</th>
              <th class="col-ac" scope="col">
                <span class="th-inner">Rathinam AC Bus <span class="th-pill">Recommended</span></span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="feature-name"><span class="cell"><i data-lucide="thermometer-snowflake"></i> Cabin Temperature</span></td>
              <td class="regular-val"><span class="badge-cross"><i data-lucide="x"></i> Hot &amp; Humid (34°C+)</span></td>
              <td class="ac-val"><span class="badge-check"><i data-lucide="check"></i> 21°C Climate Controlled</span></td>
            </tr>
            <tr>
              <td class="feature-name"><span class="cell"><i data-lucide="armchair"></i> Seat Quality &amp; Comfort</span></td>
              <td class="regular-val"><span class="badge-cross"><i data-lucide="x"></i> Standard Hard Benches</span></td>
              <td class="ac-val"><span class="badge-check"><i data-lucide="check"></i> Ergonomic Plush Cushioning</span></td>
            </tr>
            <tr>
              <td class="feature-name"><span class="cell"><i data-lucide="battery-charging"></i> Phone Charging Ports</span></td>
              <td class="regular-val"><span class="badge-cross"><i data-lucide="x"></i> No Charging Outlets</span></td>
              <td class="ac-val"><span class="badge-check"><i data-lucide="check"></i> Dedicated USB Type-C Ports</span></td>
            </tr>
            <tr>
              <td class="feature-name"><span class="cell"><i data-lucide="wifi"></i> Onboard Wi-Fi</span></td>
              <td class="regular-val"><span class="badge-cross"><i data-lucide="x"></i> Not Available</span></td>
              <td class="ac-val"><span class="badge-check"><i data-lucide="check"></i> High-Speed Campus Wi-Fi</span></td>
            </tr>
            <tr>
              <td class="feature-name"><span class="cell"><i data-lucide="map-pin"></i> Live GPS Tracking</span></td>
              <td class="regular-val"><span class="badge-cross"><i data-lucide="x"></i> Manual Phone Updates</span></td>
              <td class="ac-val"><span class="badge-check"><i data-lucide="check"></i> Real-time App Location</span></td>
            </tr>
            <tr>
              <td class="feature-name"><span class="cell"><i data-lucide="shield-check"></i> Security &amp; Monitoring</span></td>
              <td class="regular-val"><span class="badge-cross"><i data-lucide="x"></i> Basic Manual Watch</span></td>
              <td class="ac-val"><span class="badge-check"><i data-lucide="check"></i> 360° HD CCTV Cameras</span></td>
            </tr>
            <tr>
              <td class="feature-name"><span class="cell"><i data-lucide="smile"></i> Student Energy &amp; Focus</span></td>
              <td class="regular-val"><span class="badge-cross"><i data-lucide="x"></i> Drained &amp; Tired</span></td>
              <td class="ac-val"><span class="badge-check"><i data-lucide="check"></i> Energised &amp; Ready to Study</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="table-scroll-hint"><i data-lucide="move-horizontal"></i> Swipe the table sideways to see every column</p>
    </div>
  </section>

  <!-- Statistics Counters -->
  <section class="stats-section">
    <div class="container stats-grid">
      <div class="stat-card">
        <div class="stat-number" data-target="100" data-suffix="%">0%</div>
        <div class="stat-label">Air Conditioned Fleet</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" data-target="24" data-suffix="/7">0/7</div>
        <div class="stat-label">GPS &amp; CCTV Security</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" data-target="300" data-suffix="+">0+</div>
        <div class="stat-label">Early Bird Seats</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" data-target="35" data-suffix="+">0+</div>
        <div class="stat-label">Coimbatore Routes</div>
      </div>
    </div>
  </section>

  <!-- Early Bird Offer Banner -->
  <section class="earlybird-section" id="earlybird">
    <div class="container">
      <div class="earlybird-card" data-reveal>
        <div class="earlybird-ribbon">Limited Seats</div>

        <div class="earlybird-content">
          <span class="section-tag">Be An Early Bird</span>
          <h2 class="earlybird-title">Special Offer For The First 300 Registrations</h2>
          <p class="earlybird-subtitle">
            Lock in priority seat allocation, a free onboard Wi-Fi pass and a discounted semester transport fee when you register today.
          </p>

          <!-- Countdown Timer -->

          <a href="#reserve" class="btn-primary">
            Claim Your Early Bird Seat <i data-lucide="arrow-right"></i>
          </a>
        </div>

        <!-- Offer panel — fills the column that previously rendered empty -->
        <aside class="offer-panel">
          <div class="offer-panel-head">
            <span class="offer-panel-label">Seats Claimed</span>
            <span class="offer-panel-count" id="seatCount">0 / 300</span>
          </div>
          <div class="seat-meter">
            <div class="seat-meter-fill" id="seatMeterFill" data-fill="62"></div>
          </div>
          <p class="seat-meter-note">Allocation closes once all Early Bird seats are taken.</p>

          <div class="offer-perks">
            <div class="offer-perk">
              <i data-lucide="check"></i> Priority route &amp; seat allocation
            </div>
            <div class="offer-perk">
              <i data-lucide="check"></i> Complimentary onboard Wi-Fi pass
            </div>
            <div class="offer-perk">
              <i data-lucide="check"></i> Discounted semester transport fee
            </div>
            <div class="offer-perk">
              <i data-lucide="check"></i> First access to new route requests
            </div>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <!-- Student Feedback Section -->

  <!-- QR Code Section -->

  <!-- FAQ Accordion Section -->
  <section class="faq-section section-padding" id="faq">
    <div class="container">
      <div class="section-header" data-reveal>
        <span class="section-tag">Got Questions?</span>
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p class="section-subtitle">Everything you need to know about the Rathinam AC Bus upgrade.</p>
      </div>

      <div class="faq-wrapper" data-reveal-stagger>
        <div class="faq-item active" data-reveal>
          <button class="faq-question" id="faqq1" aria-expanded="true" aria-controls="faqa1">
            <span>Why should I upgrade to the AC Bus Service?</span>
            <i data-lucide="chevron-down" class="faq-icon"></i>
          </button>
          <div class="faq-answer" id="faqa1" role="region" aria-labelledby="faqq1">
            <div class="faq-answer-inner">
              The AC bus service is engineered to eliminate travel fatigue, sweat and dust during Coimbatore's hot months. With 21°C climate control, high-speed Wi-Fi, USB Type-C charging ports and ergonomic seats, you can study or relax comfortably during your daily commute.
            </div>
          </div>
        </div>

        <div class="faq-item" data-reveal>
          <button class="faq-question" id="faqq2" aria-expanded="false" aria-controls="faqa2">
            <span>Who is eligible to register for the AC Bus?</span>
            <i data-lucide="chevron-down" class="faq-icon"></i>
          </button>
          <div class="faq-answer" id="faqa2" role="region" aria-labelledby="faqq2">
            <div class="faq-answer-inner">
              All registered undergraduate and postgraduate students, research scholars, faculty and administrative staff members of Rathinam Group of Institutions are eligible.
            </div>
          </div>
        </div>

        <div class="faq-item" data-reveal>
          <button class="faq-question" id="faqq3" aria-expanded="false" aria-controls="faqa3">
            <span>Which routes are covered by the AC Bus fleet?</span>
            <i data-lucide="chevron-down" class="faq-icon"></i>
          </button>
          <div class="faq-answer" id="faqa3" role="region" aria-labelledby="faqq3">
            <div class="faq-answer-inner">
              Routes cover major Coimbatore corridors including Gandhipuram, Hope College, Singanallur, Ukkadam, Saravanampatti, Thudiyalur, Eachanari and Peelamedu. Detailed route maps are shared upon seat confirmation.
            </div>
          </div>
        </div>

        <div class="faq-item" data-reveal>
          <button class="faq-question" id="faqq4" aria-expanded="false" aria-controls="faqa4">
            <span>How does the live GPS tracking feature work?</span>
            <i data-lucide="chevron-down" class="faq-icon"></i>
          </button>
          <div class="faq-answer" id="faqa4" role="region" aria-labelledby="faqq4">
            <div class="faq-answer-inner">
              Each AC bus is fitted with an active GPS device synced with the Rathinam Student Mobile App. You can view live bus movement, estimated time of arrival (ETA) and traffic alerts in real time.
            </div>
          </div>
        </div>

        <div class="faq-item" data-reveal>
          <button class="faq-question" id="faqq5" aria-expanded="false" aria-controls="faqa5">
            <span>What is the fee structure for the AC Bus?</span>
            <i data-lucide="chevron-down" class="faq-icon"></i>
          </button>
          <div class="faq-answer" id="faqa5" role="region" aria-labelledby="faqq5">
            <div class="faq-answer-inner">
              The AC bus fee is structured affordably per semester. Early Bird registrants (the first 300 students) receive an exclusive fee concession. Fee details will be shared directly with your registered email.
            </div>
          </div>
        </div>

        <div class="faq-item" data-reveal>
          <button class="faq-question" id="faqq6" aria-expanded="false" aria-controls="faqa6">
            <span>Can I modify my pickup location after registering?</span>
            <i data-lucide="chevron-down" class="faq-icon"></i>
          </button>
          <div class="faq-answer" id="faqa6" role="region" aria-labelledby="faqq6">
            <div class="faq-answer-inner">
              Yes. Pickup stop modifications can be requested through the Transport Office at any time before the academic semester starts.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA Banner -->
  <section class="final-cta-section">
    <div class="container">
      <h2 class="final-cta-title" data-reveal>Ready to Ride Better?</h2>
      <p class="final-cta-desc" data-reveal style="--reveal-delay:100ms">
        Upgrade your campus journey today. Secure your seat in Rathinam's new Air Conditioned Bus fleet.
      </p>
      <a href="#reserve" class="btn-primary" data-reveal style="--reveal-delay:200ms">
        Register Interest Today <i data-lucide="sparkles"></i>
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="navbar-brand">
            <svg width="38" height="38" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
              <rect width="100" height="100" rx="24" fill="#F58220"/>
              <path d="M30 25H70V42C70 53.0457 61.0457 62 50 62C38.9543 62 30 53.0457 30 42V25Z" fill="#FFFFFF"/>
              <circle cx="50" cy="42" r="12" fill="#FFC72C"/>
            </svg>
            <span class="brand-text">
              <span class="brand-name">RATHIN<span>A</span>M</span>
              <span class="brand-sub">Global Deemed to be University</span>
            </span>
          </div>
          <p class="footer-desc">
            Rathinam Techzone, Pollachi Main Road, Eachanari, Coimbatore, Tamil Nadu 641021. Empowering minds, transforming futures.
          </p>
        </div>

        <div>
          <h4 class="footer-title">Quick Links</h4>
          <ul class="footer-links">
            <li><a href="#hero">Home</a></li>
            <li><a href="#features">AC Amenities</a></li>
            <li><a href="#why-choose">Why AC Bus</a></li>
            <li><a href="#experience">Daily Timeline</a></li>
            <li><a href="#comparison">Specs Comparison</a></li>
            <li><a href="#reserve">Seat Registration</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-title">Connect With Us</h4>
          <p class="footer-note">
            Follow Rathinam University on social media for live transport &amp; campus updates.
          </p>
          <!-- Brand marks are inlined: Lucide v1 removed its social icon set. -->
          <div class="social-links">
            <a href="https://www.facebook.com/rathinamglobal/" target="_blank" rel="noopener" class="social-icon" aria-label="Rathinam University on Facebook">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="https://www.instagram.com/rathinam_global/" target="_blank" rel="noopener" class="social-icon" aria-label="Rathinam University on Instagram">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
            </a>
            <a href="https://x.com/rathinamgroups" target="_blank" rel="noopener" class="social-icon" aria-label="Rathinam University on X, formerly Twitter">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932 6.064-6.933zm-1.291 19.49h2.039L6.486 3.24H4.298l13.312 17.403z"/></svg>
            </a>
            <a href="https://www.linkedin.com/company/rathinam-global/" target="_blank" rel="noopener" class="social-icon" aria-label="Rathinam University on LinkedIn">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </a>
            <a href="https://www.youtube.com/user/RathinamCollege" target="_blank" rel="noopener" class="social-icon" aria-label="Rathinam University on YouTube">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <div>&copy; 2026 Rathinam Global Deemed to be University. All Rights Reserved.</div>
        <div class="footer-hashtags">
          New Bus. Better Experience. Brighter You. #RideBetter #RathinamMovesWithYou
        </div>
      </div>
    </div>
  </footer>

  <!-- Floating Mobile Sticky CTA Button -->
  <a href="#reserve" class="floating-mobile-cta" id="floatingCta">
    <i data-lucide="bus"></i> Register for AC Bus
  </a>

  <!-- Immediate AC Bus Features Modal Popup -->
  <div class="features-modal" id="featuresModal" aria-hidden="true" role="dialog" aria-labelledby="modalTitle">
    <div class="features-modal-backdrop" id="modalBackdrop"></div>
    <div class="features-modal-card">
      <button type="button" class="modal-close-btn" id="modalCloseBtn" aria-label="Close features preview">
        <i data-lucide="x"></i>
      </button>

      <div class="modal-header">
        <span class="modal-badge"><i data-lucide="sparkles"></i> PREMIUM UPGRADE AMENITIES</span>
        <h3 class="modal-title" id="modalTitle">Rathinam AC Bus Experience</h3>
        <p class="modal-subtitle">Here is what you get when you upgrade your daily campus commute:</p>
      </div>

      <div class="modal-features-grid">
        <div class="modal-feature-card">
          <div class="modal-feature-icon"><i data-lucide="snowflake"></i></div>
          <div>
            <div class="modal-feature-name">21°C Climate Control</div>
            <div class="modal-feature-desc">Cool, dust-free cabin all season long.</div>
          </div>
        </div>

        <div class="modal-feature-card">
          <div class="modal-feature-icon"><i data-lucide="wifi"></i></div>
          <div>
            <div class="modal-feature-name">Free Onboard Wi-Fi</div>
            <div class="modal-feature-desc">High-speed connectivity for studying &amp; music.</div>
          </div>
        </div>

        <div class="modal-feature-card">
          <div class="modal-feature-icon"><i data-lucide="zap"></i></div>
          <div>
            <div class="modal-feature-name">C-Type Fast Chargers</div>
            <div class="modal-feature-desc">Dedicated ports at every seat row.</div>
          </div>
        </div>

        <div class="modal-feature-card">
          <div class="modal-feature-icon"><i data-lucide="navigation"></i></div>
          <div>
            <div class="modal-feature-name">Live GPS Tracking</div>
            <div class="modal-feature-desc">Real-time bus tracking via mobile app.</div>
          </div>
        </div>

        <div class="modal-feature-card">
          <div class="modal-feature-icon"><i data-lucide="shield-check"></i></div>
          <div>
            <div class="modal-feature-name">360° HD CCTV Safety</div>
            <div class="modal-feature-desc">Continuous monitoring for peace of mind.</div>
          </div>
        </div>

        <div class="modal-feature-card">
          <div class="modal-feature-icon"><i data-lucide="armchair"></i></div>
          <div>
            <div class="modal-feature-name">Plush Ergonomic Seats</div>
            <div class="modal-feature-desc">High-back cushioning with ample legroom.</div>
          </div>
        </div>
      </div>

      <button type="button" class="modal-cta-btn" id="modalConfirmBtn">
        Got It, Complete Registration <i data-lucide="arrow-right"></i>
      </button>
    </div>
  </div>

  <!-- Toast Notification Container -->
  <div class="toast-container" id="toastContainer" aria-live="polite"></div>

  <!-- Custom Script -->
  <!-- Route/stop data, generated from the tariff workbook. Must load first. -->
  <script>
    window.AC_BUS_ROUTES = @js($routes);
    window.RGU_BUS_CONFIG = {
      submitUrl: @js(route('bus-registration.store')),
      csrfToken: @js(csrf_token()),
    };
  </script>
  <script src="{{ versioned_asset('js/acbus/script.js') }}" defer></script>
@endsection
