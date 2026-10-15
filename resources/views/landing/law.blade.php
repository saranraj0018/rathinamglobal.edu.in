@extends('layouts.base')

@section('title', 'RGU School of Law | Admissions Landing Page')
@section('description', 'Admissions landing page for RGU School of Law featuring LL.B., B.A. LL.B. and B.B.A. LL.B. programmes.')
@section('body-attributes') id="top"@endsection

@push('head')

  <link rel="icon" href="{{ storage_asset('law/assets/images/fav.png') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ storage_asset('law/assets/style.css') }}" />
@endpush

@section('body')


  <!-- ============ ICON SPRITE ============ -->
  <svg class="sprite" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
    <symbol id="i-scale" viewBox="0 0 24 24">
      <path d="M12 3.2v17.3M8 20.5h8M4 6.8l8-2 8 2"/>
      <path d="M4 6.8 1.6 12.6a2.4 2.4 0 0 0 4.8 0L4 6.8Z"/>
      <path d="M20 6.8l-2.4 5.8a2.4 2.4 0 0 0 4.8 0L20 6.8Z"/>
    </symbol>
    <symbol id="i-cap" viewBox="0 0 24 24">
      <path d="M2 8.6 12 4.2l10 4.4-10 4.4L2 8.6Z"/>
      <path d="M6.2 10.9V16c0 1.7 2.6 3 5.8 3s5.8-1.3 5.8-3v-5.1"/>
      <path d="M21.2 9.1v5.2"/>
    </symbol>
    <symbol id="i-briefcase" viewBox="0 0 24 24">
      <rect x="2.6" y="7" width="18.8" height="13" rx="2.4"/>
      <path d="M9 7V5.6A1.6 1.6 0 0 1 10.6 4h2.8A1.6 1.6 0 0 1 15 5.6V7"/>
      <path d="M2.6 12.2h18.8"/>
    </symbol>
    <symbol id="i-bank" viewBox="0 0 24 24">
      <path d="M3 9.6 12 4.3l9 5.3"/>
      <path d="M5.4 10.6v8M9.8 10.6v8M14.2 10.6v8M18.6 10.6v8"/>
      <path d="M3 20.6h18"/>
    </symbol>
    <symbol id="i-gavel" viewBox="0 0 24 24">
      <path d="M2.8 21h9.4"/>
      <path d="m6.4 18 7.3-7.3"/>
      <path d="m10.6 5.4 7.6 7.6"/>
      <path d="m13.6 2.6 5.6 5.6-2.7 2.7-5.6-5.6z"/>
    </symbol>
    <symbol id="i-people" viewBox="0 0 24 24">
      <circle cx="9" cy="8.2" r="3.2"/>
      <path d="M2.6 19.6a6.4 6.4 0 0 1 12.8 0"/>
      <path d="M16.4 5.4a3.2 3.2 0 0 1 0 5.7"/>
      <path d="M17.8 13.7a6.4 6.4 0 0 1 3.6 5.9"/>
    </symbol>
    <symbol id="i-shield" viewBox="0 0 24 24">
      <path d="M12 3.4 20 6v6c0 4.5-3.3 7.6-8 9-4.7-1.4-8-4.5-8-9V6l8-2.6Z"/>
      <path d="m8.9 12 2.2 2.2 4-4.3"/>
    </symbol>
    <symbol id="i-board" viewBox="0 0 24 24">
      <rect x="3" y="3.8" width="18" height="12" rx="2.2"/>
      <path d="M7 8h8M7 11.6h5"/>
      <path d="M12 15.8v4.4M8 20.2h8"/>
    </symbol>
    <symbol id="i-mic" viewBox="0 0 24 24">
      <rect x="9" y="3" width="6" height="11" rx="3"/>
      <path d="M5.6 11.4a6.4 6.4 0 0 0 12.8 0"/>
      <path d="M12 17.8v3.2M9 21h6"/>
    </symbol>
    <symbol id="i-doc" viewBox="0 0 24 24">
      <path d="M14 3.2H6.6A1.6 1.6 0 0 0 5 4.8v14.6a1.6 1.6 0 0 0 1.6 1.6h10.8a1.6 1.6 0 0 0 1.6-1.6V8.2L14 3.2Z"/>
      <path d="M13.8 3.4v4.9h5"/>
      <path d="M8.4 13h7M8.4 16.4h4.4"/>
    </symbol>
    <symbol id="i-check" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="8.4"/>
      <path d="m8.3 12.3 2.6 2.6 4.9-5.4"/>
    </symbol>
    <symbol id="i-rocket" viewBox="0 0 24 24">
      <path d="M14.4 3.6C18 4.8 19.9 7.7 20.5 11.4c-2.2 3-5.4 4.9-8.9 5.5L7 12.3C7.6 8.8 9.6 5.6 14.4 3.6Z"/>
      <circle cx="14.6" cy="9.9" r="1.8"/>
      <path d="M7.2 17c-1.6 1.5-1.7 3.7-1.7 3.7s2.2-.1 3.7-1.7"/>
    </symbol>
    <symbol id="i-tick" viewBox="0 0 24 24"><path d="m5 12.6 4.4 4.4L19 6.6"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M4.5 12h15M13.2 5.6 19.6 12l-6.4 6.4"/></symbol>
    <symbol id="i-pin" viewBox="0 0 24 24">
      <path d="M12 21.5s7-6 7-11a7 7 0 1 0-14 0c0 5 7 11 7 11Z"/><circle cx="12" cy="10.3" r="2.7"/>
    </symbol>
    <symbol id="i-globe" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="8.6"/><path d="M3.6 12h16.8"/>
      <path d="M12 3.4c2.4 2.5 3.6 5.4 3.6 8.6S14.4 18.1 12 20.6c-2.4-2.5-3.6-5.4-3.6-8.6S9.6 5.9 12 3.4Z"/>
    </symbol>
    <symbol id="i-phone" viewBox="0 0 24 24">
      <path d="M8.4 3.6H5.2A1.7 1.7 0 0 0 3.5 5.3c0 8.4 6.8 15.2 15.2 15.2a1.7 1.7 0 0 0 1.7-1.7v-3.2l-4.2-1.4-2 2a13.4 13.4 0 0 1-6.1-6.1l2-2Z"/>
    </symbol>
    <symbol id="i-x" viewBox="0 0 24 24">
      <path d="M18.24 2.25h3.31l-7.23 8.26 8.5 11.24h-6.66l-5.21-6.82-5.97 6.82H1.68l7.73-8.84L1.25 2.25h6.83l4.71 6.23 5.45-6.23Zm-1.16 17.52h1.83L7.08 4.13H5.12l11.96 15.64Z"/>
    </symbol>
    <symbol id="i-linkedin" viewBox="0 0 24 24">
      <path d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29ZM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13Zm1.78 13.02H3.55V9h3.57v11.45ZM22.22 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.72V1.72C24 .77 23.2 0 22.22 0Z"/>
    </symbol>
    <symbol id="i-facebook" viewBox="0 0 24 24">
      <path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.09 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.96.93-1.96 1.89v2.25h3.33l-.53 3.49h-2.8V24C19.61 23.09 24 18.1 24 12.07Z"/>
    </symbol>
    <symbol id="i-youtube" viewBox="0 0 24 24">
      <path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.5A3.02 3.02 0 0 0 .5 6.19C0 8.08 0 12 0 12s0 3.92.5 5.81a3.02 3.02 0 0 0 2.12 2.14c1.88.5 9.38.5 9.38.5s7.5 0 9.38-.5a3.02 3.02 0 0 0 2.12-2.14C24 15.92 24 12 24 12s0-3.92-.5-5.81ZM9.55 15.57V8.43L15.82 12l-6.27 3.57Z"/>
    </symbol>
    <symbol id="i-instagram" viewBox="0 0 24 24">
      <path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.22.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.05.41 2.22.06 1.27.07 1.65.07 4.86s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.22-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.05.36-2.22.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.22-.41-.56-.22-.96-.48-1.38-.9-.42-.42-.68-.82-.9-1.38-.16-.42-.36-1.05-.41-2.22-.06-1.27-.07-1.65-.07-4.85s.01-3.59.07-4.86c.05-1.17.25-1.8.41-2.22.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.05-.36 2.22-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07c-1.27.06-2.15.26-2.91.56-.79.3-1.46.72-2.12 1.38A5.87 5.87 0 0 0 .63 4.13c-.3.76-.5 1.64-.56 2.91C.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.3.79.72 1.46 1.38 2.12a5.87 5.87 0 0 0 2.12 1.38c.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.87 5.87 0 0 0 2.12-1.38 5.87 5.87 0 0 0 1.38-2.12c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.87 5.87 0 0 0-1.38-2.12A5.87 5.87 0 0 0 19.86.63c-.76-.3-1.64-.5-2.91-.56C15.67.01 15.26 0 12 0Z"/>
      <path d="M12 5.84A6.16 6.16 0 1 0 12 18.16 6.16 6.16 0 0 0 12 5.84Zm0 10.16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z"/>
      <circle cx="18.41" cy="5.59" r="1.44"/>
    </symbol>
  </svg>

  <div class="scroll-progress" aria-hidden="true"><span id="scrollProgress"></span></div>

  <!-- ============ HEADER ============ -->
  <header class="site-header">
    <div class="utility-bar">
      <div class="container utility-inner">
        <p class="utility-brand">
          <strong>Rathinam Global Deemed to be University</strong>
         
        </p>
        <span class="pill">NAAC Grade A++ Accredited</span>
      </div>
    </div>
  </header>

  <nav class="navbar" id="navbar" aria-label="Primary">
      <div class="container nav-inner">
        <a class="nav-logo" href="https://rathinamglobal.edu.in/" aria-label="Rathinam Global Deemed to be University — home">
          <img src="{{ storage_asset('law/assets/images/logo.webp') }}" alt="Rathinam Global Deemed to be University · NAAC Grade A++ Accredited · 1st in Tamil Nadu" />
        </a>

        <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="navMenu" aria-label="Open menu">
          <span></span><span></span><span></span>
        </button>

        <div class="nav-menu" id="navMenu">
          <ul class="nav-links">
            <li><a href="#programmes" class="nav-link">Programmes</a></li>
            <li><a href="#why" class="nav-link">Why RGU Law?</a></li>
            <li><a href="#pathways" class="nav-link">Career Pathways</a></li>
            <li><a href="#experience" class="nav-link">Learning Experience</a></li>
            <li><a href="#journey" class="nav-link">Admission Journey</a></li>
          </ul>
          <a href="https://admissions.rathinamcollege.edu.in" class="btn btn-primary btn-sm nav-cta">Apply / Enquire Now</a>
        </div>
      </div>
  </nav>

  <main>
    <!-- ============ HERO ============ -->
    <section class="hero" id="hero">
      <div class="hero-glow" aria-hidden="true"></div>
      <div class="container hero-grid">
        <div class="hero-copy">
          <span class="eyebrow reveal">Admissions Open | School of Law</span>
          <h2 class="reveal">From <span class="gold">Courtroom</span> to Boardroom — <br>Build Your Future with <span class="nowrap">RGU Law</span></h2>
          <p class="subline reveal">A future-ready legal education platform shaped around <strong>Law, Business, Technology and Practice</strong>. Designed for students who want strong legal foundations, industry exposure and real career pathways.</p>
          <div class="tag-row reveal">
            <span class="tag">LL.B. (3 Years)</span>
            <span class="tag">B.A. LL.B. (Hons.) – 5 Years</span>
            <span class="tag">B.B.A. LL.B. (Hons.) – 5 Years</span>
          </div>
          <div class="cta-row reveal">
            <a href="#enquire" class="btn btn-primary">Apply / Enquire Now <svg class="ico"><use href="#i-arrow"/></svg></a>
            <a href="#programmes" class="btn btn-secondary">Explore Programmes</a>
          </div>
         
        </div>

        <figure class="hero-card reveal">
          <img src="{{ storage_asset('law/assets/images/img2.jpeg') }}" alt="RGU School of Law admissions poster" data-zoom />
        </figure>
      </div>

      <div class="container quick-stats">
        <div class="stat reveal"><div class="num" data-count="3">3</div><div class="lab">Programmes designed for graduates and Class XII students</div></div>
        <div class="stat reveal"><div class="num" data-count="6" data-suffix="+">6+</div><div class="lab">Career pathways including litigation, judiciary and corporate law</div></div>
        <div class="stat reveal"><div class="num">A++</div><div class="lab">NAAC-accredited institutional quality environment</div></div>
        <div class="stat reveal"><div class="num" data-count="100" data-suffix="%">100%</div><div class="lab">Practice-oriented positioning with legal exposure focus</div></div>
      </div>
    </section>

    <!-- ============ PROGRAMMES ============ -->
    <section class="section" id="programmes">
      <div class="container">
        <div class="section-head reveal">
          <div>
            <span class="rule"></span>
            <h3>Programmes at a Glance</h3>
            <p>Each programme is positioned with a distinct career promise so the admission team can speak clearly to different student segments.</p>
          </div>
        </div>

        <div class="programs">
          <article class="card program-card reveal">
            <div class="card-media">
              <img src="{{ storage_asset('law/assets/images/img6.jpeg') }}" alt="LL.B. three year programme poster" loading="lazy" data-zoom />
            </div>
            <div class="card-body">
              <div class="icon"><svg class="ico"><use href="#i-scale"/></svg></div>
              <div class="smallcap">For Graduates</div>
              <h4>LL.B.</h4>
              <p><strong>3 Years</strong> — ideal for graduates ready to build a fast-track career in law, litigation, judiciary and legal practice.</p>
              <ul class="bullet">
                <li>Strong pathway to legal practice and chamber exposure</li>
                <li>Focus on litigation, judiciary and legal drafting</li>
                <li>Suitable for graduates seeking a second-career edge</li>
              </ul>
            </div>
          </article>

          <article class="card program-card reveal">
            <div class="card-media">
              <img src="{{ storage_asset('law/assets/images/img5.jpeg') }}" alt="B.A. LL.B.  five year programme poster" loading="lazy" data-zoom />
            </div>
            <div class="card-body">
              <div class="icon"><svg class="ico"><use href="#i-cap"/></svg></div>
              <div class="smallcap">After Class XII</div>
              <h4>B.A. LL.B. (Hons.)</h4>
              <p><strong>5 Years</strong> — built for students interested in advocacy, justice, policy, judiciary and civil-services-oriented legal education.</p>
              <ul class="bullet">
                <li>Law, society and justice positioning</li>
                <li>Strong foundation in constitutional, civil and criminal law</li>
                <li>Well suited for advocacy, judiciary and public policy goals</li>
              </ul>
            </div>
          </article>

          <article class="card program-card reveal">
            <div class="card-media">
              <img src="{{ storage_asset('law/assets/images/img4.jpeg') }}" alt="B.B.A. LL.B.  five year programme poster" loading="lazy" data-zoom />
            </div>
            <div class="card-body">
              <div class="icon"><svg class="ico"><use href="#i-briefcase"/></svg></div>
              <div class="smallcap">After Class XII</div>
              <h4>B.B.A. LL.B. (Hons.)</h4>
              <p><strong>5 Years</strong> — where law meets business, built for students targeting corporate law, contracts, compliance and startup ecosystems.</p>
              <ul class="bullet">
                <li>Business-integrated legal education</li>
                <li>Corporate law, compliance and contracts orientation</li>
                <li>Exposure to startup law, AI and technology governance</li>
              </ul>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- ============ WHY RGU LAW ============ -->
    <section class="section section-soft" id="why">
      <div class="container two-col">
        <div>
          <div class="section-head tight reveal">
            <div>
              <span class="rule"></span>
              <h3>Why RGU Law?</h3>
              <p> RGU Law is not as a generic law college, but as a future-ready, practice-led legal ecosystem.</p>
            </div>
          </div>
          <div class="feature-grid">
            <div class="feature reveal">
              <div class="icon icon-sm"><svg class="ico"><use href="#i-bank"/></svg></div>
              <h5>Dedicated Law Environment</h5>
              <p>A distinct School of Law identity designed to support strong positioning, better brand recall and focused legal learning.</p>
            </div>
            <div class="feature reveal">
              <div class="icon icon-sm"><svg class="ico"><use href="#i-gavel"/></svg></div>
              <h5>Moot Court &amp; Legal Aid</h5>
              <p>Hands-on legal exposure through simulations, legal-aid orientation and structured skill building from early stages.</p>
            </div>
            <div class="feature reveal">
              <div class="icon icon-sm"><svg class="ico"><use href="#i-people"/></svg></div>
              <h5>Corporate, Chamber &amp; Court Exposure</h5>
              <p>Industry-linked learning through internships and engagement with practice environments, not just classroom lectures.</p>
            </div>
            <div class="feature reveal">
              <div class="icon icon-sm"><svg class="ico"><use href="#i-shield"/></svg></div>
              <h5>Future-Ready Focus Areas</h5>
              <p>Corporate law, litigation, cyber law, AI &amp; data governance, compliance, startup and innovation law positioning.</p>
            </div>
          </div>
        </div>

        <aside class="why-aside">
          <figure class="poster-frame reveal">
            <img src="{{ storage_asset('law/assets/images/img3.jpeg') }}" alt="RGU School of Law admissions open poster" loading="lazy" data-zoom />
          </figure>

          <div class="info-panel reveal">
            
            <ul class="tick-list">
              <li><span class="tick"><svg class="ico"><use href="#i-tick"/></svg></span><span><strong>Learn.</strong> Build a strong legal foundation with structured academic depth.</span></li>
              <li><span class="tick"><svg class="ico"><use href="#i-tick"/></svg></span><span><strong>Advocate.</strong> Gain practice-led exposure through moots, drafting and legal engagement.</span></li>
              <li><span class="tick"><svg class="ico"><use href="#i-tick"/></svg></span><span><strong>Lead.</strong> Step into litigation, judiciary, corporate law, compliance or innovation-led legal careers.</span></li>
              <li><span class="tick"><svg class="ico"><use href="#i-tick"/></svg></span><span><strong>Differentiate.</strong> RGU’s positioning combines law, business and technology for current-generation careers.</span></li>
            </ul>
            <div class="marketing-line">
              
              “A future-ready legal education platform shaped around Law, Business, Technology and Practice.”
            </div>
          </div>
        </aside>
      </div>
    </section>

    <!-- ============ CAREER PATHWAYS ============ -->
    <section class="section" id="pathways">
      <div class="container">
        <div class="section-head reveal">
          <div>
            <span class="rule"></span>
            <h3>Career Pathways</h3>
           
          </div>
        </div>
        <div class="pathways">
          <div class="path reveal"><span class="emo"><svg class="ico"><use href="#i-scale"/></svg></span><strong>Litigation</strong></div>
          <div class="path reveal"><span class="emo"><svg class="ico"><use href="#i-bank"/></svg></span><strong>Judiciary</strong></div>
          <div class="path reveal"><span class="emo"><svg class="ico"><use href="#i-briefcase"/></svg></span><strong>Corporate Law</strong></div>
          <div class="path reveal"><span class="emo"><svg class="ico"><use href="#i-check"/></svg></span><strong>Compliance</strong></div>
          <div class="path reveal"><span class="emo"><svg class="ico"><use href="#i-doc"/></svg></span><strong>Public Policy</strong></div>
          <div class="path reveal"><span class="emo"><svg class="ico"><use href="#i-rocket"/></svg></span><strong>Startup &amp; Innovation Law</strong></div>
        </div>
      </div>
    </section>

    <!-- ============ LEARNING EXPERIENCE + ADMISSION JOURNEY ============ -->
    <section class="section section-soft" id="experience">
      <div class="container two-col align-start">
        <div class="card panel reveal">
          <div class="section-head tight">
            <div>
              <span class="rule"></span>
              <h3 class="h3-sm">Learning Experience</h3>
              
            </div>
          </div>
          <div class="feature-grid">
            <div class="feature"><div class="icon icon-sm"><svg class="ico"><use href="#i-board"/></svg></div><h5>Classroom Learning</h5><p>Core legal subjects delivered with a structured and guided learning approach.</p></div>
            <div class="feature"><div class="icon icon-sm"><svg class="ico"><use href="#i-mic"/></svg></div><h5>Moot Court Simulation</h5><p>Build confidence in advocacy, argumentation and courtroom communication.</p></div>
            <div class="feature"><div class="icon icon-sm"><svg class="ico"><use href="#i-doc"/></svg></div><h5>Legal Drafting &amp; Research</h5><p>Develop drafting discipline, reasoning and documentation capability.</p></div>
            <div class="feature"><div class="icon icon-sm"><svg class="ico"><use href="#i-briefcase"/></svg></div><h5>Internships &amp; Practice Exposure</h5><p>Connect learning with chambers, courts, companies and legal teams.</p></div>
          </div>
        </div>

        <div class="card panel reveal" id="journey">
          <div class="section-head tight">
            <div>
              <span class="rule"></span>
              <h3 class="h3-sm">Admission Journey</h3>
             
            </div>
          </div>
          <ol class="journey" id="journeySteps">
            <li class="step"><div class="stepnum">1</div><h5>Enquiry</h5><p>Student shares interest through the landing page or the admission centre.</p></li>
            <li class="step"><div class="stepnum">2</div><h5>Counselling</h5><p>Program fit and career pathways are explained clearly.</p></li>
            <li class="step"><div class="stepnum">3</div><h5>Application</h5><p>Student selects programme and submits application details.</p></li>
            <li class="step"><div class="stepnum">4</div><h5>Verification</h5><p>Academic details and supporting documents are reviewed.</p></li>
            <li class="step"><div class="stepnum">5</div><h5>Admission</h5><p>Eligible students complete the admission process and onboarding.</p></li>
          </ol>
        </div>
      </div>
    </section>

    <!-- ============ ENQUIRY ============ -->
  </main>

  <!-- ============ FOOTER ============ -->
  <footer class="footer">
    <div class="container footer-grid">
      <div class="footer-brand">
        <div class="footer-logo">
          <img src="{{ storage_asset('law/assets/images/logo.webp') }}" alt="Rathinam Global University · NAAC Grade A++ Accredited · 1st in Tamil Nadu" loading="lazy" />
        </div>
        <p class="footer-tagline">Rathinam Global University — a leading deemed university in Coimbatore shaping future-ready graduates.</p>

        <ul class="social-row">
          <li><a href="https://x.com/rathinamgroups" aria-label="X"><svg class="ico ico-brand"><use href="#i-x"/></svg></a></li>
          <li><a href="https://www.linkedin.com/company/rathinam-global/" aria-label="LinkedIn"><svg class="ico ico-brand"><use href="#i-linkedin"/></svg></a></li>
          <li><a href="https://www.facebook.com/rathinamglobal/" aria-label="Facebook"><svg class="ico ico-brand"><use href="#i-facebook"/></svg></a></li>
          <li><a href="https://www.youtube.com/user/RathinamCollege" aria-label="YouTube"><svg class="ico ico-brand"><use href="#i-youtube"/></svg></a></li>
          <li><a href="https://www.instagram.com/rathinam_global/" aria-label="Instagram"><svg class="ico ico-brand"><use href="#i-instagram"/></svg></a></li>
        </ul>

        <ul class="badge-row">
          <li>NAAC A++</li>
          <li>NBA</li>
          <li>UGC</li>
          <li>AICTE</li>
          <li>QS</li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Contact</h4>
        <ul class="contact-list">
          <li>
            <span class="c-ico"><svg class="ico"><use href="#i-pin"/></svg></span>
            <span>Eachanari, Coimbatore<br>Tamil Nadu – 641021</span>
          </li>
          <li>
            <span class="c-ico"><svg class="ico"><use href="#i-phone"/></svg></span>
            <a href="tel:+918448448909">+91-844-844-8909</a>
          </li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Quick Links</h4>
        <ul class="footer-links">
          <li><a href="{{ storage_asset('law/assets/Equal_Opportunity_Cell_Policy.pdf') }}" target="_blank" rel="noopener noreferrer">Equal Opportunity Cell Policy</a></li>
          <li><a href="{{ storage_asset('law/assets/Establishment of Grievance Redressal Committee in the Institution or Appointment of OMBUDSMAN by the University.pdf') }}" target="_blank" rel="noopener noreferrer">Grievance Redressal Committee</a></li>
          <li><a href="{{ storage_asset('law/assets/Establishment of Anti Ragging Committee.pdf') }}" target="_blank" rel="noopener noreferrer">Anti Ragging Committee</a></li>
          <li><a href="{{ storage_asset('law/assets/Establishment of Committee For SC or ST.pdf') }}" target="_blank" rel="noopener noreferrer">Committee for SC / ST</a></li>
          <li><a href="{{ storage_asset('law/assets/Internal Complaints Committee.pdf') }}" target="_blank" rel="noopener noreferrer">Internal Complaints Committee</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Admissions</h4>
        <p>Admissions are now open for Undergraduate, Postgraduate and Research programs.</p>
        <a href="#programmes" class="btn btn-light footer-cta">Explore Programs</a>
      </div>
    </div>

    <div class="container copyright">
      <span>© 2026 Rathinam Global University. All rights reserved.</span>
    </div>
  </footer>

  <button class="to-top" id="toTop" aria-label="Back to top"><svg class="ico"><use href="#i-arrow"/></svg></button>

  <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Image preview" hidden>
    <button class="lightbox-close" id="lightboxClose" aria-label="Close preview">&times;</button>
    <img id="lightboxImg" alt="" />
  </div>

  <script src="{{ storage_asset('law/assets/script.js') }}"></script>
@endsection
