@extends('layouts.base')

@section('title', 'Professional Certificate in ESG Courses | School of Sustainability & Climate Studies')
@section('description', 'Professional Certificate in ESG & Sustainability Reporting — a 10-week, 60+ hour industry-oriented programme from the School of Sustainability & Climate Studies, Rathinam Global University.')

@push('head')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">
  
  <link rel="icon" type="image/png" href="{{ storage_asset('esg/images/favicon.png') }}">

  <link rel="stylesheet" href="{{ storage_asset('esg/style-new2.css') }}">
  
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PXEJG51JZ0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PXEJG51JZ0');
</script>
@endpush

@section('body')
  <!-- HEADER / NAVBAR -->
  <header class="site-header">
    <nav class="navbar container" aria-label="Primary">

      <a class="navbar__brand" href="#top"
        aria-label="School of Sustainability and Climate Studies — Rathinam Global University">
        <img class="navbar__logo" src="{{ storage_asset('esg/images/partner-1.png') }}" alt="School of Sustainability and Climate Studies Logo">
        <span class="navbar__brand-divider" aria-hidden="true"></span>
        <img class="navbar__logo navbar__logo--rgu" src="{{ storage_asset('esg/images/logo-rgu.png') }}" alt="Rathinam Global University Logo">
      </a>

      <ul class="navbar__links" id="primary-nav">
        <li><a href="https://rathinamglobal.edu.in/esg" class="navbar__esg-btn">ESG Course</a></li>
        <li><a href="https://rathinamglobal.edu.in/esia/">ESIA Course</a></li>
      </ul>

      <div class="navbar__actions">
        <a class="btn btn--outline btn--sm" href="#enrollment" data-brochure>Download Brochure</a>
        <a class="btn btn--dark btn--sm" href="https://aicraise.accubate.app/ext/survey/17928/apply" target="_blank">
          Apply Now
          <svg class="icon icon--arrow" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M5 12h14M13 6l6 6-6 6" />
          </svg>
        </a>
      </div>

      <button class="navbar__toggle" type="button" aria-expanded="false" aria-controls="mobile-nav"
        aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </nav>

    <!-- Mobile navigation -->
    <div class="mobile-nav" id="mobile-nav" hidden>
      <ul class="mobile-nav__links">
        <li><a href="https://rathinamglobal.edu.in/esg" class="navbar__esg-btn">ESG Course</a></li>
        <li><a href="https://rathinamglobal.edu.in/esia/">ESIA Course</a></li>
        <li><a href="#journey">Learning Journey</a></li>
        <li><a href="#curriculum">Curriculum</a></li>
        <li><a href="#experience">Beyond the Classroom</a></li>
        <li><a href="#faculty">Faculty</a></li>
        <li><a href="#testimonials">Testimonials</a></li>
        <li><a href="#partners">Partners</a></li>
        <li><a href="#fees">Fees &amp; Offers</a></li>
        <li><a href="#faq">FAQs</a></li>
      </ul>
      <div class="mobile-nav__actions">
        <a class="btn btn--outline" href="#enrollment" data-brochure>Download Brochure</a>
        <a class="btn btn--dark" href="https://aicraise.accubate.app/ext/survey/17928/apply" target="_blank">Apply Now</a>
      </div>
    </div>
  </header>

  <main id="top">

    <!-- 1. HERO -->
    <section class="hero" aria-labelledby="hero-title">
      <div class="container hero__grid">

        <div class="hero__content">
          <p class="hero__eyebrow">Industry-Oriented Professional Certificate</p>

          <h1 class="hero__title" id="hero-title">
            Professional<br>
            Certificate in <em>ESG and Sustainability Reporting</em><br>

          </h1>

          <ul class="hero__pills">
            <li class="pill">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7v5l3 2" />
              </svg>
              Real-World Projects
            </li>
            <li class="pill">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3 3 7.5 12 12l9-4.5L12 3Z" />
                <path d="M3 12.5 12 17l9-4.5" />
                <path d="M3 17 12 21.5 21 17" />
              </svg>
              Industry-Led Learning
            </li>
            <li class="pill">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="9" r="5" />
                <path d="M8.5 13.5 7 21l5-2.5L17 21l-1.5-7.5" />
              </svg>
              Career-Focused Curriculum
            </li>
            <li class="pill">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9" />
                <path d="M3 12h18M12 3c2.5 3 2.5 15 0 18M12 3c-2.5 3-2.5 15 0 18" />
              </svg>
              University Certificate
            </li>
          </ul>

          <p class="hero__lead">
            Build practical expertise in ESG reporting, sustainability frameworks, and responsible
            business practices through industry-led learning, real-world case studies, and hands-on
            projects designed for today's sustainability professionals.
          </p>

          <div class="hero__actions">
            <a class="btn btn--gold btn--lg" href="#enrollment">
              Register Interest
              <svg class="icon icon--arrow" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 12h14M13 6l6 6-6 6" />
              </svg>
            </a>
            <a class="btn btn--ghost btn--lg" href="#enrollment" data-brochure>
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3v12M7 11l5 5 5-5M4 20h16" />
              </svg>
              Download Brochure
            </a>
          </div>
        </div>

        <!-- Hero enquiry form -->
        <div class="lead-card">
          <h2 class="lead-card__title">Request Information</h2>
          <p class="lead-card__text">
            Learn more about the programme. Our admissions team will contact you within 24 hours to
            answer your questions and guide you through the next steps.
          </p>

          <form class="lead-form" novalidate data-lead-form data-form-name="ESG Hero Form">
            <div class="field">
              <label class="sr-only" for="hero-name">Full Name</label>
              <input id="hero-name" name="name" type="text" placeholder="Full Name*" required>
              <p class="field__error" data-error></p>
            </div>
            <div class="field">
              <label class="sr-only" for="hero-email">Email Address</label>
              <input id="hero-email" name="email" type="email" placeholder="Email Address*" required>
              <p class="field__error" data-error></p>
            </div>
            <div class="field">
              <label class="sr-only" for="hero-phone">Mobile Number</label>
              <input id="hero-phone" name="phone" type="tel" placeholder="Mobile Number*" required>
              <p class="field__error" data-error></p>
            </div>
            <div class="field field--select">
              <label class="sr-only" for="hero-role">Current Role / Profession</label>
              <select id="hero-role" name="role" required>
                <option value="" selected disabled>Current Role / Profession*</option>
                <option>Student</option>
                <option>Recent Graduate</option>
                <option>Working Professional</option>
                <option>Consultant</option>
                <option>Entrepreneur</option>
                <option>Researcher / Academic</option>
                <option>Government Professional</option>
              </select>
              <svg class="field__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="m6 9 6 6 6-6" />
              </svg>
              <p class="field__error" data-error></p>
            </div>
            <div class="field">
              <label class="sr-only" for="hero-org">Current Organization / Institution</label>
              <input id="hero-org" name="organisation" type="text" placeholder="Current Organization / Institution">
              <p class="field__error" data-error></p>
            </div>
            <div class="field field--select">
              <label class="sr-only" for="hero-programme">Programme of Interest</label>
              <select id="hero-programme" name="programme" required>
                <option value="" selected disabled>Programme of Interest*</option>
                <option>Professional Certificate in ESG &amp; Sustainability Reporting</option>
                <option>Professional Certificate in Environmental &amp; Social Impact Assessment (ESIA)</option>
              </select>
              <svg class="field__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="m6 9 6 6 6-6" />
              </svg>
              <p class="field__error" data-error></p>
            </div>

            <!-- Honeypot: hidden from people, filled in by bots. Never submitted. -->
            <div class="hp-field" aria-hidden="true">
              <input type="text" name="website" tabindex="-1" autocomplete="off">
              <input type="text" name="company_url" tabindex="-1" autocomplete="off">
              <input type="text" name="fax" tabindex="-1" autocomplete="off">
            </div>

            <button class="btn btn--white btn--block btn--lg" type="submit">Request Information</button>

            <p class="lead-form__error" role="alert" data-form-error hidden></p>

            <p class="lead-form__note">
              <strong>Privacy Note:</strong> We respect your privacy. Your information
              will only be used for admissions-related communication.
            </p>
            <p class="lead-form__success" role="status" data-success hidden>
              Thank you — your request has been received. Our admissions team will be in touch shortly.
              <a class="lead-form__brochure" href="#" target="_blank" rel="noopener"
                data-brochure-link hidden>Open the brochure</a>
            </p>
          </form>
        </div>

      </div>
    </section>

    <!-- 2. PROGRAMME AT A GLANCE -->
    <section class="section section--white glance" aria-labelledby="glance-title">
      <div class="container">
        <p class="eyebrow eyebrow--center">At a Glance</p>
        <h2 class="section__title section__title--center" id="glance-title">Programme at a Glance</h2>

        <ul class="glance__grid">
          <li class="glance__item">
            <span class="glance__icon">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 6.5C10.5 5 8.5 4.5 4 4.5v13c4.5 0 6.5.5 8 2 1.5-1.5 3.5-2 8-2v-13c-4.5 0-6.5.5-8 2Z" />
                <path d="M12 6.5v13" />
              </svg>
            </span>
            <span class="glance__body">
              <span class="glance__label">Learning Hours</span>
              <span class="glance__value">60+ Learning Hours</span>
            </span>
          </li>
          <li class="glance__item">
            <span class="glance__icon">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="8.5" />
                <path d="M12 7v5.2l3.3 2" />
              </svg>
            </span>
            <span class="glance__body">
              <span class="glance__label">Duration</span>
              <span class="glance__value">10 Weeks</span>
            </span>
          </li>
          <li class="glance__item">
            <span class="glance__icon">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3.5 3 8l9 4.5L21 8l-9-4.5Z" />
                <path d="M3 12.8 12 17.3l9-4.5" />
                <path d="M3 17.2 12 21.7l9-4.5" />
              </svg>
            </span>
            <span class="glance__body">
              <span class="glance__label">Learning Format</span>
              <span class="glance__value">Self-Paced + Live Online</span>
            </span>
          </li>
          <li class="glance__item">
            <span class="glance__icon">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="9" cy="8.5" r="3.5" />
                <path d="M2.8 19c0-3.4 2.8-5.5 6.2-5.5s6.2 2.1 6.2 5.5" />
                <path d="M16.5 5.6a3.4 3.4 0 0 1 0 6.4" />
                <path d="M18.4 13.9c1.7.8 2.8 2.4 2.8 4.6" />
              </svg>
            </span>
            <span class="glance__body">
              <span class="glance__label">Faculty</span>
              <span class="glance__value">Industry Experts &amp; Academic Leaders</span>
            </span>
          </li>
          <li class="glance__item">
            <span class="glance__icon">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="8.5" />
                <path d="M3.5 12h17" />
                <path d="M12 3.5c2.3 2.6 2.3 14.4 0 17M12 3.5c-2.3 2.6-2.3 14.4 0 17" />
              </svg>
            </span>
            <span class="glance__body">
              <span class="glance__label">Languages</span>
              <span class="glance__value">English</span>
            </span>
          </li>
          <li class="glance__item">
            <span class="glance__icon">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z" />
                <path d="M14 3v5h5" />
                <path d="M9 13h6M9 17h4" />
              </svg>
            </span>
            <span class="glance__body">
              <span class="glance__label">Applied Learning</span>
              <span class="glance__value">Hands-on Projects &amp; Case Studies</span>
            </span>
          </li>
          <li class="glance__item">
            <span class="glance__icon">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="9" r="5.2" />
                <path d="M8.4 13.6 7 21l5-2.6L17 21l-1.4-7.4" />
              </svg>
            </span>
            <span class="glance__body">
              <span class="glance__label">Capstone Project</span>
              <span class="glance__value">Real-World ESG Project</span>
            </span>
          </li>
          <li class="glance__item">
            <span class="glance__icon">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 4 2.5 8.6 12 13.2l9.5-4.6L12 4Z" />
                <path d="M6.5 10.9v4.7c0 1.6 2.5 2.9 5.5 2.9s5.5-1.3 5.5-2.9v-4.7" />
                <path d="M21.5 8.6v5.2" />
              </svg>
            </span>
            <span class="glance__body">
              <span class="glance__label">Industry Alignment</span>
              <span class="glance__value">Aligned with Global ESG Standards &amp; Best Practices</span>
            </span>
          </li>
        </ul>
      </div>
    </section>

    <!-- 3. SECTION NAVIGATION -->
    <nav class="section-nav" aria-label="Page sections">
      <div class="container">
        <ul class="section-nav__list" data-section-nav>
          <li><a class="is-active" href="#journey">Learning Journey</a></li>
          <li><a href="#curriculum">Curriculum</a></li>
          <li><a href="#experience">Beyond the Classroom</a></li>
          <li><a href="#faculty">Faculty</a></li>
          <li><a href="#partners">Partners</a></li>
          <li><a href="#testimonials">Testimonials</a></li>
          <li><a href="#fees">Fees &amp; Offers</a></li>
          <li><a href="#faq">FAQs</a></li>
        </ul>
      </div>
    </nav>

    <!-- 4. YOUR LEARNING JOURNEY -->
    <section class="section section--mint journey" id="journey" aria-labelledby="journey-title">
      <div class="container">
        <p class="eyebrow eyebrow--center">Roadmap</p>
        <h2 class="section__title section__title--center" id="journey-title">Your Learning Journey</h2>
        <p class="section__lead">
          Progress through a carefully designed sequence of modules that build your
          knowledge and practical skills in ESG and Sustainability Reporting, from
          foundational concepts to a real-world capstone project.
        </p>

        <div class="journey-map">

          <svg class="journey-map__svg" viewBox="0 0 1197 664" role="presentation" focusable="false" aria-hidden="true">
            <!-- main path -->
            <path class="jm-track"
              d="M 283 77 L 297.3 142.1 L 343.8 253.8 L 429.5 341.6 L 544.2 388.5 L 667.1 388.5 L 780.3 341.6 L 868.1 253.8 L 913.1 142.1 L 927 77" />
            <!-- terminal flags -->
            <path class="jm-flag" d="M283 77 H345" />
            <path class="jm-flag" d="M927 77 H865" />
            <!-- dotted connectors -->
            <g class="jm-dots">
              <line x1="208.3" y1="123.7" x2="261.1" y2="134.6" />
              <line x1="274.6" y1="272.3" x2="308.1" y2="263.3" />
              <line x1="380.2" y1="390.4" x2="403.2" y2="367.6" />
              <line x1="524.2" y1="457.2" x2="533.9" y2="424.0" />
              <line x1="681.0" y1="455.2" x2="674.6" y2="424.7" />
              <line x1="820.9" y1="386.4" x2="805.2" y2="369.0" />
              <line x1="923.0" y1="269.8" x2="903.6" y2="264.2" />
              <line x1="988.9" y1="125.3" x2="949.2" y2="134.1" />
            </g>
            <!-- direction arrows -->
            <g class="jm-arrows">
              <g transform="translate(348.2 186.4) rotate(67.4)">
                <path d="M-26 20 L-8 0 L26 0" />
                <path d="M17 -8 L26 0 L17 8" />
              </g>
              <g transform="translate(408.1 276.7) rotate(45.7)">
                <path d="M-26 20 L-8 0 L26 0" />
                <path d="M17 -8 L26 0 L17 8" />
              </g>
              <g transform="translate(498.2 337.3) rotate(22.2)">
                <path d="M-26 20 L-8 0 L26 0" />
                <path d="M17 -8 L26 0 L17 8" />
              </g>
              <g transform="translate(605.7 358.5) rotate(0)">
                <path d="M-26 20 L-8 0 L26 0" />
                <path d="M17 -8 L26 0 L17 8" />
              </g>
              <g transform="translate(712.2 337.3) rotate(-22.5)">
                <path d="M-26 20 L-8 0 L26 0" />
                <path d="M17 -8 L26 0 L17 8" />
              </g>
              <g transform="translate(803.0 276.5) rotate(-45)">
                <path d="M-26 20 L-8 0 L26 0" />
                <path d="M17 -8 L26 0 L17 8" />
              </g>
              <g transform="translate(862.8 186.7) rotate(-68.1)">
                <path d="M-26 20 L-8 0 L26 0" />
                <path d="M17 -8 L26 0 L17 8" />
              </g>
            </g>
          </svg>

          <p class="journey-map__center">Eight stages,<br>one capability.</p>

          <ol class="journey-stages">
            <li class="journey-stage" style="--cx:101.6; --cy:101.6; --nx:297.3; --ny:142.1">
              <span class="journey-stage__num">1</span>
              <span class="journey-stage__disc">
                <span class="journey-stage__inner">
                  <strong class="journey-stage__weeks">Weeks 1&ndash;3</strong>
                  <span class="journey-stage__name">Sustainability Foundations</span>
                </span>
              </span>
            </li>
            <li class="journey-stage" style="--cx:169.3; --cy:300.4; --nx:343.8; --ny:253.8">
              <span class="journey-stage__num">2</span>
              <span class="journey-stage__disc">
                <span class="journey-stage__inner">
                  <strong class="journey-stage__weeks">Weeks 4</strong>
                  <span class="journey-stage__name">Foundations of ESG &amp; Responsible Business</span>
                </span>
              </span>
            </li>
            <li class="journey-stage" style="--cx:302.7; --cy:467.1; --nx:429.5; --ny:341.6">
              <span class="journey-stage__num">3</span>
              <span class="journey-stage__disc">
                <span class="journey-stage__inner">
                  <strong class="journey-stage__weeks">Weeks 5</strong>
                  <span class="journey-stage__name">Global ESG Frameworks &amp; Standards</span>
                </span>
              </span>
            </li>
            <li class="journey-stage" style="--cx:493.7; --cy:561.9; --nx:544.2; --ny:388.5">
              <span class="journey-stage__num">4</span>
              <span class="journey-stage__disc">
                <span class="journey-stage__inner">
                  <strong class="journey-stage__weeks">Weeks 6</strong>
                  <span class="journey-stage__name">Materiality &amp; ESG Disclosure</span>
                </span>
              </span>
            </li>
            <li class="journey-stage" style="--cx:703.2; --cy:561.9; --nx:667.1; --ny:388.5">
              <span class="journey-stage__num">5</span>
              <span class="journey-stage__disc">
                <span class="journey-stage__inner">
                  <strong class="journey-stage__weeks">Weeks 7</strong>
                  <span class="journey-stage__name">ESG Data &amp; Performance Measurement</span>
                </span>
              </span>
            </li>
            <li class="journey-stage" style="--cx:894.2; --cy:467.1; --nx:780.3; --ny:341.6">
              <span class="journey-stage__num">6</span>
              <span class="journey-stage__disc">
                <span class="journey-stage__inner">
                  <strong class="journey-stage__weeks">Weeks 8</strong>
                  <span class="journey-stage__name">ESG Reporting &amp; Communication</span>
                </span>
              </span>
            </li>
            <li class="journey-stage" style="--cx:1027.6; --cy:300.4; --nx:868.1; --ny:253.8">
              <span class="journey-stage__num">7</span>
              <span class="journey-stage__disc">
                <span class="journey-stage__inner">
                  <strong class="journey-stage__weeks">Weeks 9</strong>
                  <span class="journey-stage__name">ESG Reporting in Practice</span>
                </span>
              </span>
            </li>
            <li class="journey-stage" style="--cx:1095.3; --cy:101.6; --nx:913.1; --ny:142.1">
              <span class="journey-stage__num">8</span>
              <span class="journey-stage__disc">
                <span class="journey-stage__inner">
                  <strong class="journey-stage__weeks">Weeks 10</strong>
                  <span class="journey-stage__name">Capstone Project</span>
                </span>
              </span>
            </li>
          </ol>
        </div>

        <!-- Vertical adaptation of the same roadmap for tablet / mobile -->
        <ol class="journey-stages--vertical">
          <li class="journey-stage-row">
            <span class="journey-stage-row__disc"><span class="journey-stage-row__num">1</span></span>
            <span class="journey-stage-row__body">
              <strong class="journey-stage-row__weeks">Weeks 1&ndash;3</strong>
              <span class="journey-stage-row__name">Sustainability Foundations</span>
            </span>
          </li>
          <li class="journey-stage-row">
            <span class="journey-stage-row__disc"><span class="journey-stage-row__num">2</span></span>
            <span class="journey-stage-row__body">
              <strong class="journey-stage-row__weeks">Weeks 4</strong>
              <span class="journey-stage-row__name">Foundations of ESG &amp; Responsible Business</span>
            </span>
          </li>
          <li class="journey-stage-row">
            <span class="journey-stage-row__disc"><span class="journey-stage-row__num">3</span></span>
            <span class="journey-stage-row__body">
              <strong class="journey-stage-row__weeks">Weeks 5</strong>
              <span class="journey-stage-row__name">Global ESG Frameworks &amp; Standards</span>
            </span>
          </li>
          <li class="journey-stage-row">
            <span class="journey-stage-row__disc"><span class="journey-stage-row__num">4</span></span>
            <span class="journey-stage-row__body">
              <strong class="journey-stage-row__weeks">Weeks 6</strong>
              <span class="journey-stage-row__name">Materiality &amp; ESG Disclosure</span>
            </span>
          </li>
          <li class="journey-stage-row">
            <span class="journey-stage-row__disc"><span class="journey-stage-row__num">5</span></span>
            <span class="journey-stage-row__body">
              <strong class="journey-stage-row__weeks">Weeks 7</strong>
              <span class="journey-stage-row__name">ESG Data &amp; Performance Measurement</span>
            </span>
          </li>
          <li class="journey-stage-row">
            <span class="journey-stage-row__disc"><span class="journey-stage-row__num">6</span></span>
            <span class="journey-stage-row__body">
              <strong class="journey-stage-row__weeks">Weeks 8</strong>
              <span class="journey-stage-row__name">ESG Reporting &amp; Communication</span>
            </span>
          </li>
          <li class="journey-stage-row">
            <span class="journey-stage-row__disc"><span class="journey-stage-row__num">7</span></span>
            <span class="journey-stage-row__body">
              <strong class="journey-stage-row__weeks">Weeks 9</strong>
              <span class="journey-stage-row__name">ESG Reporting in Practice</span>
            </span>
          </li>
          <li class="journey-stage-row">
            <span class="journey-stage-row__disc"><span class="journey-stage-row__num">8</span></span>
            <span class="journey-stage-row__body">
              <strong class="journey-stage-row__weeks">Weeks 10</strong>
              <span class="journey-stage-row__name">Capstone Project</span>
            </span>
          </li>
        </ol>
      </div>
    </section>

    <!-- 5. PROGRAM CURRICULUM -->
    <section class="section section--white curriculum" id="curriculum" aria-labelledby="curriculum-title">
      <div class="container">

        <div class="curriculum__head">
          <div class="curriculum__heading">
            <p class="eyebrow">Syllabus</p>
            <h2 class="section__title" id="curriculum-title">Program Curriculum</h2>
          </div>
          <span class="curriculum__rule" aria-hidden="true"></span>
          <a class="btn btn--outline" href="#enrollment" data-brochure>
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 3v12M7 11l5 5 5-5M4 20h16" />
            </svg>
            Download Brochure
          </a>
        </div>

        <div class="accordion accordion--weeks" data-accordion>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="true" aria-controls="week-1-panel"
                id="week-1-btn">
                <span class="week__label">Week 1</span>
                <span class="week__title">Understanding Sustainability</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-1-panel" role="region" aria-labelledby="week-1-btn">
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>Introduction to Sustainability</li>
                    <li>Principles &amp; Dimensions of Sustainability </li>
                    <li>Evolution of Sustainability </li>
                    <li>Sustainable Development Goals (SDGs) </li>
                    <li>Global Sustainability Challenges </li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>Sustainability Reflection Exercise </li>
                    <li>Discussion on Contemporary Sustainability Challenges </li>
                    <li>Sustainable Development Goals (SDGs) </li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Sustainability Assessment of Your Community or Workplace</li>


                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-2-panel"
                id="week-2-btn">
                <span class="week__label">Week 2</span>
                <span class="week__title">Sustainability in Business and Society</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-2-panel" role="region" aria-labelledby="week-2-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>Sustainability and Business</li>
                    <li>Responsible Business Practices</li>
                    <li>Introduction to ESG </li>
                    <li>Circular Economy </li>
                    <li>Net Zero</li>
                    <li>Sustainable Finance</li>
                    <li>Climate Change and Sustainability</li>
                    <li>Role of Governments, Businesses & Individuals</li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>Business Sustainability Case Study</li>
                    <li>SDG Mapping Exercise</li>
                    <li>Group Discussion on Emerging Sustainability Trends</li>
                  </ul>

                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Company ESG & Sustainability Initiative Analysis</li>
                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-3-panel"
                id="week-3-btn">
                <span class="week__label">Week 3</span>
                <span class="week__title">Sustainability in Practice</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-3-panel" role="region" aria-labelledby="week-3-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>Sustainability Strategies</li>
                    <li>Sustainable Consumption & Production</li>
                    <li>Resource Efficiency</li>
                    <li>Climate Action & Adaptation</li>
                    <li>Sustainability Case Studies </li>
                    <li>Emerging Trends in Sustainability </li>
                    <li>Sustainability Careers & Professional Opportunities</li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>Sustainability Strategy Development Exercise</li>
                    <li>Resource Efficiency Assessment</li>
                    <li>Group Discussion on Sustainability Careers</li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Develop a Sustainability Action Plan </li>

                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-4-panel"
                id="week-4-btn">
                <span class="week__label">Week 4</span>
                <span class="week__title">Foundations of ESG &amp; Responsible Business</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-4-panel" role="region" aria-labelledby="week-4-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>Introduction to ESG</li>
                    <li>Evolution of ESG </li>
                    <li>Environmental, Social & Governance (ESG) Pillars</li>
                    <li>Responsible Business Practices </li>
                    <li>Business Value of ESG </li>
                    <li>ESG Ecosystem </li>
                    <li>Indian & Global ESG Landscape </li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>Interactive Discussion on ESG Trends & Responsible Business Practices</li>
                    <li>Mini Case Study on ESG Adoption by Leading Organizations </li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>ESG Analysis of a Company's Sustainability Report or BRSR</li>

                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-5-panel"
                id="week-5-btn">
                <span class="week__label">Week 5</span>
                <span class="week__title">Global ESG Reporting Frameworks &amp; Standards</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-5-panel" role="region" aria-labelledby="week-5-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>Evolution of ESG Reporting</li>
                    <li>ESG Reporting Frameworks vs Standards</li>
                    <li>Global Reporting Initiatives (GRI)</li>
                    <li>Sustainability Accounting Standards Board (SASB) </li>
                    <li>International Sustainability Standards Board (ISSB)</li>
                    <li>Integrated Reporting (IR)</li>
                    <li>United Nations Global Compact (UNGC)</li>
                    <li>Sustainable Development Goals (SDGs) & ESG </li>
                    <li>Framework Comparison & Applicability </li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>Framework Mapping Exercise</li>
                    <li>Comparative Analysis of ESG Reporting Frameworks</li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Analysis of ESG Reporting Frameworks in a Sustainability Report</li>

                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-6-panel"
                id="week-6-btn">
                <span class="week__label">Week 6</span>
                <span class="week__title">Indian ESG Reporting, Materiality &amp; Disclosure</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-6-panel" role="region" aria-labelledby="week-6-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>Business Responsibility & Sustainability Report (BRSR)</li>
                    <li>BRSR Core</li>
                    <li>Materiality Assessment </li>
                    <li>Double Materiality </li>
                    <li>Stakeholder Engagement</li>
                    <li>Materiality Matrix</li>
                    <li>Double MaterialitESG Disclosure Planning  </li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>Materiality Assessment Workshop </li>
                    <li>Development of a Materiality Matrix </li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Materiality Assessment & Matrix Development for an Organization</li>

                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-7-panel"
                id="week-7-btn">
                <span class="week__label">Week 7</span>
                <span class="week__title">ESG Data, KPIs &amp; Performance Measurement</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-7-panel" role="region" aria-labelledby="week-7-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>ESG Data Management </li>
                    <li>ESG Metrics & Indicators </li>
                    <li>Key Performance Indicators (KPIs) </li>
                    <li>ESG Data Collection & Validation </li>
                    <li>Benchmarking ESG Performance </li>
                    <li>ESG Performance Dashboards </li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>ESG KPI & Dashboard Design Workshop </li>
                    <li>ESG Performance Dashboard Development </li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Develop an ESG KPI Dashboard for an Organization</li>

                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-8-panel"
                id="week-8-btn">
                <span class="week__label">Week 8</span>
                <span class="week__title">ESG Reporting, Disclosure &amp; Communication</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-8-panel" role="region" aria-labelledby="week-8-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>ESG Report Structure </li>
                    <li>ESG Disclosures</li>
                    <li>Sustainability Communication </li>
                    <li>Investor Communication</li>
                    <li>ESG Assurance </li>
                    <li>ESG Ratings </li>
                    <li>ESG Report Writing </li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>ESG Disclosure Writing Workshop </li>
                    <li>Guided Review of Published ESG & Sustainability Reports </li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Prepare a Draft ESG Reporting Section for an Organization</li>

                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-9-panel"
                id="week-9-btn">
                <span class="week__label">Week 9</span>
                <span class="week__title">ESG Reporting in Practice</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-9-panel" role="region" aria-labelledby="week-9-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>Review of ESG & Sustainability Reports</li>
                    <li>Corporate ESG Case Studies </li>
                    <li>Internal Controls</li>
                    <li>Stakeholder Review</li>
                    <li>ESG Reporting Best Practices</li>
                    <li>Industry Comparisons </li>
                    <li>Common Reporting Challenges </li>
                    <li>ESG Report Evaluation </li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>ESG Report Evaluation Exercise </li>
                    <li>Corporate Case Study Discussions & Peer Presentations </li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Develop and Present a Comprehensive ESG Report</li>

                  </ul>
                </div>
              </div>
            </div>
          </article>

          <article class="week">
            <h3>
              <button class="week__trigger" type="button" aria-expanded="false" aria-controls="week-10-panel"
                id="week-10-btn">
                <span class="week__label">Week 10</span>
                <span class="week__title">ESG Reporting Simulation (Capstone Project)</span>
                <svg class="week__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="week__panel" id="week-10-panel" role="region" aria-labelledby="week-10-btn" hidden>
              <div class="week__panel-inner">
                <div class="week__col">
                  <p class="week__col-title">Topics</p>
                  <ul class="ticklist">
                    <li>ESG Reporting Simulation</li>
                    <li>Framework Selection</li>
                    <li>ESG Data Integration</li>
                    <li>ESG Report Preparation</li>
                    <li>Report Presentation</li>
                    <li>Industry Review</li>
                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Hands-on Activity</p>
                  <ul class="ticklist">
                    <li>ESG & Sustainability Report Capstone Project </li>
                    <li>Industry Review Panel Presentation</li>

                  </ul>
                </div>
                <div class="week__col">
                  <p class="week__col-title">Assignment</p>
                  <ul class="ticklist">
                    <li>Develop and Present a Comprehensive ESG & Sustainability Report</li>

                  </ul>
                </div>
              </div>
            </div>
          </article>

        </div>
      </div>
    </section>

    <!-- 6. BEYOND THE CLASSROOM -->
    <section class="section section--mint experience" id="experience" aria-labelledby="experience-title">
      <div class="container">
        <p class="eyebrow eyebrow--center">Experience</p>
        <h2 class="section__title section__title--center" id="experience-title">Beyond the Classroom</h2>


        <ul class="experience-list">
          <li class="experience-card">
            <span class="experience-card__num">01</span>
            <span class="experience-card__rule" aria-hidden="true"></span>
            <h3 class="experience-card__title">3-Day Industry Immersion</h3>
          </li>
          <li class="experience-card">
            <span class="experience-card__num">02</span>
            <span class="experience-card__rule" aria-hidden="true"></span>
            <h3 class="experience-card__title">Industry Masterclasses</h3>
          </li>
          <li class="experience-card">
            <span class="experience-card__num">03</span>
            <span class="experience-card__rule" aria-hidden="true"></span>
            <h3 class="experience-card__title">Hands-on Workshops</h3>
          </li>
          <li class="experience-card">
            <span class="experience-card__num">04</span>
            <span class="experience-card__rule" aria-hidden="true"></span>
            <h3 class="experience-card__title">Real-World ESG Cases</h3>
          </li>
          <li class="experience-card">
            <span class="experience-card__num">05</span>
            <span class="experience-card__rule" aria-hidden="true"></span>
            <h3 class="experience-card__title">ESG Reporting Capstone</h3>
          </li>
          <li class="experience-card">
            <span class="experience-card__num">06</span>
            <span class="experience-card__rule" aria-hidden="true"></span>
            <h3 class="experience-card__title">Expert Review &amp; Feedback</h3>
          </li>
        </ul>
      </div>
    </section>

    <!-- 7. FACULTY -->
    <section class="section section--white faculty" id="faculty" aria-labelledby="faculty-title">
      <div class="container">
        <p class="eyebrow eyebrow--center">Faculty</p>
        <h2 class="section__title section__title--center" id="faculty-title">Learn from Industry Leaders</h2>
        <p class="section__lead section__lead--sm">
          Practitioners who have authored the frameworks, led the
          disclosures, and advised the regulators.
        </p>

        <div class="faculty-carousel" data-faculty-carousel>
          <div class="faculty-carousel__viewport">
            <ul class="faculty-carousel__track">
              <li class="faculty-card">
                <div class="faculty-card__media">
                  <img src="{{ storage_asset('esg/images/f-balakumar-thangavelu.jpg') }}" alt="Portrait of Balakumar Thangavelu"
                    decoding="async" width="200" height="200">
                </div>
                <div class="faculty-card__body">
                  <h3 class="faculty-card__name">Balakumar Thangavelu</h3>
                  <p class="faculty-card__role">Director CSR and Global Lead &ndash; ESG</p>
                  <p class="faculty-card__org">Cognizant</p>
                </div>
              </li>
              <li class="faculty-card">
                <div class="faculty-card__media">
                  <img src="{{ storage_asset('esg/images/f-deep-chandra-papnoi.jpg') }}" alt="Portrait of Deep Chandra Papnoi"
                    decoding="async" width="400" height="400">
                </div>
                <div class="faculty-card__body">
                  <h3 class="faculty-card__name">Deep Chandra Papnoi</h3>
                  <p class="faculty-card__role">Deputy Director</p>
                  <p class="faculty-card__org">UN Global Compact Network of India</p>
                </div>
              </li>
              <li class="faculty-card">
                <div class="faculty-card__media">
                  <img src="{{ storage_asset('esg/images/f-namrata-rana.jpg') }}" alt="Portrait of Namrata Rana"
                    decoding="async" width="347" height="347">
                </div>
                <div class="faculty-card__body">
                  <h3 class="faculty-card__name">Namrata Rana</h3>
                  <p class="faculty-card__role">National Head &ndash; ESG</p>
                  <p class="faculty-card__org">KPMG</p>
                </div>
              </li>
              <li class="faculty-card">
                <div class="faculty-card__media">
                  <img src="{{ storage_asset('esg/images/f-sriram-sankaran.jpg') }}" alt="Portrait of Sriram Sankaran"
                    decoding="async" width="200" height="200">
                </div>
                <div class="faculty-card__body">
                  <h3 class="faculty-card__name">Sriram Sankaran</h3>
                  <p class="faculty-card__role">Director &amp; Sustainability Advisor</p>
                  <p class="faculty-card__org">Native Angel Network</p>
                </div>
              </li>
              <li class="faculty-card">
                <div class="faculty-card__media">
                  <img src="{{ storage_asset('esg/images/f-arya-dev.jpg') }}" alt="Portrait of Arya Dev"
                    decoding="async" width="249" height="249">
                </div>
                <div class="faculty-card__body">
                  <h3 class="faculty-card__name">Arya Dev</h3>
                  <p class="faculty-card__role">Assistant Manager</p>
                  <p class="faculty-card__org">UN Global Compact Network of India</p>
                </div>
              </li>
              <li class="faculty-card">
                <div class="faculty-card__media">
                  <img src="{{ storage_asset('esg/images/f-vidhya-bhojan.jpg') }}" alt="Portrait of Vidhya Bhojan"
                    decoding="async" width="504" height="504">
                </div>
                <div class="faculty-card__body">
                  <h3 class="faculty-card__name">Vidhya Bhojan</h3>
                  <p class="faculty-card__role">Founder &amp; CSR Expert</p>
                  <p class="faculty-card__org">Right Dots</p>
                </div>
              </li>
              <li class="faculty-card">
                <div class="faculty-card__media">
                  <img src="{{ storage_asset('esg/images/f-atalay-atasu.jpg') }}" alt="Portrait of Atalay Atasu"
                    decoding="async" width="494" height="494">
                </div>
                <div class="faculty-card__body">
                  <h3 class="faculty-card__name">Atalay Atasu</h3>
                  <p class="faculty-card__role">Professor, Sustainable Business Initiative</p>
                  <p class="faculty-card__org">INSEAD</p>
                </div>
              </li>
              <li class="faculty-card">
                <div class="faculty-card__media">
                  <img src="{{ storage_asset('esg/images/f-sam-aflaki.jpg') }}" alt="Portrait of Sam Aflaki"
                    decoding="async" width="200" height="200">
                </div>
                <div class="faculty-card__body">
                  <h3 class="faculty-card__name">Sam Aflaki</h3>
                  <p class="faculty-card__role">Professor, Sustainability and Supply Chain Analytics</p>
                  <p class="faculty-card__org">HEC Paris</p>
                </div>
              </li>
            </ul>
          </div>

          <div class="faculty-carousel__controls">
            <button class="carousel-btn" type="button" data-faculty-prev aria-label="Previous faculty">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="m14 6-6 6 6 6" />
              </svg>
            </button>
            <button class="carousel-btn" type="button" data-faculty-next aria-label="Next faculty">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="m10 6 6 6-6 6" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- 8. INDUSTRY & KNOWLEDGE PARTNERS -->
    <section class="section section--mint partners" id="partners" aria-labelledby="partners-title">
      <div class="container">
        <p class="eyebrow eyebrow--center">Partners</p>
        <h2 class="section__title section__title--center" id="partners-title">
          Industry &amp; Knowledge Partners<br>
          Delivered in Collaboration with Leading Institutions
        </h2>
        <p class="section__lead section__lead--wide">
          This programme is delivered through a collaborative ecosystem of academic institutions, industry partners,
          innovation enablers, and sustainability organizations committed to developing future-ready professionals.
        </p>

        <ul class="partners__logos">
          
          <li><a href="https://rathinamglobal.edu.in/" aria-label="Rathinam Global University" target="_blank" rel="noopener noreferrer"><img src="{{ storage_asset('esg/images/partner-2.png') }}" alt="Rathinam Global University" loading="lazy"></a></li>
          
          <li><a href="https://rightdots.org/" aria-label="Right Dots" target="_blank" rel="noopener noreferrer"><img src="{{ storage_asset('esg/images/40233.png') }}" alt="Right Dots" loading="lazy"></a></li>
          <li class="partner-logo partner-logo--wide"><a href="https://globalcompact.in/" aria-label="Global Compact India" target="_blank" rel="noopener noreferrer"><img src="{{ storage_asset('esg/images/logo-global.png') }}" alt="Global Compact India" loading="lazy"></a></li>
          <li><a href="https://aicraise.com/" aria-label="NITI Aayog, AIM and AIC RAISE" target="_blank" rel="noopener noreferrer"><img src="{{ storage_asset('esg/images/aic.png') }}" alt="NITI Aayog, AIM and AIC RAISE" loading="lazy"></a></li>
        </ul>

        
      </div>
    </section>

    <!-- 9. TESTIMONIALS -->
    <section class="section section--white testimonials" id="testimonials" aria-labelledby="testimonials-title">
      <div class="container">
        <p class="eyebrow eyebrow--center">Industry Perspectives</p>
        <h2 class="section__title section__title--center section__title--xl" id="testimonials-title">What Sustainability
          Leaders Say</h2>
        <p class="section__lead">
          Learn from sustainability leaders and experts about the importance of ESG
          reporting and essential skills for professionals.
        </p>

        <div class="testimonial" data-carousel>
          <span class="testimonial__quotemark" aria-hidden="true">&ldquo;</span>

          <div class="testimonial__viewport">
            <figure class="testimonial__slide is-active" data-slide aria-hidden="false">
              <blockquote class="testimonial__quote">
                &ldquo;We cannot choose between economic growth and sustainability &ndash; we must have both.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-paul-polman.jpg') }}" alt="Portrait of Paul Polman"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Paul Polman</strong>
                  <em>Former CEO, Unilever &amp; Sustainability Author</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;Sustainability is no longer about doing less harm. It&rsquo;s about doing more good.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-jochen-zeitz.jpg') }}" alt="Portrait of Jochen Zeitz"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Jochen Zeitz</strong>
                  <em>CEO, Puma &amp; Co-Founder, The B Team</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;We believe that climate change is one of the most important issues of our time, and we are
                deeply committed to leaving the world better than we found it.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-tim-cook.jpg') }}" alt="Portrait of Tim Cook"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Tim Cook</strong>
                  <em>Former CEO, Apple</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;Businesses and investors know the truth: that acting on climate is no longer about compliance
                or reputation management. It&rsquo;s about profit and resilience. It&rsquo;s about materiality
                and not just morality.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-mindy-lubber.jpg') }}" alt="Portrait of Mindy Lubber"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Mindy Lubber</strong>
                  <em>CEO, Ceres</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;The future is closer than you think. There are basic and massive changes occurring in the
                ecosystem; energy change, sustainability as a way of life and digitalisation is impacting
                every aspect of business. We must be future ready.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-sn-subrahmanyan.jpg') }}" alt="Portrait of S. N. Subrahmanyan"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>S. N. Subrahmanyan</strong>
                  <em>Chairman &amp; Managing Director, Larsen &amp; Toubro (L&amp;T)</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;If we cannot conduct thorough environmental and social assessments that build trust with host
                communities, we simply should not be mining.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-mark-cutifani.jpg') }}" alt="Portrait of Mark Cutifani"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Mark Cutifani</strong>
                  <em>Former CEO, Anglo American</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;ESG and impact assessment are increasingly recognized as business-critical imperatives.
                Organizations that proactively adapt to evolving requirements &mdash; earlier, faster, and
                more effectively &mdash; secure a distinct competitive advantage.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-alok-mishra.jpg') }}" alt="Portrait of Alok Mishra"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Alok Mishra</strong>
                  <em>President &amp; Group Head &ndash; Sustainability, Welspun Group</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;Brands with purpose grow, companies with purpose last, and people with purpose thrive.
                Integrating rigorous environmental and social standards into business models drives superior
                performance.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-alan-jope.jpg') }}" alt="Portrait of Alan Jope"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Alan Jope</strong>
                  <em>Former CEO, Unilever</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;The key challenge is meeting the world&rsquo;s demand for reliable, affordable energy while
                simultaneously lowering emissions and executing thorough environmental stewardship.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-darren-woods.jpg') }}" alt="Portrait of Darren Woods"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Darren Woods</strong>
                  <em>Chairman &amp; CEO, ExxonMobil</em>
                </span>
              </figcaption>
            </figure>
            <figure class="testimonial__slide" data-slide aria-hidden="true">
              <blockquote class="testimonial__quote">
                &ldquo;Sustainability is not an afterthought, but a core design principle. The easier part is doing
                what we do within our operations; the challenging imperative is greening the entire supply
                chain and managing lifecycle environmental impacts.&rdquo;
              </blockquote>
              <figcaption class="testimonial__person">
                <img src="{{ storage_asset('esg/images/t-jamshyd-godrej.jpg') }}" alt="Portrait of Jamshyd Godrej"
                  decoding="async" width="56" height="56">
                <span>
                  <strong>Jamshyd Godrej</strong>
                  <em>Chairman &amp; Managing Director, Godrej &amp; Boyce</em>
                </span>
              </figcaption>
            </figure>
          </div>

          <div class="testimonial__controls">
            <button class="carousel-btn" type="button" data-prev aria-label="Previous testimonial">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="m14 6-6 6 6 6" />
              </svg>
            </button>
            <div class="carousel-dots" role="tablist" aria-label="Choose testimonial" data-dots>
              <button class="carousel-dot is-active" type="button" role="tab"
                aria-label="Testimonial 1" aria-selected="true"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 2" aria-selected="false"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 3" aria-selected="false"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 4" aria-selected="false"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 5" aria-selected="false"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 6" aria-selected="false"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 7" aria-selected="false"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 8" aria-selected="false"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 9" aria-selected="false"></button>
              <button class="carousel-dot" type="button" role="tab"
                aria-label="Testimonial 10" aria-selected="false"></button>
            </div>
            <button class="carousel-btn" type="button" data-next aria-label="Next testimonial">
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="m10 6 6 6-6 6" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- 10. INVESTMENT / PRICING -->
    <section class="section section--mint pricing" id="fees" aria-labelledby="pricing-title">
      <div class="container">
        <p class="eyebrow eyebrow--center">Investment</p>
        <h2 class="section__title section__title--center" id="pricing-title">Invest in Your Future</h2>
        <p class="section__lead">
          A transparent fee structure with no hidden costs. Everything you need to
          successfully complete the programme is included.
        </p>

        <div class="price-card">
          <span class="price-card__badge">Most Popular</span>

          <p class="price-card__eyebrow">in ESG &amp; Sustainability Reporting</p>
          <p class="price-card__amount">&#8377;45,000*</p>
          <p class="price-card__was"><s>&#8377;75,000</s></p>
          <p class="price-card__save"><strong>40% off</strong> &middot; Limited seats</p>

          <ul class="price-card__features">
            <li>10-Week Programme</li>
            <li>60+ Learning Hours</li>
            <li>Live Online Sessions</li>
            <li>Self-Paced Learning Resources</li>
            <li>Weekly Assignments</li>
            <li>Real-World Case Studies</li>
            <li>3-Day Industry Immersion</li>
            <li>Capstone ESG Reporting Project</li>
            <li>Industry Review Panel</li>
            <li>Professional Certificate</li>
          </ul>

          <a class="btn btn--gold-flat btn--block btn--lg" href="https://aicraise.accubate.app/ext/survey/17928/apply" target="_blank">Apply Now</a>
          <p class="price-card__note">*Payment platform charges applicable</p>
        </div>
      </div>
    </section>

    <!-- 11. CERTIFICATION -->
    <section class="section section--white certification" id="certification" aria-labelledby="certification-title">
      <div class="container">
        <h2 class="section__title section__title--center" id="certification-title">Certification</h2>
        <p class="section__lead">
          Earn a Professional Certificate in ESG &amp; Sustainability Reporting from Rathinam
          Global University after completing the program.
        </p>

        <div class="certification__grid">
          <figure class="certification__media">
            <img src="{{ storage_asset('esg/images/certificate.png') }}"
              alt="Sample Professional Certificate in ESG and Sustainability Reporting"
              loading="lazy" decoding="async" width="1240" height="1084">
          </figure>

          <div class="certification__details">
            <h3 class="certification__subtitle">Issued By</h3>
            <p class="certification__issuer">School of Sustainability &amp; Climate Studies Rathinam Global University
            </p>

            <h3 class="certification__subtitle certification__subtitle--awarded">
              <svg class="icon icon--check-badge" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="4" />
                <path d="m7.5 12 3 3 6-6" />
              </svg>
              Awarded Upon
            </h3>
            <ul class="certification__list">
              <li>Successful completion of all learning modules</li>
              <li>Submission of weekly assignments</li>
              <li>Completion of the Capstone Project</li>
              <li>Meeting the programme completion requirements</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 12. FAQ -->
    <section class="section section--mint faq" id="faq" aria-labelledby="faq-title">
      <div class="container">
        <p class="eyebrow eyebrow--center">FAQ</p>
        <h2 class="section__title section__title--center" id="faq-title">Frequently Asked Questions</h2>

        <div class="accordion accordion--faq" data-accordion>

          <div class="faq-item">
            <h3>
              <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-1-panel"
                id="faq-1-btn">
                Who is this programme designed for?
                <svg class="faq-item__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="faq-item__panel" id="faq-1-panel" role="region" aria-labelledby="faq-1-btn" hidden>
              <div class="faq-item__panel-inner">
                <p>This programme is designed for working professionals, recent graduates, consultants, entrepreneurs,
                  researchers, CSR professionals, ESG practitioners, and anyone looking to build practical expertise in
                  ESG reporting and sustainability..</p>
              </div>
            </div>
          </div>

          <div class="faq-item">
            <h3>
              <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-2-panel"
                id="faq-2-btn">
                Do I need prior knowledge of ESG or sustainability?
                <svg class="faq-item__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="faq-item__panel" id="faq-2-panel" role="region" aria-labelledby="faq-2-btn" hidden>
              <div class="faq-item__panel-inner">
                <p>No. The programme begins with sustainability fundamentals before progressing to ESG reporting,
                  global frameworks, materiality assessment, and sustainability disclosures, making it suitable for both
                  beginners and professionals.</p>
              </div>
            </div>
          </div>

          <div class="faq-item">
            <h3>
              <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-3-panel"
                id="faq-3-btn">
                How is the programme delivered?
                <svg class="faq-item__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="faq-item__panel" id="faq-3-panel" role="region" aria-labelledby="faq-3-btn" hidden>
              <div class="faq-item__panel-inner">
                <p>The programme combines live online sessions, self-paced learning resources, hands-on workshops,
                  real-world case studies, weekly assignments,
                  and a capstone project, offering a flexible yet practical learning experience.</p>
              </div>
            </div>
          </div>

          <div class="faq-item">
            <h3>
              <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-4-panel"
                id="faq-4-btn">
                What makes this programme different from other ESG certification courses?
                <svg class="faq-item__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="faq-item__panel" id="faq-4-panel" role="region" aria-labelledby="faq-4-btn" hidden>
              <div class="faq-item__panel-inner">
                <p>Unlike many theory-focused courses, this programme emphasizes experiential learning through hands-on
                  workshops, real-world ESG case studies, a 3-day industry immersion,
                  a capstone ESG reporting simulation, and feedback from industry experts.</p>
              </div>
            </div>
          </div>

          <div class="faq-item">
            <h3>
              <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-5-panel"
                id="faq-5-btn">
                Will I work on real ESG reporting projects?
                <svg class="faq-item__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="faq-item__panel" id="faq-5-panel" role="region" aria-labelledby="faq-5-btn" hidden>
              <div class="faq-item__panel-inner">
                <p>Yes. Throughout the programme, you will complete weekly practical assignments and culminate your
                  learning by preparing a comprehensive ESG & Sustainability
                  Report for a real or simulated organization.</p>
              </div>
            </div>
          </div>

          <div class="faq-item">
            <h3>
              <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-6-panel"
                id="faq-6-btn">
                Will I receive a certificate after completing the programme?
                <svg class="faq-item__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="faq-item__panel" id="faq-6-panel" role="region" aria-labelledby="faq-6-btn" hidden>
              <div class="faq-item__panel-inner">
                <p>Yes. Participants who successfully complete the programme requirements, including assignments and the
                  capstone project, will receive a Professional Certificate from the School of Sustainability &
                  Climate Studies, Rathinam Global University</p>
              </div>
            </div>
          </div>

          <div class="faq-item">
            <h3>
              <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-7-panel"
                id="faq-7-btn">
                Is there a 3-Day Industry Immersion?
                <svg class="faq-item__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="faq-item__panel" id="faq-7-panel" role="region" aria-labelledby="faq-7-btn" hidden>
              <div class="faq-item__panel-inner">
                <p>Yes. The programme includes a 3-day industry immersion, providing participants with first-hand
                  exposure to sustainability initiatives, ESG practices,
                  and real-world implementation through guided industry visits and expert interactions.</p>
              </div>
            </div>
          </div>

          <div class="faq-item">
            <h3>
              <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="faq-8-panel"
                id="faq-8-btn">
                How much time should I dedicate each week?
                <svg class="faq-item__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
            </h3>
            <div class="faq-item__panel" id="faq-8-panel" role="region" aria-labelledby="faq-8-btn" hidden>
              <div class="faq-item__panel-inner">
                <p>Participants should plan to dedicate approximately 4–6 hours per week, including live sessions,
                  self-paced learning, assignments, and practical activities.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- 13. FINAL CTA / ENROLLMENT -->
    <section class="cta" id="enrollment" aria-labelledby="cta-title">
      <div class="container cta__grid">

        <div class="cta__content">
          <p class="hero__eyebrow">Enrollment</p>

          <h2 class="cta__title" id="cta-title">Ready to Build Your <em>ESG Expertise?</em></h2>

          <p class="cta__lead">
            Join the Professional Certificate Programme in ESG &amp; Sustainability Reporting at the School of
            Sustainability &amp; Climate Studies, Rathinam Global University, and gain practical knowledge
            through industry-led learning, hands-on projects, real-world case studies, and immersive
            experiences designed for the evolving sustainability landscape.
          </p>

          <ul class="cta__points">
            <li>Professional Certificate from SSCS, Rathinam Global University</li>
            <li>10-Week Industry-Oriented Programme</li>
            <li>3-Day Industry Immersion &amp; Capstone Project</li>
          </ul>

          <div class="hero__actions">
            <a class="btn btn--gold btn--lg" href="https://aicraise.accubate.app/ext/survey/17928/apply" target="_blank">
              Apply Now
              <svg class="icon icon--arrow" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M5 12h14M13 6l6 6-6 6" />
              </svg>
            </a>
            <a class="btn btn--ghost btn--lg" href="#enrollment" data-brochure>
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 3v12M7 11l5 5 5-5M4 20h16" />
              </svg>
              Download Brochure
            </a>
          </div>
        </div>

        <div class="lead-card">
          <h2 class="lead-card__title">Request Information</h2>
          <p class="lead-card__text lead-card__text--tight">Have questions about the programme?</p>
          <p class="lead-card__text">
            Whether you'd like to learn more about the curriculum, eligibility,
            fees, learning format, or career opportunities, our programme
            team is here to help. Fill out the form below, and we'll get in touch
            with you within 24 hours.
          </p>

          <form class="lead-form" novalidate data-lead-form data-form-name="ESG Footer Form">
            <div class="field">
              <label class="sr-only" for="cta-name">Full Name</label>
              <input id="cta-name" name="name" type="text" placeholder="Full Name*" required>
              <p class="field__error" data-error></p>
            </div>
            <div class="field">
              <label class="sr-only" for="cta-email">Email Address</label>
              <input id="cta-email" name="email" type="email" placeholder="Email Address*" required>
              <p class="field__error" data-error></p>
            </div>
            <div class="field">
              <label class="sr-only" for="cta-phone">Mobile Number</label>
              <input id="cta-phone" name="phone" type="tel" placeholder="Mobile Number*" required>
              <p class="field__error" data-error></p>
            </div>
            <div class="field field--select">
              <label class="sr-only" for="cta-role">Current Role / Profession</label>
              <select id="cta-role" name="role" required>
                <option value="" selected disabled>Current Role / Profession*</option>
                <option>Student</option>
                <option>Recent Graduate</option>
                <option>Working Professional</option>
                <option>Consultant</option>
                <option>Entrepreneur</option>
                <option>Researcher / Academic</option>
                <option>Government Professional</option>
              </select>
              <svg class="field__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="m6 9 6 6 6-6" />
              </svg>
              <p class="field__error" data-error></p>
            </div>
            <div class="field">
              <label class="sr-only" for="cta-org">Current Organization / Institution</label>
              <input id="cta-org" name="organisation" type="text" placeholder="Current Organization / Institution">
              <p class="field__error" data-error></p>
            </div>
            <div class="field field--select">
              <label class="sr-only" for="cta-programme">Programme of Interest</label>
              <select id="cta-programme" name="programme" required>
                <option value="" selected disabled>Programme of Interest*</option>
                <option>Professional Certificate in ESG &amp; Sustainability Reporting</option>
                <option>Professional Certificate in Environmental &amp; Social Impact Assessment (ESIA)</option>
              </select>
              <svg class="field__chevron icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="m6 9 6 6 6-6" />
              </svg>
              <p class="field__error" data-error></p>
            </div>

            <!-- Honeypot: hidden from people, filled in by bots. Never submitted. -->
            <div class="hp-field" aria-hidden="true">
              <input type="text" name="website" tabindex="-1" autocomplete="off">
              <input type="text" name="company_url" tabindex="-1" autocomplete="off">
              <input type="text" name="fax" tabindex="-1" autocomplete="off">
            </div>

            <button class="btn btn--white btn--block btn--lg" type="submit">Request Information</button>

            <p class="lead-form__error" role="alert" data-form-error hidden></p>

            <p class="lead-form__note">
              We respect your privacy. Your information is used only
              to respond to your enquiry and communicate updates.
              We do not share it with third parties.
            </p>
            <p class="lead-form__success" role="status" data-success hidden>
              Thank you — your request has been received. Our programme team will be in touch within 24 hours.
              <a class="lead-form__brochure" href="#" target="_blank" rel="noopener"
                data-brochure-link hidden>Open the brochure</a>
            </p>
          </form>
        </div>

      </div>
    </section>

  </main>

  <script>
    window.RGU_LEAD_CONFIG = {
      lead: @js(route('brochure-leads.store', 'esg')),
      brochure: @js(route('brochures.show', 'esg')),
      csrfToken: @js(csrf_token()),
    };
  </script>
  <script src="{{ storage_asset('esg/script-new2.js') }}"></script>
@endsection
