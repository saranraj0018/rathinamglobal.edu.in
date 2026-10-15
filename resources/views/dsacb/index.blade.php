{{-- DSACB 2027 conference landing page: no site nav by request, shared footer only. Content: resources/data/dsacb.php. --}}
@extends('layouts.app')

@section('title', 'DSACB 2027 | Rathinam Global University, Coimbatore')
@section('description'){{ $description }}@endsection
@section('body-attributes') class="lp"@endsection

@push('head')

    <meta name="theme-color" content="#050508">
    <meta name="robots" content="index,follow">
    <meta property="og:title" content="DSACB 2027 | Rathinam Global University">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ storage_asset('assets/images/logo.webp') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="DSACB 2027 | Rathinam Global University">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ storage_asset('assets/images/logo-360.webp') }}">

    <style>body{margin:0!important;padding:0!important;background:#050508}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Site chrome (needed by the shared footer), then this page's own theme. -->
    <link rel="stylesheet" href="{{ versioned_asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ versioned_asset('css/dsacb/style.css') }}">
@endpush

@section('without-navigation', true)

@section('content')


<a class="lp-skip" href="#about">Skip to content</a>

<!-- ══════════ IN-PAGE NAV ══════════ -->
<nav class="lp-nav" id="lp-nav" aria-label="Conference sections">
    <div class="lp-wrap lp-nav__bar">

        <a class="lp-nav__brand" href="#home" aria-label="DSACB 2027 — back to top">
            <img src="{{ storage_asset('assets/images/logo-360.webp') }}" alt="Rathinam Global University"
                 width="234" height="28" decoding="async">
        </a>

        <button type="button" class="lp-nav__toggle" id="lp-nav-toggle"
                aria-expanded="false" aria-controls="lp-nav-menu">
            <span class="lp-nav__bars" aria-hidden="true"></span>
            <span class="sr-only">Conference sections menu</span>
        </button>

        <ul class="lp-nav__menu" id="lp-nav-menu">
            @foreach ($nav as [$label, $id])
                <li><a href="#{{ $id }}" data-lp-nav="{{ $id }}">{{ $label }}</a></li>
            @endforeach
            <li class="lp-nav__cta"><a href="#registration">Register</a></li>
        </ul>

    </div>
</nav>

<!-- ══════════ HERO ══════════ -->
<header class="lp-hero" id="home">
    <div class="lp-hero__glow" aria-hidden="true"></div>
    <div class="lp-wrap lp-hero__inner">
        <p class="lp-hero__kick">First Multidisciplinary International Conference on</p>
        <h1 class="lp-hero__title">
            Driving Sustainability through <span class="lp-grad">AI, Climate Resilience,</span> and Behavioural Sciences
        </h1>
        <p class="lp-hero__dates"><span>FEB 15 &amp; 16, 2027</span><i aria-hidden="true"></i><span>Mode: Hybrid</span></p>
        <p class="lp-hero__loc">
            Rathinam Global Deemed to be University, Coimbatore, India<br>
            In Collaboration with UTAS Al Mussanah, Oman
        </p>
        <div class="lp-hero__acts">
            <a class="lp-btn" href="#about">Explore Conference</a>
            <a class="lp-btn lp-btn--ghost" href="#registration">Registration &amp; Fees</a>
        </div>
    </div>
</header>

<main>

<!-- ══════════ ABOUT ══════════ -->
<section class="lp-sec" id="about">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Overview</span>
            <h2 class="lp-h2">About the <span class="lp-grad">Conference</span></h2>
        </header>
        <div class="lp-card lp-prose">
            <p>In an era defined by rapid technological advancement and mounting environmental challenges, sustainable
                development can no longer be addressed through siloed disciplinary approaches. The conference, &ldquo;An
                Interdisciplinary Perspective for a Sustainable Future through AI-Driven Digital Transformation, Climate
                Resilience and Behavioural Sciences,&rdquo; brings together researchers, academicians, industry
                practitioners, policymakers, and students to explore how artificial intelligence, climate science,
                behavioural insights, and human wellbeing intersect to shape a resilient and sustainable future. The
                conference seeks to foster meaningful dialogue and collaborative innovation across disciplines —
                recognizing that technological solutions alone cannot drive sustainability without an understanding of
                human behaviour, social equity, and ecological realities.</p>
            <p>By bridging AI and digital transformation with climate resilience, behavioural sciences, health equity,
                education, and green economic models, this conference aims to generate holistic, actionable insights
                that respond to the complex, interconnected nature of today&rsquo;s sustainability challenges across
                climate researchers, sustainability practitioners, data scientists, and AI developers at Rathinam Global
                Deemed to be University (RGU), Coimbatore, in collaboration with UTAS Al Mussanah, Oman.</p>
        </div>
    </div>
</section>

<!-- ══════════ SCOPE ══════════ -->
<section class="lp-sec lp-sec--alt" id="scope">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Call for papers</span>
            <h2 class="lp-h2">Scope of the <span class="lp-grad">Conference</span></h2>
        </header>
        <div class="lp-card">
            <p class="lp-prose">The conference invites original research, case studies, policy analyses, and applied
                innovations that address sustainability through interdisciplinary lenses, including but not limited to:</p>
            <ul class="lp-list">
                @foreach ($scope as $s)
<li>{{ $s }}</li>@endforeach
            </ul>
        </div>
    </div>
</section>

<!-- ══════════ TRACKS ══════════ -->
<section class="lp-sec" id="tracks">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Six tracks</span>
            <h2 class="lp-h2">Conference <span class="lp-grad">Tracks and Topics</span></h2>
            <p class="lp-lede">Select a track to see its topics.</p>
        </header>
        <div class="lp-acc">
            @foreach ($tracks as $i => [$title, $accent, $topics])
                <div class="lp-acc__item lp-a-{!! $accent !!}">
                    <h3 class="lp-acc__h">
                        <button type="button" class="lp-acc__btn" aria-expanded="{!! $i === 0 ? 'true' : 'false' !!}"
                                aria-controls="track-{!! $i !!}" id="trackbtn-{!! $i !!}">
                            <span class="lp-acc__dot" aria-hidden="true"></span>
                            <span class="lp-acc__label">{{ $title }}</span>
                            <svg class="lp-acc__chev" viewBox="0 0 24 24" width="18" height="18" fill="none"
                                 stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>
                    </h3>
                    <div class="lp-acc__panel" id="track-{!! $i !!}" role="region" aria-labelledby="trackbtn-{!! $i !!}">
                        <ol class="lp-acc__list">
                            @foreach ($topics as $t)
<li>{{ $t }}</li>@endforeach
                        </ol>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ══════════ COMMITTEE ══════════ -->
<section class="lp-sec lp-sec--alt" id="committee">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Organisers</span>
            <h2 class="lp-h2">Committee <span class="lp-grad">Members</span></h2>
        </header>
        <div class="lp-grid">
            @foreach ($committee as [$role, $people, $accent])
                <article class="lp-gcard lp-a-{!! $accent !!}">
                    <h3>{{ $role }}</h3>
                    <p>{!! $people !== '' ? e($people) : '<span class="lp-tbd">To be announced</span>' !!}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- ══════════ DATES ══════════ -->
<section class="lp-sec" id="dates">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Timeline</span>
            <h2 class="lp-h2">Important <span class="lp-grad">Dates</span></h2>
        </header>
        <div class="lp-tablewrap">
            <table class="lp-table">
                <thead><tr><th scope="col">Details</th><th scope="col">Dates</th></tr></thead>
                <tbody>
                    @foreach ($dates as [$what, $when, $hl])
                        <tr{!! $hl ? ' class="is-hl"' : '' !!}>
                            <td>{!! $hl ? '<strong>' . e($what) . '</strong>' : e($what) !!}</td>
                            <td>{!! $hl ? '<strong>' . e($when) . '</strong>' : e($when) !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- ══════════ REGISTRATION ══════════ -->
<section class="lp-sec lp-sec--alt" id="registration">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Fees</span>
            <h2 class="lp-h2">Registration <span class="lp-grad">Fee</span></h2>
            <p class="lp-lede">Note: Registration fees are subject to finalisation by the Research Dean.</p>
        </header>
        <div class="lp-tablewrap">
            <table class="lp-table">
                <thead><tr><th scope="col">Category</th><th scope="col">Indian Authors</th><th scope="col">Foreign Authors</th></tr></thead>
                <tbody>
                    @foreach ($fees as [$cat, $inr, $usd])
                        <tr>
                            <td>{{ $cat }}</td>
                            <td class="lp-amt">{{ $inr }}</td>
                            <td>{!! $usd !== '' ? e($usd) : '<span class="lp-tbd">—</span>' !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- ══════════ PAYMENT ══════════ -->
<section class="lp-sec" id="payment">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">How to pay</span>
            <h2 class="lp-h2">Payment <span class="lp-grad">Details</span></h2>
        </header>
        <div class="lp-pay">
            <div class="lp-card lp-pay__info">
                <h3 class="lp-pay__h">Bank Transfer Details</h3>
                <ul class="lp-paylist">
                    <li><span>Bank Name</span><b>Federal Bank</b></li>
                    <li><span>Account Name</span><b>RATHINAM GLOBAL FOUNDATION</b></li>
                    <li><span>Account Number</span><b>23510200004589</b></li>
                    <li><span>IFSC Code</span><b>FDRL0002351</b></li>
                </ul>
                <div class="lp-upi">
                    <span class="lp-upi__tag">UPI Pay</span>
                    <span class="lp-upi__id">vyapar.173351355001@hdfcbank</span>
                </div>
            </div>
            <div class="lp-card lp-pay__qr">
                <p class="lp-qr__label">Scan to Pay via UPI</p>
                <img src="{{ storage_asset('dsacb/qr_code.jpg') }}" alt="UPI QR code for DSACB 2027 conference payment" width="220" height="220" loading="lazy" decoding="async">
                <p class="lp-qr__note">Supports GPay, PhonePe, Paytm &amp; all UPI apps</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ PUBLICATION ══════════ -->
<section class="lp-sec lp-sec--alt" id="publication">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Proceedings</span>
            <h2 class="lp-h2">Publication <span class="lp-grad">Proposal</span></h2>
            <p class="lp-lede">Scroll the table sideways to see every column.</p>
        </header>
        <div class="lp-tablewrap">
            <table class="lp-table lp-table--wide">
                <thead>
                    <tr>
                        <th scope="col">Publisher</th><th scope="col">Open Access / APC</th>
                        <th scope="col">Scopus Indexing</th><th scope="col">Papers / Page Volume</th>
                        <th scope="col">Duration</th><th scope="col">Publication Cost &amp; Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publishers as [$name, $sub, $oa, $scopus, $vol, $dur, $remark])
                        <tr>
                            <td><strong>{!! $name !!}</strong>{!! $sub !== '' ? '<br><small>' . $sub . '</small>' : '' !!}</td>
                            <td>{!! $oa !!}</td>
                            <td>{!! $scopus !!}</td>
                            <td>{!! $vol !!}</td>
                            <td>{!! $dur !!}</td>
                            <td>{!! $remark !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- ══════════ NOTES ══════════ -->
<section class="lp-sec" id="notes">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Conditions</span>
            <h2 class="lp-h2">Important Notes &amp; <span class="lp-grad">Conditions</span></h2>
        </header>
        <div class="lp-card">
            <ol class="lp-notes">
                @foreach ($notes as [$label, $text])
                    <li><strong>{!! $label !!}</strong> {!! $text !!}</li>
                @endforeach
            </ol>
            <p class="lp-scopus">* All presented papers will be published in a Scopus-indexed journal.</p>
        </div>
    </div>
</section>

<!-- ══════════ BUDGET ══════════ -->
<section class="lp-sec lp-sec--alt" id="budget">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Planning</span>
            <h2 class="lp-h2">Estimated <span class="lp-grad">Budget Proposal</span></h2>
        </header>
        <div class="lp-tablewrap">
            <table class="lp-table">
                <thead><tr><th scope="col">Description of Expense</th><th scope="col">Estimated Amount (INR)</th></tr></thead>
                <tbody>
                    @foreach ($budget as [$what, $amt, $hl])
                        <tr{!! $hl ? ' class="is-hl"' : '' !!}>
                            <td>{!! $hl ? '<strong>' . $what . '</strong>' : $what !!}</td>
                            <td class="lp-amt">{!! $hl ? '<strong>' . e($amt) . '</strong>' : e($amt) !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="lp-foot-note">Note: All amounts are indicative and subject to revision.</p>
    </div>
</section>

<!-- ══════════ AGENDA ══════════ -->
<section class="lp-sec" id="agenda">
    <div class="lp-wrap">
        <header class="lp-head">
            <span class="lp-kick">Two days</span>
            <h2 class="lp-h2">Programme Agenda <span class="lp-grad">(Tentative)</span></h2>
        </header>

        @foreach ([
            ['Day 1 — February 15, 2027', 'RGU Coimbatore', $agendaDay1, 'violet'],
            ['Day 2 — February 16, 2027', 'RGU Coimbatore', $agendaDay2, 'blue'],
        ] as [$day, $venue, $rows, $accent])            <div class="lp-day lp-a-{!! $accent !!}">
                <h3 class="lp-day__h"><span class="lp-day__pill">{{ $day }}</span> <small>{{ $venue }}</small></h3>
                <div class="lp-tablewrap">
                    <table class="lp-table">
                        <thead><tr><th scope="col">S.No</th><th scope="col">Event</th><th scope="col">Venue</th><th scope="col">Time</th></tr></thead>
                        <tbody>
                            @foreach ($rows as $i => [$ev, $vn, $tm])
                                <tr>
                                    <td class="lp-sno">{!! $i + 1 !!}</td>
                                    <td>{!! $ev !!}</td>
                                    <td>{{ $vn }}</td>
                                    <td class="lp-time">{{ $tm }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- ══════════ ORGANISERS STRIP ══════════ -->
<section class="lp-sec lp-sec--alt lp-org">
    <div class="lp-wrap lp-org__grid">
        <div><span>Organised by</span><b>Rathinam Global Deemed to be University, Coimbatore, India</b></div>
        <div><span>In Collaboration with</span><b>UTAS Al Mussanah, Oman</b></div>
        <div><span>Conference Dates</span><b>February 15–16, 2027</b></div>
    </div>
</section>

</main>
@endsection

@push('scripts')

<script src="{{ versioned_asset('js/dsacb/script.js') }}" defer></script>
@endpush
