{{-- Event detail page. Content: resources/data/events/{slug}.php (bilingual en/ta); logo and tag from resources/data/events.php. --}}
@extends('layouts.app')

@section('title')
{{ $event['en']['title'] }} | Events | RGU
@endsection
@section('description'){{ $event['en']['theme_title'] }}@endsection

@push('head')

    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ storage_asset('assets/css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800&family=Noto+Sans+Tamil:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <style>
        :root { --brand:#7e22ce; --brand-2:#6d28d9; }
        body { font-family: 'Outfit', 'Sora', sans-serif; background: #ffffff; color: #1e293b; }
        h1,h2,h3,.font-sora{font-family:'Sora',sans-serif;}
        [lang="ta"], .lang-ta { font-family: 'Noto Sans Tamil', 'Outfit', sans-serif; }

        .page-hero {
            background: radial-gradient(ellipse at top, #2a0e4a 0%, #150b1f 55%, #02050f 100%);
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .page-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.08), transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(126, 34, 206, 0.28), transparent 50%);
            pointer-events: none;
        }
        .hero-title { font-weight: 800; text-shadow: 0 0 22px rgba(255, 255, 255, 0.30); }
        .hero-chip{
            display:inline-flex; align-items:center; gap:.5rem;
            background: rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.18);
            padding:.5rem 1rem; border-radius:999px; font-size:.8rem; font-weight:600;
        }

        /* ── Language tabs ── */
        .lang-bar{ position: sticky; top: 59px; z-index: 800; background: rgba(255,255,255,.96); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .lang-tab{
            padding:.65rem 1.4rem; border-radius:999px; font-size:.85rem; font-weight:700;
            color:#475569; background:#f1f5f9; border:1.5px solid transparent; cursor:pointer; transition:.2s;
        }
        .lang-tab:hover{ background:#ede9fe; color:var(--brand); }
        .lang-tab.is-active{
            background: linear-gradient(135deg, var(--brand), var(--brand-2)); color:#fff;
            box-shadow: 0 8px 20px -8px rgba(126,34,206,.5);
        }
        .lang-panel{ display:none; }
        .lang-panel.is-active{ display:block; animation: fadein .35s ease both; }
        @keyframes fadein{ from{opacity:0; transform:translateY(8px);} to{opacity:1; transform:translateY(0);} }

        /* ── Content sections ── */
        .evt-section{
            background: #ffffff; border-radius: 18px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.07);
            border: 1px solid rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
        .evt-section-title{
            background: linear-gradient(90deg, #7e22ce 0%, #0284c7 100%);
            color: #fff; padding: 1.1rem 1.5rem; font-weight: 700; letter-spacing:.3px; font-size: 1.1rem;
        }
        .evt-section-body{ padding: 1.5rem 1.75rem; }
        .evt-section-body p{ color:#334155; line-height:1.85; margin-bottom:1rem; }
        .evt-section-body p:last-child{ margin-bottom:0; }

        ul.evt-points{ list-style:none; padding:0; margin:0; }
        ul.evt-points li{
            position:relative; padding:.6rem 0 .6rem 1.75rem; color:#334155; line-height:1.7;
            border-bottom:1px dashed #e2e8f0;
        }
        ul.evt-points li:last-child{ border-bottom:none; }
        ul.evt-points li::before{
            content:""; position:absolute; left:0; top:1.05rem; width:9px; height:9px; border-radius:50%;
            background: linear-gradient(135deg,#7e22ce,#0284c7); box-shadow:0 0 10px rgba(126,34,206,.4);
        }

        .evt-link-box{
            display:flex; flex-wrap:wrap; align-items:center; gap:.75rem;
            background:#f8f2fe; border-left:4px solid #7e22ce; border-radius:0 10px 10px 0;
            padding:1rem 1.25rem; margin: 1rem 0;
        }
        .evt-link-box a{ color:#7e22ce; font-weight:700; word-break:break-all; }
        .evt-deadline{
            display:inline-flex; align-items:center; gap:.4rem;
            background:#fef2f2; color:#b91c1c; font-weight:700; font-size:.82rem;
            padding:.4rem .85rem; border-radius:999px; border:1px solid #fecaca;
        }
        .evt-deadline.is-struck{
            text-decoration: line-through;
            background:#f1f5f9; color:#94a3b8; border-color:#cbd5e1;
        }
        .evt-deadline-ext{
            display:inline-flex; align-items:center; gap:.4rem;
            background:#f0fdf4; color:#15803d; font-weight:700; font-size:.82rem;
            padding:.4rem .85rem; border-radius:999px; border:1px solid #bbf7d0;
            box-shadow: 0 2px 8px rgba(22, 163, 74, 0.12);
        }

        .speaker-card{
            background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:1.1rem 1.25rem;
        }
        .speaker-card .topic{ font-weight:700; color:#0f172a; margin-bottom:.4rem; }
        .speaker-card .name{ color:#7e22ce; font-weight:700; font-size:.92rem; }
        .speaker-card .affil{ color:#64748b; font-size:.82rem; margin-top:.15rem; }

        .reg-box{ display:grid; gap:1rem; }
        .reg-meta{ display:flex; flex-wrap:wrap; gap:.75rem; }
        .reg-pill{ background:#eef2ff; color:#4338ca; font-weight:700; font-size:.82rem; padding:.5rem .9rem; border-radius:999px; }

        .contact-grid{ display:grid; gap:.85rem; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); }
        .contact-item{ display:flex; align-items:center; gap:.65rem; color:#334155; font-size:.92rem; }
        .contact-item i{ color:#7e22ce; flex-shrink:0; }

        .back-link{ display:inline-flex; align-items:center; gap:.4rem; color:#a78bfa; font-weight:600; font-size:.85rem; }
        .back-link:hover{ color:#fff; }
    </style>
@endpush

@section('content')

    <!-- ===== HERO ===== -->
    <section class="page-hero px-4 md:px-10 py-14 md:py-20 text-center">
        <div class="relative z-10 max-w-5xl mx-auto">
            <a href="{{ route('events.index') }}" class="back-link mb-6">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> All Events
            </a>

            <!-- Scheme Logo -->
            <div class="my-6 flex items-center justify-center">
                <div class="inline-flex items-center bg-white/95 backdrop-blur-md px-6 py-4 rounded-2xl shadow-2xl border border-white/30 hover:scale-105 transition-transform duration-300">
                    <img src="{{ $logoUrl }}" alt="{{ $listing['logo_alt'] }}" class="h-20 sm:h-24 md:h-28 w-auto object-contain" />
                </div>
            </div>

            <p class="uppercase tracking-[0.3em] text-purple-300 text-xs md:text-sm mb-3">National Conference</p>
            <h1 class="hero-title text-2xl md:text-4xl lg:text-5xl max-w-4xl mx-auto leading-tight">
                {{ $event['en']['title'] }}            </h1>
            <p class="mt-4 text-gray-200 text-sm md:text-lg max-w-3xl mx-auto font-semibold">
                {{ $event['en']['theme_title'] }}            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <span class="hero-chip"><i data-lucide="calendar" class="w-4 h-4"></i> 15 – 16 October 2026</span>
                <span class="hero-chip"><i data-lucide="map-pin" class="w-4 h-4"></i> Rathinam Auditorium, Coimbatore</span>
                <span class="hero-chip"><i data-lucide="languages" class="w-4 h-4"></i> Tamil &amp; English</span>
            </div>
        </div>
    </section>

    <!-- ===== LANGUAGE TABS ===== -->
    <div class="lang-bar">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-center gap-3">
            <button type="button" class="lang-tab is-active" data-lang="en">English</button>
            <button type="button" class="lang-tab" data-lang="ta">தமிழ்</button>
        </div>
    </div>

    <!-- ===== CONTENT (one panel per language, identical structure) ===== -->
    <main class="max-w-5xl mx-auto px-4 md:px-6 py-10 md:py-14">

        @foreach ($languages as $langKey => $lang)
        <div class="lang-panel {{ $loop->first ? 'is-active' : '' }} {!! $langKey === 'ta' ? 'lang-ta' : '' !!}" data-lang-panel="{!! $langKey !!}" lang="{!! $langKey !!}">

            <!-- Sub-title / call for papers banner -->
            <div class="evt-section mb-8">
                <div class="evt-section-body text-center py-8">
                    <p class="text-xs font-bold uppercase tracking-widest text-purple-600 mb-2">{{ $lang['subtitle'] }}</p>
                    <h2 class="font-sora text-xl md:text-2xl font-extrabold text-slate-900 mb-1">{{ $lang['call_heading'] }}</h2>
                    <p class="text-sm text-slate-500">{{ $lang['call_note'] }}</p>
                    <div class="mt-4 flex flex-col sm:flex-row items-center justify-center gap-3 text-sm text-slate-700">
                        <img src="{{ $logoUrl }}" alt="{{ $listing['logo_alt'] }}" class="h-10 w-auto object-contain" />
                        <span class="font-semibold max-w-xl text-center sm:text-left">{{ $lang['sponsor_line'] }}</span>
                    </div>
                    <div class="mt-3 flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-sm text-slate-500">
                        <span><i data-lucide="calendar" class="inline w-4 h-4 -mt-0.5"></i> {{ $lang['date_line'] }}</span>
                        <span><i data-lucide="map-pin" class="inline w-4 h-4 -mt-0.5"></i> {{ $lang['venue_line'] }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                @foreach ($lang['sections'] as $sec)
                    <section class="evt-section">
                        <div class="evt-section-title">{{ $sec['heading'] }}</div>
                        <div class="evt-section-body">

                            @if ($sec['type'] === 'paragraphs')                                @foreach ($sec['paragraphs'] as $p)
                                    <p>{{ $p }}</p>
                                @endforeach
                            @elseif ($sec['type'] === 'list')                                <ul class="evt-points">
                                    @foreach ($sec['items'] as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>

                            @elseif ($sec['type'] === 'submission')                                @foreach ($sec['paragraphs'] as $i => $p)
                                    <p>{{ $p }}</p>
                                    @if ($i === 0 && !empty($sec['link']))                                        <div class="evt-link-box">
                                            <i data-lucide="link" class="w-4 h-4 text-purple-600 flex-shrink-0"></i>
                                            <a href="{{ $sec['link']['url'] }}" target="_blank" rel="noopener">{{ $sec['link']['label'] }}</a>
                                        </div>
                                        @if (!empty($sec['deadline']))                                            <div class="flex flex-wrap items-center gap-2.5 mt-3">
                                                <span class="evt-deadline {!! !empty($sec['extended_deadline']) ? 'is-struck' : '' !!}">
                                                    <i data-lucide="clock" class="w-3.5 h-3.5"></i> {!! $langKey === 'ta' ? 'கடைசி நாள்' : 'Deadline' !!}: {{ $sec['deadline'] }}                                                </span>
                                                @if (!empty($sec['extended_deadline']))                                                    <span class="evt-deadline-ext">
                                                        <i data-lucide="calendar-check" class="w-3.5 h-3.5"></i> {!! $langKey === 'ta' ? 'நீட்டிக்கப்பட்ட கடைசி நாள்' : 'Extended deadline' !!} : {{ $sec['extended_deadline'] }}                                                    </span>
                                                @endif                                            </div>
                                        @endif                                    @endif                                @endforeach
                            @elseif ($sec['type'] === 'speakers')                                <div class="grid sm:grid-cols-2 gap-4">
                                    @foreach ($sec['items'] as $sp)
                                        <div class="speaker-card">
                                            <p class="topic">{{ $sp['topic'] }}</p>
                                            <p class="name">{{ $sp['name'] }}</p>
                                            <p class="affil">{{ $sp['affiliation'] }}</p>
                                        </div>
                                    @endforeach
                                </div>

                            @elseif ($sec['type'] === 'registration')                                <div class="reg-box">
                                    <div class="evt-link-box">
                                        <i data-lucide="external-link" class="w-4 h-4 text-purple-600 flex-shrink-0"></i>
                                        <a href="{{ $sec['link']['url'] }}" target="_blank" rel="noopener">{{ $sec['link']['label'] }}</a>
                                    </div>
                                    <div class="reg-meta">
                                        <span class="reg-pill">Application No: {{ $sec['application_no'] }}</span>
                                    </div>
                                    <ul class="evt-points">
                                        @foreach ($sec['notes'] as $note)
                                            <li>{{ $note }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                            @elseif ($sec['type'] === 'contact')                                <div class="contact-grid">
                                    <div class="contact-item"><i data-lucide="phone" class="w-4 h-4"></i> {{ $sec['phone'] }}</div>
                                    <div class="contact-item"><i data-lucide="globe" class="w-4 h-4"></i> <a href="{{ $sec['website'] }}" target="_blank" rel="noopener" class="hover:text-purple-700">{{ $sec['website'] }}</a></div>
                                    <div class="contact-item"><i data-lucide="mail" class="w-4 h-4"></i> <a href="mailto:{{ $sec['email'] }}" class="hover:text-purple-700">{{ $sec['email'] }}</a></div>
                                </div>
                            @endif
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
        @endforeach
    </main>
@endsection

@push('scripts')

    <script>
        window.addEventListener('DOMContentLoaded', function(){
            if (window.lucide) lucide.createIcons();

            document.querySelectorAll('.lang-tab').forEach(function(tab){
                tab.addEventListener('click', function(){
                    var lang = tab.getAttribute('data-lang');
                    document.querySelectorAll('.lang-tab').forEach(function(t){ t.classList.toggle('is-active', t === tab); });
                    document.querySelectorAll('.lang-panel').forEach(function(p){
                        p.classList.toggle('is-active', p.getAttribute('data-lang-panel') === lang);
                    });
                    var langBar = document.querySelector('.lang-bar');
                    if (langBar) {
                        var targetY = langBar.getBoundingClientRect().top + window.pageYOffset - 60;
                        window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
                    }
                });
            });
        });
    </script>
@endpush
