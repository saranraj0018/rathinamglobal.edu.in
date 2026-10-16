@extends('layouts.base')

@section('title', 'Dashboard Map — Rathinam Group of Institutions')
@section('without-voice-assistant', true)

@push('head')

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <style>
    :root {
      --bg:        #060d1a;
      --bg-card:   rgba(255,255,255,0.035);
      --border:    rgba(255,255,255,0.08);
      --border-hi: rgba(255,255,255,0.18);
      --text:      #cbd5e1;
      --text-hi:   #f1f5f9;
      --muted:     #475569;
      --dim:       #64748b;
      --radius:    20px;

      /* Gradients */
      --g-marketing: linear-gradient(135deg, #3b4f6b 0%, #1e293b 100%);
      --g-rtc:       linear-gradient(135deg, #0ea5a0 0%, #0d6e6a 100%);
      --g-rgu:       linear-gradient(135deg, #d97706 0%, #92400e 100%);
      --g-mba:       linear-gradient(135deg, #7c3aed 0%, #4c1d95 100%);
      --g-aic:       linear-gradient(135deg, #dc2626 0%, #7f1d1d 100%);
      --g-slot:      linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);

      /* Glow colours */
      --glow-rtc:  rgba(14,165,160,0.18);
      --glow-rgu:  rgba(217,119,6,0.18);
      --glow-mba:  rgba(124,58,237,0.18);
      --glow-aic:  rgba(220,38,38,0.18);
      --glow-mkt:  rgba(99,130,170,0.18);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      font-family: "Sora", sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── Ambient background orbs ── */
    body::before {
      content: "";
      position: fixed;
      width: 700px; height: 700px;
      top: -200px; left: -200px;
      background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }
    body::after {
      content: "";
      position: fixed;
      width: 600px; height: 600px;
      bottom: -150px; right: -150px;
      background: radial-gradient(circle, rgba(14,165,160,0.10) 0%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    /* ── Header ── */
    .site-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.9rem 2.5rem;
      border-bottom: 1px solid var(--border);
      background: rgba(6,13,26,0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .logo-wrap {
      background: #fff;
      border-radius: 8px;
      padding: 5px 10px;
      display: flex;
      align-items: center;
    }
    .logo-wrap img { height: 40px; display: block; }

    .site-header h1 {
      font-size: 1.2rem;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: #fff;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      white-space: nowrap;
    }
    .site-header h1 span {
      background: linear-gradient(90deg, #818cf8, #38bdf8, #34d399);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* ── Page intro ── */
    .intro {
      text-align: center;
      padding: 3rem 1rem 1.5rem;
      position: relative;
      z-index: 1;
    }
    .intro p {
      font-size: 0.8rem;
      color: var(--dim);
      letter-spacing: 0.05em;
      margin-top: 0.4rem;
    }

    /* ── Grid ── */
    .dashboard {
      max-width: 1340px;
      margin: 0 auto 5rem;
      padding: 0 2rem;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.4rem;
      position: relative;
      z-index: 1;
    }

    /* ── Card ── */
    .dash-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      transition: border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
    }

    .dash-card.glow-rtc:hover { box-shadow: 0 0 0 1px rgba(14,165,160,0.4), 0 20px 60px var(--glow-rtc); }
    .dash-card.glow-rgu:hover { box-shadow: 0 0 0 1px rgba(217,119,6,0.4), 0 20px 60px var(--glow-rgu); }
    .dash-card.glow-mba:hover { box-shadow: 0 0 0 1px rgba(124,58,237,0.4), 0 20px 60px var(--glow-mba); }
    .dash-card.glow-aic:hover { box-shadow: 0 0 0 1px rgba(220,38,38,0.4), 0 20px 60px var(--glow-aic); }
    .dash-card.glow-mkt:hover { box-shadow: 0 0 0 1px rgba(99,130,170,0.35), 0 20px 60px var(--glow-mkt); }

    .dash-card:hover {
      border-color: var(--border-hi);
      transform: translateY(-4px);
    }

    /* ── Card Header ── */
    .card-head {
      padding: 1.2rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.75rem;
      position: relative;
      overflow: hidden;
    }
    /* shine sweep */
    .card-head::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(110deg, rgba(255,255,255,0.08) 0%, transparent 60%);
      pointer-events: none;
    }

    .card-head h2 {
      font-size: 1.05rem;
      font-weight: 800;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      color: #fff;
    }
    .card-icon {
      width: 32px; height: 32px;
      border-radius: 8px;
      background: rgba(255,255,255,0.15);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.85rem;
      flex-shrink: 0;
      color: rgba(255,255,255,0.9);
    }
    .card-count {
      font-size: 0.68rem;
      font-weight: 700;
      background: rgba(0,0,0,0.3);
      color: rgba(255,255,255,0.85);
      border-radius: 999px;
      padding: 0.22rem 0.7rem;
      letter-spacing: 0.04em;
      white-space: nowrap;
      border: 1px solid rgba(255,255,255,0.12);
    }

    .head-mkt  { background: var(--g-marketing); }
    .head-rtc  { background: var(--g-rtc); }
    .head-rgu  { background: var(--g-rgu); }
    .head-mba  { background: var(--g-mba); }
    .head-aic  { background: var(--g-aic); }
    .head-slot { background: var(--g-slot); }

    /* ── Card Body ── */
    .card-body {
      padding: 1rem 1rem 1.25rem;
      display: flex;
      flex-direction: column;
      flex: 1;
      gap: 0.1rem;
    }

    /* ── Group label ── */
    .group-label {
      font-size: 0.63rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--muted);
      padding: 0.8rem 0.5rem 0.4rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .group-label::after {
      content: "";
      flex: 1;
      height: 1px;
      background: var(--border);
    }
    .group-label:first-child { padding-top: 0.25rem; }

    /* ── Link row ── */
    .dash-link {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.55rem 0.75rem;
      border-radius: 10px;
      font-size: 0.8rem;
      font-weight: 500;
      color: var(--text);
      text-decoration: none;
      transition: background 0.15s ease, color 0.15s ease, padding-left 0.15s ease;
      cursor: pointer;
      position: relative;
    }
    .dash-link .num {
      font-size: 0.65rem;
      font-weight: 700;
      color: var(--muted);
      min-width: 1.1rem;
      text-align: right;
      flex-shrink: 0;
    }
    .dash-link .arrow {
      margin-left: auto;
      font-size: 0.7rem;
      color: var(--muted);
      opacity: 0;
      transition: opacity 0.15s ease, transform 0.15s ease;
    }
    .dash-link:hover {
      background: rgba(255,255,255,0.055);
      color: var(--text-hi);
      padding-left: 1rem;
    }
    .dash-link:hover .num   { color: var(--dim); }
    .dash-link:hover .arrow { opacity: 1; transform: translateX(2px); }

    /* accent dot on hover — colour set per card via data attr */
    .dash-card.glow-rtc .dash-link:hover { background: rgba(14,165,160,0.08); }
    .dash-card.glow-rgu .dash-link:hover { background: rgba(217,119,6,0.08); }
    .dash-card.glow-mba .dash-link:hover { background: rgba(124,58,237,0.08); }
    .dash-card.glow-aic .dash-link:hover { background: rgba(220,38,38,0.08); }

    /* ── Disabled ── */
    .dash-link.disabled {
      pointer-events: none;
      color: var(--muted);
      opacity: 0.4;
    }
    .dash-link.disabled .num { color: #2d3e52; }

    /* ── Divider ── */
    .card-divider { height: 1px; background: var(--border); margin: 0.35rem 0.5rem; }

    /* ── Empty state ── */
    .card-empty {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 2.5rem 1rem;
    }
.card-empty span {
      font-size: 0.7rem;
      font-weight: 600;
      color: var(--muted);
      letter-spacing: 0.07em;
      text-transform: uppercase;
    }

    /* ── Stats strip at bottom of card ── */
    .card-footer-strip {
      border-top: 1px solid var(--border);
      padding: 0.65rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.5rem;
    }
    .strip-label {
      font-size: 0.65rem;
      color: var(--muted);
      font-weight: 500;
      letter-spacing: 0.04em;
    }
    .strip-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      flex-shrink: 0;
    }
    .dot-rtc { background: #0ea5a0; box-shadow: 0 0 6px #0ea5a0; }
    .dot-rgu { background: #d97706; box-shadow: 0 0 6px #d97706; }
    .dot-mba { background: #7c3aed; box-shadow: 0 0 6px #7c3aed; }
    .dot-aic { background: #dc2626; box-shadow: 0 0 6px #dc2626; }
    .dot-mkt { background: #60a5fa; box-shadow: 0 0 6px #60a5fa; }
    .dot-off { background: var(--muted); }

    /* ── Footer ── */
    .site-footer {
      text-align: center;
      padding: 1.5rem;
      font-size: 0.7rem;
      color: var(--muted);
      border-top: 1px solid var(--border);
      letter-spacing: 0.04em;
      position: relative;
      z-index: 1;
    }

    /* ── Responsive ── */
    @media (max-width: 1024px) {
      .dashboard { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
      .dashboard { grid-template-columns: 1fr; padding: 0 1rem; }
      .site-header { flex-wrap: wrap; gap: 0.5rem; padding: 0.75rem 1rem; justify-content: center; }
      .site-header h1 {
        position: static;
        transform: none;
        font-size: 0.9rem;
        width: 100%;
        text-align: center;
        order: 1;
      }
      .site-header > div:last-child { display: none; }
      .intro { padding: 1.5rem 1rem 1rem; }
    }
  </style>
@endpush

@section('body')


<!-- ── Header ── -->
<header class="site-header">
  <div class="logo-wrap">
    <img src="{{ storage_asset('report/logo.webp') }}" alt="Rathinam Logo" />
  </div>
  <h1><span>Dashboard</span> Map</h1>
  <div style="width:60px;"></div><!-- spacer to balance logo -->
</header>

<!-- ── Intro ── -->
<div class="intro">
  
</div>

<!-- ── Grid ── -->
<main class="dashboard">

  <!-- 1 · MARKETING -->
  <div class="dash-card glow-mkt">
    <div class="card-head head-mkt">
      <div class="card-icon"><i class="fa-solid fa-chart-pie"></i></div>
      <h2>Marketing</h2>
      <span class="card-count">9 Items</span>
    </div>
    <div class="card-body">
        
         <span class="group-label">Admission</span>
      <a href="https://report.rankuhigher.com/marketing/walkin-dashboard.php" class="dash-link"><span class="num">1.</span> Walkin Dashboard <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/marketing/rawdata-campaign.php" class="dash-link" target="_blank"><span class="num">2.</span> Raw Data Campaign <span class="arrow">›</span></a>

      <span class="group-label">Digital Marketing</span>
      <a href="https://report.rankuhigher.com/marketing/websitetraffic.php" class="dash-link" target="_blank"><span class="num">1.</span> Website Traffic <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/marketing/socialmedia.php" class="dash-link" target="_blank"><span class="num">2.</span> Social Media <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/marketing/alumni-campaign.php" class="dash-link" target="_blank"><span class="num">3.</span> Alumni Campaign <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/marketing/bharathiyar-campaign.php" class="dash-link" target="_blank"><span class="num">4.</span> Bharathiyar Campaign <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/marketing/ryhreport.php" class="dash-link" target="_blank"><span class="num">5.</span> RYH Report <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/marketing/ryh-incentive-report.php" class="dash-link" target="_blank"><span class="num">6.</span> RYH Incentive Report <span class="arrow">›</span></a>
      
      <a href="https://report.rankuhigher.com/marketing/youtube-insta-campaign.php" class="dash-link" target="_blank"><span class="num">7.</span>YouTube & Insta Followers Campaign<span class="arrow">›</span></a>

     

    </div>
    <div class="card-footer-strip">
     
      <span class="strip-label">Marketing</span>
    </div>
  </div>

  <!-- 2 · RTC -->
  <div class="dash-card glow-rtc">
    <div class="card-head head-rtc">
      <div class="card-icon"><i class="fa-solid fa-building-columns"></i></div>
      <h2>RTC</h2>
      <span class="card-count">9 Items</span>
    </div>
    <div class="card-body">
      <a href="https://report.rankuhigher.com/rtc/chairman-dashboard.php" class="dash-link" target="_blank"><span class="num">1.</span> Chairman Dashboard <span class="arrow">›</span></a>
      <a href="https://rathinamglobal.edu.in/gc" class="dash-link" target="_blank"><span class="num">2.</span> RAALE Dashboard <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rtc/rstnat.php" class="dash-link" target="_blank"><span class="num">3.</span> RSTnat Dashboard <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rtc/pcc.php" class="dash-link" target="_blank"><span class="num">4.</span> PCC <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rtc/placements.php" class="dash-link" target="_blank"><span class="num">5.</span> Placement <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rtc/s&h.php" class="dash-link" target="_blank"><span class="num">6.</span> S&H Dashboard <span class="arrow">›</span></a>
      <a href="https://aravindoffl.github.io/Faculty-JD/index.html" class="dash-link" target="_blank"><span class="num">7.</span> Job Description <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rtc/mca.php" class="dash-link" target="_blank"><span class="num">8.</span> MCA Dashboard <span class="arrow">›</span></a>
      <a href=" https://rathinam-c29-fellowship.netlify.app/" class="dash-link" target="_blank"><span class="num">9.</span> Rsamrt Intellect If You Know Me Dashboad <span class="arrow">›</span></a>
      <a href="https://forms.cloud.microsoft/Pages/AnalysisPage.aspx?AnalyzerToken=aDhsTc4xSvwz6Sr3NTjwLKUvwsYK2nwa&id=PdsUBy-IxEGFeTFGr1wquxiJKs2CeeRBrdqbL5eOxlxUNTNTTjhTNVYxSUdQNjVZRVJMNDhVWEhHUS4u" class="dash-link" target="_blank"><span class="num">10.</span> RGU If You Know Me Dashboard <span class="arrow">›</span></a>
      
     
    </div>
    <div class="card-footer-strip">
      
      <span class="strip-label">Rathinam Technical Campus</span>
    </div>
  </div>

  <!-- 3 · RGU -->
  <div class="dash-card glow-rgu">
    <div class="card-head head-rgu">
      <div class="card-icon"><i class="fa-solid fa-graduation-cap"></i></div>
      <h2>RGU</h2>
      <span class="card-count">9 Items</span>
    </div>
    <div class="card-body">
      <a href="https://report.rankuhigher.com/rgu/chairman-dashboard.php" class="dash-link" target="_blank"><span class="num">1.</span> Chairman <span class="arrow">›</span></a>
      <a href="#" class="dash-link disabled"><span class="num">2.</span> Global Affairs <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rgu/placement.php" class="dash-link" target="_blank" ><span class="num">3.</span> Placement <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rgu/research-board.php" class="dash-link" target="_blank"><span class="num">4.</span> Research Board <span class="arrow">›</span></a>
      <a href="#" class="dash-link disabled"><span class="num">5.</span> Student Affairs <span class="arrow">›</span></a>
      <a href="#" class="dash-link disabled"><span class="num">6.</span> Individual School Dashboard <span class="arrow">›</span></a>
      <a href="#" class="dash-link disabled"><span class="num">7.</span> RAALE Dashboard <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rgu/phd-dashboard.php" class="dash-link" target="_blank"><span class="num">8.</span> PhD Dashboard <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rgu/olt-feedback.php" class="dash-link" target="_blank"><span class="num">9.</span> OLT feedback <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/rgu/job-description.html" class="dash-link" target="_blank"><span class="num">10.</span>Job Description<span class="arrow">›</span></a>
    </div>
    <div class="card-footer-strip">
      
      <span class="strip-label">Rathinam Global University</span>
    </div>
  </div>

  <!-- 4 · MBA -->
  <div class="dash-card glow-mba">
    <div class="card-head head-mba">
      <div class="card-icon"><i class="fa-solid fa-briefcase"></i></div>
      <h2>MBA</h2>
      <span class="card-count">3 Items</span>
    </div>
    <div class="card-body">
      <a href="https://report.rankuhigher.com/mba/ralle.php" class="dash-link" target="_blank"><span class="num">1.</span> RAALE Dashboard <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/mba/happiness-index.php" class="dash-link" target="_blank"><span class="num">2.</span> Happiness Index <span class="arrow">›</span></a>
      <a href="https://report.rankuhigher.com/mba/mat.php" class="dash-link" target="_blank"><span class="num">3.</span> MAT <span class="arrow">›</span></a>
      <div class="card-empty">
        <div class="card-empty">
        
      </div>
      </div>
    </div>
    <div class="card-footer-strip">
     
      <span class="strip-label">MBA Department</span>
    </div>
  </div>

  <!-- 5 · AIC RAISE -->
  <div class="dash-card glow-aic">
    <div class="card-head head-aic">
      <div class="card-icon"><i class="fa-solid fa-rocket"></i></div>
      <h2>AIC RAISE</h2>
      <span class="card-count">1 Item</span>
    </div>
    <div class="card-body">
      <a href="https://report.rankuhigher.com/aicraise/aic-raise-dashboard.php" class="dash-link" target="_blank"><span class="num">1.</span>  AIC RAISE Dashboard <span class="arrow">›</span></a>
    </div>
    <div class="card-footer-strip">
      
      <span class="strip-label">AIC RAISE Incubation</span>
    </div>
  </div>

  <!--6 · Slot-->
  <div class="dash-card glow-aic">
    <div class="card-head head-aic">
      <div class="card-icon"><i class="fa-solid fa-rocket"></i></div>
      <h2>Creative Team Dashboard</h2>
      <span class="card-count">2 Item</span>
    </div>
    <div class="card-body">
      <a href="https://report.rankuhigher.com/creative/designers-dashboard.php" class="dash-link" target="_blank"><span class="num">1.</span>  Designers Dashboard <span class="arrow">›</span></a>
      <a href="https://script.google.com/macros/s/AKfycbyhnmJzcbORc2SXwD1f3OK3KG6h9i7V8ffWtwXmRsvwEXhV9-kKf-xgyV9AiDc72Yl6mw/exec" class="dash-link" target="_blank"><span class="num">2.</span>  Creative Team Dashboard <span class="arrow">›</span></a>
    </div>
    <div class="card-footer-strip">
      
      <span class="strip-label">AIC RAISE Incubation</span>
    </div>
  </div>

</main>

<footer class="site-footer">
  © {!! date('Y') !!} Rathinam Group of Institutions &nbsp;·&nbsp; Dashboard Map
</footer>

@endsection
