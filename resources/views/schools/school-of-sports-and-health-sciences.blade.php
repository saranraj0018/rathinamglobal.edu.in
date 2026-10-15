@extends('layouts.app')

@section('title', 'School of Sports & Health Sciences | RGU')

@push('head')
    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ versioned_asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body  { font-family: 'Sora', sans-serif; background: #f8fafc; }
        html, body { overflow-x: hidden; max-width: 100%; }
        .hero-grid-bg {
            background-image: linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 56px 56px;
        }
        .prog-card:hover .prog-number {
            background: linear-gradient(135deg, #a21caf, #7c3aed);
            color: #fff;
            border-color: transparent;
        }
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up   { animation: fade-up 0.7s ease both; }
        .delay-100 { animation-delay: .10s; }
        .delay-200 { animation-delay: .22s; }
    </style>
@endpush

@section('navigation')
<!-- STICKY NAVBAR -->
<nav class="sticky top-0 z-50 bg-white/85 backdrop-blur-xl border-b border-black/5 shadow-sm overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 min-w-0">

            <a href="{{ route('home') }}" class="flex-shrink-0 min-w-0">
                <img src="{{ storage_asset('assets/images/logo.webp') }}" alt="Rathinam Global University logo" class="h-9 w-auto max-w-[240px] sm:max-w-none object-contain object-left">
            </a>

            <!-- Desktop links -->
            <div class="hidden md:flex items-center gap-7">
                <a href="{{ route('home') }}"           class="text-sm font-medium text-slate-600 hover:text-fuchsia-700 transition">Home</a>
                <a href="{{ route('home') }}#courses"   class="text-sm font-medium text-slate-600 hover:text-fuchsia-700 transition">Schools</a>
                <a href="#programmes"           class="text-sm font-medium text-slate-600 hover:text-fuchsia-700 transition">Programmes</a>
                <a href="#careers"              class="text-sm font-medium text-slate-600 hover:text-fuchsia-700 transition">Careers</a>
                <a href="https://admissions.rathinamcollege.edu.in/?utm_source=school-page&utm_medium=navbar&utm_campaign=sports-health"
                   target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-fuchsia-500 to-purple-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/25 hover:scale-105 transition-transform">
                    Apply Now &#x2192;
                </a>
            </div>

            <!-- Hamburger -->
            <button id="mob-btn" class="md:hidden p-2 rounded-xl border border-black/10 text-slate-600" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile dropdown -->
        <div id="mob-menu" class="md:hidden hidden pb-4 space-y-1 border-t border-black/5 mt-1 pt-3">
            <a href="{{ route('home') }}"          class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-fuchsia-50">Home</a>
            <a href="{{ route('home') }}#courses"  class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-fuchsia-50">Schools</a>
            <a href="#programmes"          class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-fuchsia-50">Programmes</a>
            <a href="#careers"             class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-fuchsia-50">Careers</a>
            <a href="https://admissions.rathinamcollege.edu.in/" target="_blank"
               class="block px-3 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-fuchsia-500 to-purple-500 rounded-xl text-center mt-2">
                Apply Now
            </a>
        </div>
    </div>
</nav>
@endsection

@section('content')
<!-- HERO -->
<section class="relative overflow-hidden bg-[#080810] min-h-[90vh] flex items-center">

    <!-- Glow blobs -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 -left-24 w-[540px] h-[540px] rounded-full bg-fuchsia-700/25 blur-[140px]"></div>
        <div class="absolute -bottom-20 -right-10 w-[420px] h-[420px] rounded-full bg-purple-600/20 blur-[110px]"></div>
        <div class="absolute top-1/2 right-1/3 w-[260px] h-[260px] rounded-full bg-pink-600/10 blur-[80px]"></div>
    </div>
    <div class="absolute inset-0 hero-grid-bg pointer-events-none"></div>
    <div class="absolute top-0 inset-x-0 h-[2px] bg-gradient-to-r from-fuchsia-500 via-purple-500 to-violet-400"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24">
        <div class="grid lg:grid-cols-2 gap-14 items-center">

            <!-- Left content -->
            <div class="fade-up">
                <div class="inline-flex items-center gap-2 rounded-full border border-fuchsia-500/30 bg-fuchsia-500/10 px-4 py-1.5 mb-6">
                    <span class="h-1.5 w-1.5 rounded-full bg-fuchsia-400 animate-pulse"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-widest text-fuchsia-300">School of</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-[3.3rem] font-black text-white leading-[1.1] tracking-tight mb-6">
                    Sports &amp; Health<br>
                    <span class="x-2p9cp9yn">
                        Sciences
                    </span>
                </h1>

                <p class="text-base sm:text-lg leading-8 text-white/50 mb-9 max-w-lg">
                    Explore the science of the human mind and body. From sports performance to clinical psychology, our programmes build compassionate, evidence-based practitioners for tomorrow's healthcare.
                </p>

                <!-- Stats row -->
                <div class="mb-10 grid grid-cols-2 gap-x-8 gap-y-6 w-fit">
                </div>

                <!-- Buttons -->
                <div class="flex flex-wrap gap-4">
                    <a href="#programmes"
                       class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-fuchsia-500 to-purple-500 px-7 py-3.5 text-sm font-bold text-white shadow-[0_8px_32px_rgba(217,70,239,0.4)] hover:scale-105 transition-transform">
                        Explore Programmes &#x2192;
                    </a>
                    <a href="https://admissions.rathinamcollege.edu.in/" target="_blank"
                       class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-bold text-white/75 hover:bg-white/10 transition">
                        Apply Now
                    </a>
                </div>
            </div>

            <!-- Right: image -->
            <div class="relative hidden lg:block fade-up delay-200">
                <div class="rounded-3xl overflow-hidden border border-white/10 shadow-2xl h-[440px]">
                    <img src="{{ storage_asset('assets/images/life/School-of-Sports.webp') }}" alt="Sports and health sciences facilities at Rathinam Global University" class="w-full h-full object-cover opacity-55">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#080810]/80 via-[#080810]/10 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-white/40 mb-1">RGU Campus</p>
                        <p class="text-sm font-bold text-white leading-snug">Sports Science Labs — purpose-built for hands-on clinical practice.</p>
                    </div>
                </div>
                <div class="absolute -top-5 -left-5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-4 py-2.5 text-white text-sm font-semibold shadow-xl">
                    &#x1F9E0; Mind-Body Science
                </div>
                <div class="absolute -bottom-5 -right-5 bg-fuchsia-600/90 backdrop-blur-md border border-fuchsia-400/30 rounded-2xl px-4 py-2.5 text-white text-sm font-semibold shadow-xl">
                    &#x26BD; Sports Performance Lab
                </div>
            </div>

        </div>
    </div>

</section>


<!-- SECTION · SPORTS ACHIEVEMENTS (Year PDFs) -->
<section id="achievements" class="py-20 bg-[#f8fafc]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-2 rounded-full border border-fuchsia-700/20 bg-fuchsia-700/10 px-[18px] py-[7px] mb-5 w-max mx-auto">
            <span class="h-[6px] w-[6px] rounded-full bg-fuchsia-700 animate-pulse"></span>
            <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-fuchsia-700">Year-wise Reports</span>
        </div>

        <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-8">Sports Achievements</h2>

                <div class="flex flex-wrap gap-3 mb-12">
            @foreach ($years as $y)            <a href="{{ storage_asset('assets/sports_achievements/'.$y['file']) }}" target="_blank" rel="noopener"
               class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-fuchsia-500 to-purple-500 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-fuchsia-500/25 hover:scale-105 hover:shadow-fuchsia-500/40 transition-transform">
                {!! $y['label'] !!}            </a>
            @endforeach        </div>

        <!-- About Club -->
        <div class="mb-10">
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4">About Club</h3>
            <p class="text-slate-600 leading-7">
                Rathinam Global deemed to be University Sports Club is a premier facility offering a wide range of sports, including Basketball, Volleyball, Kabaddi, Shuttle Badminton, Turf and Grass Football, and an Indoor Sports Complex. The club promotes physical fitness, teamwork, and community engagement for all ages and skill levels. It provides a safe and inclusive environment for recreational and competitive sports, while also focusing on youth development, mental well-being, and fostering a sense of community. Rathinam Global deemed to be University Sports Club aims to be a hub for athletic growth and a place where individuals can thrive in sports.
            </p>
        </div>

        <!-- Objective -->
        <div class="mb-10">
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4">Objective</h3>
                        <ul class="space-y-3">
                @foreach ($objectives as $o)                <li class="flex gap-3 text-slate-600 leading-7">
                    <span class="mt-2.5 flex-shrink-0 w-1.5 h-1.5 rounded-full bg-fuchsia-500"></span>
                    <span><strong class="text-slate-900 font-semibold">{!! $o[0] !!}</strong> {!! $o[1] !!}</span>
                </li>
                @endforeach            </ul>
        </div>

        <!-- Club Activities -->
        <div class="mb-10">
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4">Club Activities</h3>
                        <ul class="space-y-3">
                @foreach ($activities as $a)                <li class="flex gap-3 text-slate-600 leading-7">
                    <span class="mt-2.5 flex-shrink-0 w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                    <span><strong class="text-slate-900 font-semibold">{!! $a[0] !!}</strong> {!! $a[1] !!}</span>
                </li>
                @endforeach            </ul>
        </div>

        <!-- Club Coordinator contact details -->
        <div>
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4">Club Coordinator contact details</h3>
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm divide-y divide-slate-100">
                @foreach ($coordinators as $c)                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:gap-3">
                    <p class="font-bold text-slate-900 text-sm sm:min-w-[240px]">{!! $c[0] !!}</p>
                    <p class="text-sm text-slate-600 leading-6">&ndash; {!! $c[1] !!}</p>
                </div>
                @endforeach            </div>
        </div>

    </div>
</section>


<!-- FOOTER (shared partial) -->
@endsection

@push('scripts')
<script>
    lucide.createIcons();

    // Mobile nav toggle
    const mobBtn  = document.getElementById('mob-btn');
    const mobMenu = document.getElementById('mob-menu');
    if (mobBtn && mobMenu) {
        mobBtn.addEventListener('click', () => mobMenu.classList.toggle('hidden'));
    }

    // Smooth scroll for on-page anchors
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                if (mobMenu) mobMenu.classList.add('hidden');
            }
        });
    });
</script>
@endpush
