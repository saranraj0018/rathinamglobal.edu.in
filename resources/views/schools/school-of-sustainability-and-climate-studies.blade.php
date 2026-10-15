@extends('layouts.app')

@section('title', 'School of Sustainability & Climate Studies | RGU')

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
            background: linear-gradient(135deg, #0d9488, #0891b2);
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
                <a href="{{ route('home') }}"           class="text-sm font-medium text-slate-600 hover:text-teal-700 transition">Home</a>
                <a href="{{ route('home') }}#courses"   class="text-sm font-medium text-slate-600 hover:text-teal-700 transition">Schools</a>
                <a href="#programmes"           class="text-sm font-medium text-slate-600 hover:text-teal-700 transition">Programmes</a>
                <a href="#careers"              class="text-sm font-medium text-slate-600 hover:text-teal-700 transition">Careers</a>
                <a href="https://admissions.rathinamcollege.edu.in/?utm_source=school-page&utm_medium=navbar&utm_campaign=sustainability"
                   target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-teal-500/25 hover:scale-105 transition-transform">
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
            <a href="{{ route('home') }}"          class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-teal-50">Home</a>
            <a href="{{ route('home') }}#courses"  class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-teal-50">Schools</a>
            <a href="#programmes"          class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-teal-50">Programmes</a>
            <a href="#careers"             class="block px-3 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-teal-50">Careers</a>
            <a href="https://admissions.rathinamcollege.edu.in/" target="_blank"
               class="block px-3 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl text-center mt-2">
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
        <div class="absolute -top-24 -left-24 w-[540px] h-[540px] rounded-full bg-teal-700/25 blur-[140px]"></div>
        <div class="absolute -bottom-20 -right-10 w-[420px] h-[420px] rounded-full bg-cyan-600/20 blur-[110px]"></div>
        <div class="absolute top-1/2 right-1/3 w-[260px] h-[260px] rounded-full bg-emerald-600/10 blur-[80px]"></div>
    </div>
    <div class="absolute inset-0 hero-grid-bg pointer-events-none"></div>
    <div class="absolute top-0 inset-x-0 h-[2px] bg-gradient-to-r from-teal-400 via-cyan-400 to-emerald-400"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24">
        <div class="grid lg:grid-cols-2 gap-14 items-center">

            <!-- Left content -->
            <div class="fade-up">
                <div class="inline-flex items-center gap-2 rounded-full border border-teal-500/30 bg-teal-500/10 px-4 py-1.5 mb-6">
                    <span class="h-1.5 w-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-widest text-teal-300">School of</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-[3.3rem] font-black text-white leading-[1.1] tracking-tight mb-6">
                    Sustainability &amp;<br>
                    <span class="x-1a0twa4r">
                        Climate Studies
                    </span>
                </h1>

                <p class="text-base sm:text-lg leading-8 text-white/50 mb-9 max-w-lg">
                    Shape the future of our planet. Our programmes equip graduates with the scientific knowledge, policy tools, and systems thinking needed to tackle the climate crisis and build a sustainable world.
                </p>

                <!-- Stats row -->
                <div class="mb-10 grid grid-cols-2 gap-x-8 gap-y-6 w-fit">
                    <div>
                        <p class="text-3xl font-black text-white">2</p>
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-white/35 mt-0.5">Programmes</p>
                    </div>
                    <div class="pl-7 border-l border-white/10">
                        <p class="text-lg font-black text-white leading-tight">AI-Focused</p>
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-white/35 mt-0.5">Specializations</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white">100%</p>
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-white/35 mt-0.5">Placement Support</p>
                    </div>
                    <div class="pl-7 border-l border-white/10">
                        <p class="text-lg font-black text-white leading-tight">Industry</p>
                        <p class="text-[11px] font-semibold uppercase tracking-widest text-white/35 mt-0.5">Tie-ups</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-wrap gap-4">
                    <a href="#programmes"
                       class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 px-7 py-3.5 text-sm font-bold text-white shadow-[0_8px_32px_rgba(20,184,166,0.4)] hover:scale-105 transition-transform">
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
                    <img src="{{ storage_asset('assets/images/life/School-of-sustainability&climate-schools.webp') }}" alt="Sustainability and climate studies facilities at Rathinam Global University" class="w-full h-full object-cover opacity-55">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#080810]/80 via-[#080810]/10 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <p class="text-xs font-semibold uppercase tracking-widest text-white/40 mb-1">RGU Campus</p>
                        <p class="text-sm font-bold text-white leading-snug">Environmental Research Centre — pioneering solutions for a sustainable tomorrow.</p>
                    </div>
                </div>
                <div class="absolute -top-5 -left-5 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-4 py-2.5 text-white text-sm font-semibold shadow-xl">
                    &#x1F331; Green Campus Initiative
                </div>
                <div class="absolute -bottom-5 -right-5 bg-teal-600/90 backdrop-blur-md border border-teal-400/30 rounded-2xl px-4 py-2.5 text-white text-sm font-semibold shadow-xl">
                    &#x1F30D; Climate Policy Lab
                </div>
            </div>

        </div>
    </div>

</section>


<!-- SECTION 2 · SCHOOL OVERVIEW -->
<section id="overview" class="py-20 bg-[#f8fafc]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-2 rounded-full border border-teal-700/20 bg-teal-700/10 px-[18px] py-[7px] mb-5 w-max mx-auto">
            <span class="h-[6px] w-[6px] rounded-full bg-teal-700 animate-pulse"></span>
            <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-teal-700">School Overview</span>
        </div>

        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-4">About the School</h2>
        <p class="text-center text-slate-500 max-w-2xl mx-auto mb-14 leading-7">
            The School of Sustainability &amp; Climate Studies at RGU is at the forefront of environmental education. We prepare graduates to understand and address the most pressing ecological challenges — from climate policy to sustainable development — through interdisciplinary science and practice.
        </p>

        <!-- 3 pillars -->
        <div class="grid md:grid-cols-3 gap-6 mb-14">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-2xl bg-teal-100 flex items-center justify-center mb-5">
                    <i data-lucide="clock" class="w-5 h-5 text-teal-700"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">UG &middot; PG</h3>
                <p class="text-sm leading-6 text-slate-500">From a 3-year undergraduate degree to a 2-year Master's we offer pathways for every career stage.</p>
            </div>
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-2xl bg-cyan-100 flex items-center justify-center mb-5">
                    <i data-lucide="leaf" class="w-5 h-5 text-cyan-700"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Field &amp; Lab Research</h3>
                <p class="text-sm leading-6 text-slate-500">Environmental field trips, GIS mapping labs, carbon footprint audits, and sustainability-focused industry projects with corporate and government partners.</p>
            </div>
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center mb-5">
                    <i data-lucide="globe" class="w-5 h-5 text-emerald-700"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Policy &amp; Systems Thinking</h3>
                <p class="text-sm leading-6 text-slate-500">Engage with national environmental policy, international climate agreements (COP, UNFCCC), ESG frameworks, and circular economy principles.</p>
            </div>
        </div>

        <!-- Stats strip -->
        <div class="rounded-3xl bg-gradient-to-r from-teal-500 to-cyan-500 p-px">
            <div class="rounded-3xl bg-[#0d0d1a] px-8 py-10 grid grid-cols-2 sm:grid-cols-4 gap-8 text-center">
                @foreach ($highlights as $h)                <div>
                    <p class="text-3xl lg:text-4xl font-black text-white mb-1">{!! $h['val'] !!}</p>
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-white/35">{!! $h['label'] !!}</p>
                </div>
                @endforeach            </div>
        </div>
    </div>
</section>


<!-- SECTION 3 · WHAT YOU'LL LEARN -->
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-2 rounded-full border border-teal-500/20 bg-teal-500/10 px-[18px] py-[7px] mb-5 w-max mx-auto">
            <span class="h-[6px] w-[6px] rounded-full bg-teal-500 animate-pulse"></span>
            <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-teal-600">Curriculum Focus</span>
        </div>

        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-4">What You'll Learn</h2>
        <p class="text-center text-slate-500 max-w-xl mx-auto mb-14 leading-7">
            An interdisciplinary curriculum built around environmental science, climate policy, sustainability management, and data-driven ecological research.
        </p>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-5">
            @foreach ($skills as $s)            <div class="{!! $s['bg'] !!} rounded-2xl p-6 hover:shadow-md transition-shadow">
                <div class="w-11 h-11 {!! $s['ibg'] !!} rounded-xl flex items-center justify-center mb-4">
                    <i data-lucide="{!! $s['icon'] !!}" class="w-5 h-5 {!! $s['ic'] !!}"></i>
                </div>
                <h4 class="font-bold text-slate-900 text-sm mb-1.5">{!! $s['title'] !!}</h4>
                <p class="text-xs leading-5 text-slate-500">{!! $s['desc'] !!}</p>
            </div>
            @endforeach        </div>
    </div>
</section>


<!-- SECTION 4 · PROGRAMMES OFFERED -->
<section id="programmes" class="py-20 bg-[#f8fafc]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-2 rounded-full border border-teal-700/20 bg-teal-700/10 px-[18px] py-[7px] mb-5 w-max mx-auto">
            <span class="h-[6px] w-[6px] rounded-full bg-teal-700 animate-pulse"></span>
            <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-teal-700">2 Programmes</span>
        </div>

        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-4">Programmes Offered</h2>
        <p class="text-center text-slate-500 max-w-2xl mx-auto mb-14 leading-7">
            Specialised programmes at undergraduate, postgraduate, and diploma level designed to build the next generation of environmental leaders and climate practitioners.
        </p>

        <!-- B.Sc -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white text-sm font-black shadow-lg shadow-teal-500/30">1</span>
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Undergraduate Programme</h3>
                    <p class="text-xs text-slate-400">3 Years &middot; B.Sc &middot; Full Time</p>
                </div>
            </div>
            <div class="grid sm:grid-cols-1 gap-4 max-w-2xl">
                @foreach ($bsc as $i => $course)                <div class="prog-card bg-white border border-slate-100 rounded-2xl p-5 hover:border-teal-200 hover:shadow-md transition group cursor-default">
                    <div class="flex items-start gap-3">
                        <span class="prog-number mt-0.5 w-6 h-6 rounded-full bg-teal-50 border border-teal-200 text-teal-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 transition-all">{!! $i+1 !!}</span>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 leading-snug group-hover:text-teal-700 transition">{!! $course !!}</p>
                            <div class="flex gap-2 mt-2 flex-wrap">
                                <span class="text-[10px] bg-teal-50 text-teal-600 border border-teal-100 rounded-full px-2 py-0.5 font-medium">3 Years</span>
                                <span class="text-[10px] bg-slate-50 text-slate-500 border border-slate-100 rounded-full px-2 py-0.5 font-medium">Full Time</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach            </div>
        </div>

        <!-- M.Sc -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-9 h-9 rounded-full bg-gradient-to-br from-cyan-500 to-sky-500 flex items-center justify-center text-white text-sm font-black shadow-lg shadow-cyan-500/30">2</span>
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Postgraduate Programme</h3>
                    <p class="text-xs text-slate-400">2 Years &middot; M.Sc &middot; Full Time</p>
                </div>
            </div>
            <div class="grid sm:grid-cols-1 gap-4 max-w-2xl">
                @foreach ($msc as $i => $course)                <div class="prog-card bg-white border border-slate-100 rounded-2xl p-5 hover:border-cyan-200 hover:shadow-md transition group cursor-default">
                    <div class="flex items-start gap-3">
                        <span class="prog-number mt-0.5 w-6 h-6 rounded-full bg-cyan-50 border border-cyan-200 text-cyan-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0 transition-all">{!! $i+1 !!}</span>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 leading-snug group-hover:text-cyan-700 transition">{!! $course !!}</p>
                            <div class="flex gap-2 mt-2 flex-wrap">
                                <span class="text-[10px] bg-cyan-50 text-cyan-600 border border-cyan-100 rounded-full px-2 py-0.5 font-medium">2 Years</span>
                                <span class="text-[10px] bg-slate-50 text-slate-500 border border-slate-100 rounded-full px-2 py-0.5 font-medium">Full Time</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach            </div>
        </div>

        

        <!-- Bottom CTA -->
        <div class="mt-14 text-center">
            <a href="https://admissions.rathinamcollege.edu.in/?utm_source=school-page&utm_medium=programmes-cta&utm_campaign=sustainability"
               target="_blank"
               class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-teal-500 to-cyan-500 px-8 py-4 text-sm font-bold text-white shadow-[0_8px_32px_rgba(20,184,166,0.35)] hover:scale-105 transition-transform">
                Apply for These Programmes &#x2192;
            </a>
        </div>
    </div>
</section>


<!-- SECTION 5 · CAREER PATHWAYS -->
<section id="careers" class="py-20 bg-[#080810] relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4    w-[400px] h-[400px] rounded-full bg-teal-700/15 blur-[100px]"></div>
        <div class="absolute bottom-0 right-1/4 w-[300px] h-[300px] rounded-full bg-cyan-600/10  blur-[80px]"></div>
    </div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-2 rounded-full border border-lime-400/20 bg-lime-400/10 px-[18px] py-[7px] mb-5 w-max mx-auto">
            <span class="h-[6px] w-[6px] rounded-full bg-lime-400 animate-pulse"></span>
            <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-lime-300">After Graduation</span>
        </div>

        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-white mb-4">Career Pathways</h2>
        <p class="text-center text-white/40 max-w-xl mx-auto mb-14 leading-7">
            Our graduates join governments, international organisations, NGOs, corporations, and research institutions leading the charge on sustainability and climate action.
        </p>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($careers as $c)            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 hover:border-white/20 transition">
                <div class="text-2xl mb-3">{!! $c['emoji'] !!}</div>
                <h4 class="text-sm font-bold text-white mb-1.5 leading-snug">{!! $c['role'] !!}</h4>
                <p class="text-xs text-white/30 leading-5">{!! $c['companies'] !!}</p>
            </div>
            @endforeach        </div>
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
