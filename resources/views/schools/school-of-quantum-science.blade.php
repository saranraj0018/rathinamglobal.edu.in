@extends('layouts.app')

@section('title', 'School of Quantum Science, Computing & AI | RGU')

@push('head')
    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ storage_asset('assets/css/style.css') }}">
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
            background: linear-gradient(135deg, #7e22ce, #6d28d9);
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

        /* Hero slider — smooth fade + slide */
        .hero-slider {
            position: relative;
            min-height: 520px;
        }
        @media (max-width: 1024px) { .hero-slider { min-height: 560px; } }
        @media (max-width: 640px)  { .hero-slider { min-height: 600px; } }
        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
            pointer-events: none;
        }
        .hero-slide.is-active {
            opacity: 1;
            transform: translateX(0);
            pointer-events: auto;
            position: relative;   /* the active slide drives the container height */
        }

        /* Edge-card watermark numbers (CU style) */
        .edge-num {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 84px;
            line-height: 1;
            background: linear-gradient(180deg, rgba(168,85,247,0.18), rgba(168,85,247,0));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Marquee */
        .marquee { display:flex; gap:64px; animation: marquee 28s linear infinite; }
        @keyframes marquee {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        /* Tabs */
        .dept-tab.active {
            background: linear-gradient(135deg, #7e22ce, #6d28d9);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 8px 24px rgba(126,34,206,0.35);
        }

        /* How-to-apply step */
        .apply-step.active .apply-dot { background:#7e22ce; color:#fff; border-color:#7e22ce; }
        .apply-step.active .apply-label { color:#0f172a; font-weight:700; }
    </style>
@endpush

@section('navigation')
    <x-courses-nav
        school-name="School of Quantum Science, Computing & AI"
        school-href="#"
        apply-url="https://admissions.rathinamcollege.edu.in/?utm_source=school-page&utm_medium=navbar&utm_campaign=quantum-science"
        accent="purple"
    />
@endsection

@section('content')

<!-- 1 · HERO (with right side Apply card) -->
<section class="relative overflow-hidden bg-[#080810] min-h-[90vh] flex items-center">

    <!-- Glow blobs -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 -left-24 w-[540px] h-[540px] rounded-full bg-purple-700/25 blur-[140px]"></div>
        <div class="absolute -bottom-20 -right-10 w-[420px] h-[420px] rounded-full bg-violet-600/20 blur-[110px]"></div>
        <div class="absolute top-1/2 right-1/3 w-[260px] h-[260px] rounded-full bg-fuchsia-600/10 blur-[80px]"></div>
    </div>
    <div class="absolute inset-0 hero-grid-bg pointer-events-none"></div>
    <div class="absolute top-0 inset-x-0 h-[2px] bg-gradient-to-r from-purple-500 via-violet-500 to-sky-400"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-12 items-center">

            <!-- Left content SLIDER -->
                        <div class="fade-up">
                <div class="hero-slider">
                    @foreach ($heroSlides as $i => $s)                    <div class="hero-slide {!! $i === 0 ? 'is-active' : '' !!}" data-slide="{!! $i !!}">
                        <div class="inline-flex items-center gap-2 rounded-full border border-purple-500/30 bg-purple-500/10 px-4 py-1.5 mb-6">
                            <span class="h-1.5 w-1.5 rounded-full bg-purple-400 animate-pulse"></span>
                            <span class="text-[11px] font-semibold uppercase tracking-widest text-purple-300">{!! $s['eyebrow'] !!}</span>
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-[3.3rem] font-black text-white leading-[1.1] tracking-tight mb-5">
                            {!! $s['h_pre'] !!}<span class="x-2fvm9igr">{!! $s['h_mark'] !!}</span><br>
                            {!! $s['h_post'] !!}                        </h1>

                        <p class="text-base sm:text-lg leading-8 text-white/55 mb-8 max-w-lg">{!! $s['p'] !!}</p>

                        <!-- Buttons -->
                        <div class="flex flex-wrap gap-4 mb-8">
                            <a href="https://admissions.rathinamcollege.edu.in/" target="_blank"
                               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-500 to-violet-500 px-7 py-3.5 text-sm font-bold text-white shadow-[0_8px_32px_rgba(168,85,247,0.4)] hover:scale-105 transition-transform">
                                Apply Today &#x2192;
                            </a>
                            <a href="#programmes"
                               class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-bold text-white/75 hover:bg-white/10 transition">
                                Download Brochure
                            </a>
                        </div>

                        <!-- Badge row -->
                        <div class="inline-flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md px-5 py-3">
                            <div>
                                <p class="text-2xl font-black text-white leading-none">{!! $s['pkg1'] !!}</p>
                                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/40 mt-1">{!! $s['pkg1_l'] !!}</p>
                            </div>
                            <span class="h-10 w-px bg-white/10"></span>
                            <div>
                                <p class="text-2xl font-black text-white leading-none">{!! $s['pkg2'] !!}</p>
                                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/40 mt-1">{!! $s['pkg2_l'] !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- Slider controls -->
                    <div class="mt-10 flex items-center gap-4">
                        <button id="hero-prev" type="button" class="w-10 h-10 rounded-full border border-white/15 bg-white/5 text-white/70 hover:bg-white/10 hover:text-white transition flex items-center justify-center" aria-label="Previous">
                            <i data-lucide="chevron-left" class="w-5 h-5"></i>
                        </button>
                        <div id="hero-dots" class="flex items-center gap-2">
                            @foreach ($heroSlides as $i => $_)                                <button type="button" data-dot="{!! $i !!}" class="hero-dot rounded-full transition-all {!! $i === 0 ? 'w-8 h-2 bg-purple-400' : 'w-2 h-2 bg-white/25' !!}" aria-label="Slide {!! $i+1 !!}"></button>
                            @endforeach                        </div>
                        <button id="hero-next" type="button" class="w-10 h-10 rounded-full border border-white/15 bg-white/5 text-white/70 hover:bg-white/10 hover:text-white transition flex items-center justify-center" aria-label="Next">
                            <i data-lucide="chevron-right" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Apply card -->
            <div class="fade-up delay-200">
                <div class="rounded-2xl bg-white shadow-2xl shadow-purple-900/30 overflow-hidden border border-white/10">
                    <div class="px-6 pt-6 pb-4 text-center">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Apply Today For</p>
                        <h3 class="mt-1.5 text-xl font-extrabold text-slate-900">Quantum, Computing &amp; AI Programmes</h3>
                        <div class="mt-3 inline-block rounded-full bg-purple-50 px-4 py-1.5 text-[11px] font-bold text-purple-700">
                            Registration Last Date &middot; 31<sup>st</sup> Aug 2026
                        </div>
                    </div>

                    <form action="#" method="post" class="px-6 pb-6 space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" placeholder="Student Name *"  class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:outline-none focus:border-purple-500" required>
                            <input type="email" placeholder="Email Address *" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:outline-none focus:border-purple-500" required>
                        </div>
                        <div class="grid grid-cols-[80px_1fr] gap-3">
                            <select class="rounded-lg border border-slate-200 px-2 py-2.5 text-sm">
                                <option>+91</option><option>+1</option><option>+971</option>
                            </select>
                            <input type="tel" placeholder="Student Mobile *" class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:outline-none focus:border-purple-500" required>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <select class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm">
                                <option>Select City *</option><option>Coimbatore</option><option>Chennai</option><option>Bangalore</option>
                            </select>
                            <select class="rounded-lg border border-slate-200 px-3 py-2.5 text-sm">
                                <option>Select State *</option><option>Tamil Nadu</option><option>Kerala</option><option>Karnataka</option>
                            </select>
                        </div>
                        <select class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm">
                            <option>Programme of Interest *</option>
                            <option>B.Sc Artificial Intelligence &amp; Machine Learning</option>
                            <option>B.Sc Cyber Security</option>
                            <option>BCA (Artificial Intelligence)</option>
                            <option>M.Sc AI &amp; Data Science</option>
                        </select>

                        <label class="flex items-start gap-2 text-[11px] text-slate-500 leading-5">
                            <input type="checkbox" class="mt-1" required>
                            <span>By submitting this form, I authorize RGU to contact me via call/SMS/WhatsApp/Email.</span>
                        </label>

                        <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-purple-600 to-violet-600 py-3 text-sm font-bold text-white shadow-lg shadow-purple-500/30 hover:scale-[1.01] transition">
                            APPLY NOW
                        </button>
                        <p class="text-center text-[11px] text-slate-400">Already Registered? <a href="#" class="text-purple-700 font-semibold">Click to Login</a></p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- 2 · TOP RECRUITERS STRIP -->
<section class="bg-white py-10 border-b border-slate-100">
    <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-500 mb-6">
        Pursue Global 500 Companies in Recruiters List
    </p>
    <div class="overflow-hidden">
        <div class="marquee">
            @foreach (array_merge($recruiters,$recruiters) as $r)                <span class="text-2xl font-black text-slate-400/70 whitespace-nowrap">{!! $r !!}</span>
            @endforeach        </div>
    </div>
</section>


<!-- 3 · RANKING STRIP -->
<section class="bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-8 items-center">
        <div class="text-center">
            <p class="text-5xl font-black text-purple-700 leading-none">31<sup class="text-base">st</sup></p>
            <p class="mt-2 text-xs font-semibold uppercase tracking-widest text-slate-500">Among Top Tech<br>Universities &middot; NIRF</p>
        </div>
        <div class="text-center">
            <p class="text-5xl font-black text-violet-700 leading-none">A++</p>
            <p class="mt-2 text-xs font-semibold uppercase tracking-widest text-slate-500">NAAC Accredited<br>University</p>
        </div>
        <div class="text-center md:border-l md:border-slate-200 md:pl-8">
            <p class="text-base font-bold text-slate-800 leading-snug">Globally Recognised<br>AI &amp; Computing Programs</p>
            <p class="mt-1 text-xs text-slate-500">with NBA / ABET aligned curriculum</p>
        </div>
        <div class="text-center md:border-l md:border-slate-200 md:pl-8">
            <p class="text-base font-bold text-slate-800 leading-snug">Industry-Curated<br>Specialisations</p>
            <p class="mt-1 text-xs text-slate-500">in association with IBM, AWS, Microsoft</p>
        </div>
    </div>
</section>


<!-- 4 · ABOUT THE SCHOOL (intro) -->
<section id="overview" class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">

        <!-- Left: image grid -->
        <div class="grid grid-cols-2 gap-4">
            <img src="{{ storage_asset('assets/images/life/03.jpg') }}" alt="Rathinam Global University academic buildings seen from above" class="rounded-2xl h-56 w-full object-cover">
            <img src="{{ storage_asset('assets/images/life/04.jpg') }}" alt="Rathinam Research Hub building on campus" class="rounded-2xl h-56 w-full object-cover mt-8">
        </div>

        <!-- Right: copy -->
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-purple-700/20 bg-purple-700/10 px-[18px] py-[7px] mb-5">
                <span class="h-[6px] w-[6px] rounded-full bg-purple-700 animate-pulse"></span>
                <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-purple-700">School Overview</span>
            </div>

            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-5">
                Best Quantum, Computing &amp; AI School in Coimbatore, India
            </h2>
            <p class="text-slate-600 leading-7 mb-4">
                The School of Quantum Science, Computing &amp; AI at Rathinam Global University is a premier institution
                renowned for internationally benchmarked, industry-aligned education. Learner-centric academic models at
                RGU bridge the gap between theoretical foundations and industry-ready skills — preparing graduates to
                lead in the AI era.
            </p>
            <p class="text-slate-600 leading-7 mb-7">
                Our new-age engineering and computing programmes are co-designed and co-delivered by industry
                professionals to enable students to stay updated with the emerging shifts across the globe. Groundbreaking
                research in AI, Quantum Computing, Cyber Security, Sustainability and Generative AI is conducted at the
                Industry-Collaborated Centres of Excellence in collaboration with national and international institutions
                for an immersive learning experience.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="https://admissions.rathinamcollege.edu.in/" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 to-violet-600 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-purple-500/25">
                    Apply Now &#x2192;
                </a>
                <a href="#"
                   class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-7 py-3.5 text-sm font-bold text-slate-700 hover:border-purple-300 transition">
                    Download Brochure &#x2192;
                </a>
            </div>
        </div>
    </div>
</section>


<!-- 5 · RGU EDGE (numbered cards — CU style) -->
<section class="py-20 bg-[#0d0d1a] relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 left-1/3 w-[600px] h-[600px] rounded-full bg-purple-700/15 blur-[160px]"></div>
        <div class="absolute -bottom-20 right-0 w-[400px] h-[400px] rounded-full bg-sky-600/10 blur-[120px]"></div>
    </div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-white mb-14">RGU Quantum &amp; AI Edge</h2>

        @foreach ($edge as $i => $e)            @if ($i % 4 === 0)            @if ($i > 0)</div>@endif            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-px bg-white/5 rounded-3xl overflow-hidden mb-px">
            @endif
            <div class="relative bg-[#0d0d1a] p-7 hover:bg-white/[0.03] transition">
                <span class="edge-num absolute top-2 right-4 select-none">{!! str_pad($i+1,2,'0',STR_PAD_LEFT) !!}</span>
                <h3 class="relative text-base font-bold text-purple-300 leading-snug mb-3">{{ $e['t'] }}</h3>
                <p class="relative text-xs leading-6 text-white/55">{{ $e['d'] }}</p>
            </div>
        @endforeach        </div>
    </div>
</section>


<!-- 6 · PROGRAMMES OFFERED (with dept tabs) -->
<section id="programmes" class="py-20 bg-[#f8fafc]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between flex-wrap gap-4 mb-2">
            <div>
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900">Programmes Offered</h2>
                <p class="text-xs text-slate-500 mt-2">Chandigarh-style structured listing &middot; UG &middot; PG &middot; Lateral &middot; Doctorate</p>
                <p class="text-xs text-slate-400">Level of Study: Under-Graduate, Post-Graduate &amp; Doctorate Programs</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-600 to-violet-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                    <i data-lucide="cpu" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-slate-400">University Institute of</p>
                    <p class="text-base font-extrabold text-slate-900">Quantum &amp; Computing</p>
                </div>
            </div>
        </div>

        
        <!-- Tabs -->
        <div class="mt-6 flex flex-wrap gap-2 border-b border-slate-200 pb-4">
            <button type="button" data-dept="all"
                    class="dept-tab active px-5 py-2.5 rounded-full border border-slate-200 bg-white text-xs font-semibold text-slate-700 transition cursor-pointer">
                <i data-lucide="layout-grid" class="inline w-4 h-4 mr-1 align-text-bottom"></i>
                All Courses
            </button>
            @foreach ($groups as $key => $g)                <button type="button" data-dept="{!! $key !!}"
                        class="dept-tab px-5 py-2.5 rounded-full border border-slate-200 bg-white text-xs font-semibold text-slate-700 transition cursor-pointer">
                    <i data-lucide="{!! $g['icon'] !!}" class="inline w-4 h-4 mr-1 align-text-bottom"></i>
                    {!! $g['label'] !!}                </button>
            @endforeach        </div>


        <!-- All Courses (3-card grid) -->
        <div class="dept-panel mt-10" data-panel="all">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($groups as $group)
                    @include('schools.partials.quantum-group-card', ['number' => $loop->iteration, 'group' => $group])
                @endforeach
            </div>
        </div>

        <!-- Individual group panels -->
        @foreach ($groups as $key => $group)
            <div class="dept-panel mt-10 hidden" data-panel="{{ $key }}">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @include('schools.partials.quantum-group-card', ['number' => $loop->iteration, 'group' => $group])
                </div>
            </div>
        @endforeach
    </div>
</section>


<!-- 7 · CURRICULUM FOCUS (existing — refined) -->
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 rounded-full border border-sky-500/20 bg-sky-500/10 px-[18px] py-[7px] mb-5 w-max mx-auto">
            <span class="h-[6px] w-[6px] rounded-full bg-sky-500 animate-pulse"></span>
            <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-sky-600">Curriculum Focus</span>
        </div>
        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-4">What You'll Learn</h2>
        <p class="text-center text-slate-500 max-w-xl mx-auto mb-14 leading-7">A future-forward curriculum designed around the technologies shaping our world.</p>

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


<!-- 8 · TOP 2% SCIENTISTS / FACULTY -->
<section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-3 leading-tight">
            Proud Hub of Researchers<br>
            Ranked Among <span class="text-purple-700">The World's Top 2% Scientists</span>
        </h2>
        <p class="text-center text-xs font-semibold text-slate-500 mb-12">(Stanford Global List 2024)</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($faculty as $f)                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg transition">
                    <div class="bg-purple-100 h-24 flex items-end justify-center">
                        <div class="w-20 h-20 rounded-full bg-white border-4 border-white shadow-md flex items-center justify-center -mb-10">
                            <i data-lucide="user" class="w-9 h-9 text-purple-500"></i>
                        </div>
                    </div>
                    <div class="pt-12 px-5 pb-5 text-center">
                        <h4 class="font-bold text-slate-900 text-sm">{!! $f['name'] !!}</h4>
                        <p class="text-[11px] text-slate-500 mt-1 leading-5">{!! $f['role'] !!}</p>
                        <p class="mt-3 text-[11px] font-semibold text-purple-700">{!! $f['stat'] !!}</p>
                    </div>
                </div>
            @endforeach        </div>
    </div>
</section>


<!-- 9 · PROFESSORS OF PRACTICE (red/purple strip) -->
<section class="py-12 bg-white">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <p class="text-center text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight mb-6">
            Seasoned professionals provide<br>
            <span class="text-purple-700">real-world knowledge and applied learning</span>
        </p>
        <div class="rounded-2xl bg-gradient-to-r from-purple-600 to-violet-600 px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-4 shadow-lg shadow-purple-500/30">
            <p class="text-white font-bold text-sm md:text-base text-center md:text-left">
                Step into the Future with Guidance from Proven Practitioners!
            </p>
            <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-xs font-bold text-purple-700 hover:scale-105 transition">
                PROFESSORS OF PRACTICE &#x2192;
            </a>
        </div>
    </div>
</section>


<!-- 10 · GLOBAL LEARNING EXPERIENCE -->
<section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-12">A Degree with Global Learning Experience</h2>

                <div class="grid lg:grid-cols-[2fr_1fr] gap-6 items-stretch">

            <!-- Big image card (panels stacked, only active is visible) -->
            <div class="relative rounded-3xl overflow-hidden h-[380px] shadow-lg bg-[#0d0d1a]">
                @foreach ($intl as $i => $p)                <div class="intl-panel absolute inset-0 transition-opacity duration-500 {!! $i === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' !!}" data-panel="intl-{!! $i !!}">
                    <img src="{{ storage_asset($p['img']) }}" alt="{{ $p['t'] }} at Rathinam Global University" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <h3 class="text-2xl md:text-3xl font-extrabold mb-2 leading-tight">{!! $p['t'] !!}</h3>
                        <p class="text-sm text-white/85 max-w-md leading-6">{!! $p['d'] !!}</p>
                        <a href="#" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-purple-600 px-5 py-2.5 text-xs font-bold hover:bg-purple-700 transition">VIEW MORE &#x2192;</a>
                    </div>
                </div>
                @endforeach            </div>

            <!-- Sidebar tabs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2">
                @foreach ($intl as $i => $p)                    <button type="button" data-target="intl-{!! $i !!}"
                            class="intl-tab text-left rounded-xl px-4 py-4 flex items-center justify-between text-xs font-bold transition border
                                   {!! $i === 0 ? 'bg-gradient-to-r from-purple-600 to-violet-600 text-white border-transparent shadow-md shadow-purple-500/30' : 'bg-purple-50 text-slate-700 border-purple-100 hover:bg-purple-100' !!}">
                        <span class="leading-snug pr-2">{!! $p['t'] !!}</span>
                        <i data-lucide="{!! $i === 0 ? 'minus' : 'plus' !!}" class="intl-icon w-4 h-4 flex-shrink-0 {!! $i === 0 ? 'text-white' : 'text-purple-700' !!}"></i>
                    </button>
                @endforeach            </div>
        </div>

        <!-- Partner logos placeholder -->
        <div class="mt-12">
            <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-500 mb-5">Our Prestigious International Partners</p>
            <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-4 text-slate-400 font-bold text-lg">
                <span>Arizona State</span><span>CBU</span><span>Webster</span><span>La Trobe</span><span>UoW Australia</span><span>Aivancity</span>
            </div>
            <div class="text-center mt-6">
                <a href="https://admissions.rathinamcollege.edu.in/" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 to-violet-600 px-6 py-3 text-xs font-bold text-white shadow-lg shadow-purple-500/25">
                    APPLY NOW &#x2192;
                </a>
                <a href="#" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-6 py-3 text-xs font-bold text-slate-700 ml-3 hover:border-purple-300">VIEW MORE &#x2192;</a>
            </div>
        </div>
    </div>
</section>


<!-- 11 · VOICES FROM INDUSTRY (testimonials) -->
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-14">Voices from Industry Partners</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($voices as $v)                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6">
                    <i data-lucide="quote" class="w-6 h-6 text-purple-400 mb-4"></i>
                    <p class="text-sm leading-6 text-slate-700 mb-6">{!! $v['q'] !!}</p>
                    <div class="border-t border-slate-200 pt-4">
                        <p class="text-sm font-bold text-purple-700">{!! $v['n'] !!}</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">{!! $v['r'] !!}</p>
                    </div>
                </div>
            @endforeach        </div>

        <!-- Esteemed Industry Partners strip -->
        <div class="mt-14 rounded-2xl bg-slate-50 border border-slate-100 px-6 py-5 flex flex-wrap items-center justify-center gap-x-10 gap-y-3">
            <span class="text-xs font-bold uppercase tracking-widest text-slate-700">Esteemed<br>Industry Partners</span>
            <span class="text-slate-400 font-bold">IBM</span>
            <span class="text-slate-400 font-bold">TCS</span>
            <span class="text-slate-400 font-bold">Virtusa</span>
            <span class="text-slate-400 font-bold">Amazon</span>
            <span class="text-slate-400 font-bold">American Express</span>
        </div>
    </div>
</section>


<!-- 12 · WORLD CLASS LAB INFRASTRUCTURE -->
<section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-12">World-Class Research Infrastructure</h2>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach ($labs as $l)                <div class="relative rounded-2xl overflow-hidden h-64 group">
                    <img src="{{ storage_asset($l['img']) }}" alt="{{ $l['t'] }} facility at Rathinam Global University" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <p class="absolute bottom-5 left-5 right-5 text-white font-bold text-base">{!! $l['t'] !!}</p>
                </div>
            @endforeach        </div>

        <!-- Education that Empowers strip -->
        <div class="mt-10 rounded-2xl bg-gradient-to-r from-slate-900 to-purple-900 px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-white text-base font-bold italic">
                Education That Empowers <span class="text-purple-300">Opportunities That Transform</span>
            </p>
            <a href="https://admissions.rathinamcollege.edu.in/" target="_blank"
               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-500 to-violet-500 px-6 py-3 text-xs font-bold text-white shadow-lg shadow-purple-500/30">
                APPLY NOW &#x2192;
            </a>
        </div>
    </div>
</section>


<!-- 13 · TECHNOLOGY BUSINESS INCUBATOR -->
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-[1fr_2fr] gap-10 items-center">
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                Technology<br>Business<br>Incubator
            </h2>
            <p class="mt-5 text-sm text-slate-500 leading-6 max-w-xs">
                Fulfil your entrepreneurial aspirations with the Technology Business Incubator supported by the Government of India.
            </p>
            <p class="mt-8 text-5xl font-black text-purple-700 leading-none">200+</p>
            <p class="text-sm font-semibold text-slate-700 mt-1">Startups in diverse domains</p>
            <a href="#" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 to-violet-600 px-6 py-3 text-xs font-bold text-white shadow-lg shadow-purple-500/30">
                KNOW MORE &#x2192;
            </a>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            @foreach ($stories as $s)                <div class="rounded-2xl overflow-hidden bg-[#0d0d1a] text-white p-6 relative min-h-[280px] flex flex-col justify-end">
                    <i data-lucide="quote" class="absolute top-5 right-5 w-7 h-7 text-purple-500/40"></i>
                    <p class="text-sm leading-6 mb-5">{!! $s['q'] !!}</p>
                    <p class="text-base font-extrabold">{!! $s['n'] !!}</p>
                    <p class="text-[11px] text-white/50 mt-0.5">{!! $s['c'] !!}</p>
                </div>
            @endforeach        </div>
    </div>
</section>


<!-- 14 · CAREER PATHWAYS (existing — kept) -->
<section id="careers" class="py-20 bg-[#080810] relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4    w-[400px] h-[400px] rounded-full bg-purple-700/15 blur-[100px]"></div>
        <div class="absolute bottom-0 right-1/4 w-[300px] h-[300px] rounded-full bg-sky-600/10  blur-[80px]"></div>
    </div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 rounded-full border border-lime-400/20 bg-lime-400/10 px-[18px] py-[7px] mb-5 w-max mx-auto">
            <span class="h-[6px] w-[6px] rounded-full bg-lime-400 animate-pulse"></span>
            <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-lime-300">After Graduation</span>
        </div>
        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-white mb-4">Career Pathways</h2>
        <p class="text-center text-white/40 max-w-xl mx-auto mb-14 leading-7">
            Our graduates go on to build careers at the world's most innovative companies and research institutions.
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


<!-- 15 · INSPIRING STUDENT STORIES -->
<section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-[1fr_2fr] gap-10 items-center">
        <div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                Inspiring<br>Stories of<br>Our Students'<br>Journeys
            </h2>
            <a href="#" class="mt-6 inline-flex items-center gap-2 rounded-xl border border-purple-300 bg-white px-6 py-3 text-xs font-bold text-purple-700 hover:bg-purple-50 transition">
                VIEW ALL &#x2192;
            </a>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            @foreach ($students as $s)                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <i data-lucide="quote" class="w-6 h-6 text-purple-400 mb-3"></i>
                    <p class="text-sm leading-6 text-slate-700 mb-5">{!! $s['q'] !!}</p>
                    <p class="text-sm font-bold text-purple-700">{!! $s['n'] !!}</p>
                    <p class="text-[11px] text-slate-500 mt-0.5">{!! $s['r'] !!}</p>
                </div>
            @endforeach        </div>
    </div>
</section>


<section class="py-16 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid md:grid-cols-3 gap-5">
        <div class="rounded-2xl bg-gradient-to-br from-purple-600 to-violet-600 p-6 text-white shadow-xl shadow-purple-500/30">
            <h3 class="text-xl font-extrabold mb-2 leading-tight">Predict Your Future Career</h3>
            <p class="text-sm text-white/80 leading-5 mb-5">Apply to view report.</p>
            <a href="https://admissions.rathinamcollege.edu.in/" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-xs font-bold text-purple-700">APPLY NOW &#x2192;</a>
        </div>
        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-6">
            <h3 class="text-xl font-extrabold mb-3 leading-tight text-slate-900">Detailed Report on RGU Placements</h3>
            <ul class="text-xs text-slate-600 space-y-1 mb-5">
                <li>&#x2713; Highest Package Offered</li>
                <li>&#x2713; Students Placed</li>
                <li>&#x2713; Packages above 1.7 CR</li>
            </ul>
            <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 to-violet-600 px-5 py-2.5 text-xs font-bold text-white">VIEW MORE &#x2192;</a>
        </div>
        <div class="relative rounded-2xl overflow-hidden p-6 text-white x-14dt4f2h">
            <h3 class="text-xl font-extrabold mb-3 leading-tight">RGU Welcomes Students from more than 65 Countries</h3>
            <p class="text-xs text-white/80 leading-5 mb-5">With more than 150+ Bachelors, Masters and Doctoral programs to choose from, RGU is one of the highly preferred destinations for International Students.</p>
            <a href="#" class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-xs font-bold text-purple-800">EXPLORE MORE &#x2192;</a>
        </div>
    </div>
</section>


<!-- 17 · HOW TO APPLY (3 steps) -->
<section id="how-to-apply" class="py-20 bg-slate-50">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-5xl font-extrabold text-center text-slate-900 mb-14">How to Apply?</h2>

        
        <!-- Steps row -->
        <div class="relative mb-14 max-w-3xl mx-auto">
            <!-- track + progress -->
            <div class="absolute left-[12%] right-[12%] top-7 h-1 bg-slate-200 rounded-full"></div>
            <div id="apply-progress" class="absolute left-[12%] top-7 h-1 bg-gradient-to-r from-purple-600 to-violet-600 rounded-full transition-all duration-500 x-250nzu59"></div>

            <div class="relative grid grid-cols-3">
                @foreach ($applySteps as $idx => $st)                    <button type="button" data-step="{!! $idx !!}"
                            class="apply-step group flex flex-col items-center text-center px-2 cursor-pointer {!! $idx === 1 ? 'active' : '' !!}">
                        <span class="apply-dot relative z-10 w-14 h-14 rounded-full border-2 flex items-center justify-center text-base font-extrabold transition
                                     {!! $idx === 1 ? 'bg-gradient-to-br from-purple-600 to-violet-600 text-white border-transparent shadow-lg shadow-purple-500/40'
                                                    : 'bg-white text-slate-400 border-slate-300' !!}">
                            @if ($idx === 1)                                <i data-lucide="check" class="w-6 h-6"></i>
                            @else                                {!! $idx+1 !!}                            @endif                        </span>
                        <span class="mt-3 block text-[10px] font-semibold uppercase tracking-widest text-slate-400">Step {!! $idx+1 !!}</span>
                        <span class="apply-label mt-1 block text-sm font-bold {!! $idx === 1 ? 'text-slate-900' : 'text-slate-500 group-hover:text-slate-700' !!}">{!! $st['n'] !!}</span>
                    </button>
                @endforeach            </div>
        </div>

        <!-- Content panels -->
        @foreach ($applySteps as $idx => $st)        <div class="apply-content {!! $idx === 1 ? '' : 'hidden' !!} grid md:grid-cols-[1fr_1.4fr] gap-8 items-center" data-content="{!! $idx !!}">
            <img src="{{ storage_asset($st['img']) }}" alt="{!! $st['n'] !!}" class="rounded-2xl w-full h-64 md:h-72 object-cover shadow-md">
            <div>
                <h3 class="text-xl md:text-2xl font-extrabold text-slate-900 mb-3">{!! $st['h'] !!}</h3>
                <p class="text-sm text-slate-600 leading-7 mb-6">{!! $st['d'] !!}</p>
                <a href="https://admissions.rathinamcollege.edu.in/" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 to-violet-600 px-6 py-3 text-xs font-bold text-white shadow-lg shadow-purple-500/30 hover:scale-105 transition-transform">
                    APPLY TODAY &#x2192;
                </a>
            </div>
        </div>
        @endforeach    </div>
</section>


<!-- FOOTER (shared partial) -->
@endsection

@push('scripts')
<script>
    // ── Hero slider (auto-rotates every 6s) — run FIRST so nothing else can block it ──
    (function(){
        const slides = document.querySelectorAll('.hero-slide');
        const dots   = document.querySelectorAll('.hero-dot');
        const prev   = document.getElementById('hero-prev');
        const next   = document.getElementById('hero-next');
        if (slides.length < 2) { console.warn('[hero] need 2+ slides, found', slides.length); return; }

        const AUTO_MS = 6000;
        const total   = slides.length;
        let idx       = 0;
        let timer     = null;

        function render() {
            for (let k = 0; k < slides.length; k++) {
                slides[k].classList.toggle('is-active', k === idx);
            }
            for (let k = 0; k < dots.length; k++) {
                dots[k].className = (k === idx)
                    ? 'hero-dot rounded-full transition-all w-8 h-2 bg-purple-400'
                    : 'hero-dot rounded-full transition-all w-2 h-2 bg-white/25';
            }
        }
        function go(i){ idx = ((i % total) + total) % total; render(); }
        function start(){
            if (timer) clearInterval(timer);
            timer = setInterval(function(){ go(idx + 1); }, AUTO_MS);
        }

        if (prev) prev.addEventListener('click', function(){ go(idx - 1); start(); });
        if (next) next.addEventListener('click', function(){ go(idx + 1); start(); });
        dots.forEach(function(d){
            d.addEventListener('click', function(){
                go(parseInt(d.getAttribute('data-dot'), 10));
                start();
            });
        });

        render();
        start();
        console.log('[hero] auto-slider running · slides:', total);
    })();

    try { lucide.createIcons(); } catch(e) { console.warn('lucide init failed', e); }

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

    // ── Programmes Offered: department tabs ──
    document.querySelectorAll('.dept-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            const key = tab.getAttribute('data-dept');
            document.querySelectorAll('.dept-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            document.querySelectorAll('.dept-panel').forEach(p => {
                p.classList.toggle('hidden', p.getAttribute('data-panel') !== key);
            });
            lucide.createIcons();
        });
    });

    // ── Global Learning Experience: sidebar tabs swap left panel ──
    const intlTabs   = document.querySelectorAll('.intl-tab');
    const intlPanels = document.querySelectorAll('.intl-panel');
    intlTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.getAttribute('data-target');

            // reset tabs
            intlTabs.forEach(t => {
                t.classList.remove('bg-gradient-to-r','from-purple-600','to-violet-600','text-white','border-transparent','shadow-md','shadow-purple-500/30');
                t.classList.add('bg-purple-50','text-slate-700','border-purple-100','hover:bg-purple-100');
                const icon = t.querySelector('.intl-icon');
                if (icon) {
                    icon.setAttribute('data-lucide','plus');
                    icon.classList.remove('text-white');
                    icon.classList.add('text-purple-700');
                }
            });

            // activate this tab
            tab.classList.remove('bg-purple-50','text-slate-700','border-purple-100','hover:bg-purple-100');
            tab.classList.add('bg-gradient-to-r','from-purple-600','to-violet-600','text-white','border-transparent','shadow-md','shadow-purple-500/30');
            const ic = tab.querySelector('.intl-icon');
            if (ic) {
                ic.setAttribute('data-lucide','minus');
                ic.classList.remove('text-purple-700');
                ic.classList.add('text-white');
            }

            // swap panel
            intlPanels.forEach(p => {
                const active = p.getAttribute('data-panel') === target;
                p.classList.toggle('opacity-100', active);
                p.classList.toggle('opacity-0', !active);
                p.classList.toggle('pointer-events-none', !active);
            });

            lucide.createIcons();
        });
    });

    // ── How to Apply: step click swap ──
    const applySteps    = document.querySelectorAll('.apply-step');
    const applyContents = document.querySelectorAll('.apply-content');
    const applyProgress = document.getElementById('apply-progress');
    const progressWidths = ['calc(0% + 7px)', 'calc(38% + 0px)', 'calc(76% - 7px)'];

    applySteps.forEach(btn => {
        btn.addEventListener('click', () => {
            const idx = parseInt(btn.getAttribute('data-step'), 10);

            applySteps.forEach((s, i) => {
                const dot   = s.querySelector('.apply-dot');
                const label = s.querySelector('.apply-label');
                if (i === idx) {
                    s.classList.add('active');
                    dot.className = 'apply-dot relative z-10 w-14 h-14 rounded-full border-2 flex items-center justify-center text-base font-extrabold transition bg-gradient-to-br from-purple-600 to-violet-600 text-white border-transparent shadow-lg shadow-purple-500/40';
                    dot.innerHTML = '<i data-lucide="check" class="w-6 h-6"></i>';
                    label.className = 'apply-label mt-1 block text-sm font-bold text-slate-900';
                } else {
                    s.classList.remove('active');
                    dot.className = 'apply-dot relative z-10 w-14 h-14 rounded-full border-2 flex items-center justify-center text-base font-extrabold transition bg-white text-slate-400 border-slate-300';
                    dot.innerHTML = (i + 1);
                    label.className = 'apply-label mt-1 block text-sm font-bold text-slate-500 group-hover:text-slate-700';
                }
            });

            applyContents.forEach(c => {
                c.classList.toggle('hidden', parseInt(c.getAttribute('data-content'), 10) !== idx);
            });

            if (applyProgress) applyProgress.style.width = progressWidths[idx];

            lucide.createIcons();
        });
    });
</script>
@endpush
