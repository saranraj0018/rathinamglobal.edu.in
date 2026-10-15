@extends('layouts.app')

@section('title', 'Events | RGU')
@section('description', 'Conferences, seminars and workshops hosted by Rathinam Global University (RGU), Coimbatore.')

@push('head')
    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ versioned_asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <style>
        body { font-family: 'Outfit', 'Sora', sans-serif; background: #ffffff; color: #1e293b; }
        h1,h2,h3,.font-sora{font-family:'Sora',sans-serif;}

        .page-hero {
            background: radial-gradient(ellipse at top, #0e1d4a 0%, #050b1f 60%, #02050f 100%);
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
                radial-gradient(circle at 80% 70%, rgba(126, 34, 206, 0.18), transparent 50%);
            pointer-events: none;
        }
        .hero-title { font-weight: 700; text-shadow: 0 0 22px rgba(255, 255, 255, 0.35); }

        .evt-card{
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 1.75rem;
            box-shadow: 3px 5px 13px #80808030;
            transition: all .4s cubic-bezier(.34,1.56,.64,1);
            position: relative;
            overflow: hidden;
            display: flex; flex-direction: column;
        }
        .evt-card:hover{
            transform: translateY(-8px) scale(1.015);
            background: rgba(255,255,255,0.85);
            box-shadow: 0 20px 40px rgba(0,0,0,0.10);
        }
        .evt-icon{
            width: 52px; height: 52px; border-radius: 14px;
            display:flex; align-items:center; justify-content:center;
            color:#fff; flex-shrink:0;
        }
        .evt-tag{
            font-size:.68rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase;
            padding:.3rem .7rem; border-radius:999px;
            background: rgba(0,0,0,0.05); color:#475569;
        }
        .evt-card .evt-date{
            font-size:.78rem; font-weight:600; color:#64748b;
            display:flex; align-items:center; gap:.4rem;
        }
        .evt-card .evt-title{ font-size:1.2rem; font-weight:800; line-height:1.3; color:#0f172a; margin:1rem 0 .6rem; }
        .evt-card .evt-desc{ font-size:.85rem; line-height:1.6; color:#475569; flex-grow:1; }
        .evt-card .evt-btn{
            margin-top:1.25rem; display:inline-flex; align-items:center; gap:.4rem;
            font-size:.82rem; font-weight:700; color:#fff;
            padding:.65rem 1.1rem; border-radius:12px;
            box-shadow: 0 8px 20px -8px rgba(0,0,0,.35);
            transition: transform .2s ease;
        }
        .evt-card .evt-btn:hover{ transform: translateX(3px); }

        .grad-purple{ background: var(--grad-purple); }
        .grad-blue{ background: var(--grad-blue); }
        .grad-green{ background: var(--grad-green); }
        .grad-orange{ background: var(--grad-orange); }
        .grad-pink{ background: var(--grad-pink); }
        .grad-cyan{ background: var(--grad-cyan); }
        .grad-indigo{ background: var(--grad-indigo); }

        .evt-empty{
            border: 2px dashed #e2e8f0; border-radius: 24px;
            padding: 3.5rem 1.5rem; text-align:center; color:#94a3b8;
        }
    </style>
@endpush

@section('content')
    <!-- ===== HERO ===== -->
    <section class="page-hero px-4 md:px-10 py-14 md:py-20 text-center">
        <div class="relative z-10 max-w-5xl mx-auto">
            <p class="uppercase tracking-[0.3em] text-purple-300 text-xs md:text-sm mb-3">Rathinam Global (Deemed to be University)</p>
            <h1 class="hero-title text-3xl md:text-5xl lg:text-6xl">Events</h1>
            <p class="mt-4 md:mt-6 text-gray-300 text-sm md:text-base max-w-3xl mx-auto">
                Conferences, seminars, and workshops hosted across RGU's schools and departments.
            </p>
        </div>
    </section>

    <!-- ===== EVENT CARDS ===== -->
    <main class="max-w-7xl mx-auto px-4 md:px-6 py-12 md:py-16">
        @if ($events === [])
            <div class="evt-empty">
                <p>No events are listed right now. Please check back soon.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach ($events as $event)
                    <div class="evt-card">
                        <div class="flex items-start justify-between gap-3">
                            @if (! empty($event['logo']))
                                <div class="evt-icon grad-{{ $event['gradient'] }} overflow-hidden p-1.5 flex items-center justify-center">
                                    <img src="{{ storage_asset('events/'.$event['logo']) }}" alt="{{ $event['title'] }}" class="w-full h-full object-contain bg-white rounded-lg p-1" />
                                </div>
                            @else
                                <div class="evt-icon grad-{{ $event['gradient'] }}">
                                    <i data-lucide="{{ $event['icon'] }}" class="w-6 h-6"></i>
                                </div>
                            @endif
                            <span class="evt-tag">{{ $event['tag'] }}</span>
                        </div>

                        <h3 class="evt-title">{{ $event['title'] }}</h3>
                        <p class="evt-desc">{{ $event['desc'] }}</p>

                        <div class="evt-date mt-4">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            {{ $event['date'] }}
                        </div>
                        <div class="evt-date mt-1">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                            {{ $event['venue'] }}
                        </div>

                        <a href="{{ route('events.show', $event['slug']) }}" class="evt-btn grad-{{ $event['gradient'] }} w-fit">
                            Read More
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection

@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', function(){
            if (window.lucide) lucide.createIcons();
        });
    </script>
@endpush