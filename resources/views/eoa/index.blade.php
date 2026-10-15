@extends('layouts.app')

@section('title', 'EOA | RGU')

@push('head')

    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ storage_asset('assets/css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', 'Sora', sans-serif;
            background: #ffffff;
            color: #1e293b;
        }

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
                radial-gradient(circle at 80% 70%, rgba(79, 124, 255, 0.15), transparent 50%);
            pointer-events: none;
        }

        .hero-title {
            font-weight: 700;
            text-shadow: 0 0 22px rgba(255, 255, 255, 0.35);
        }

        .nav-bar {
            background: rgba(5, 11, 31, 0.95);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        /* Year pill buttons */
        .year-pill {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 2px solid #6366f1;
            border-radius: 9999px;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.05rem;
            color: #4338ca;
            letter-spacing: .5px;
            box-shadow: 0 0 24px rgba(99, 102, 241, 0.28),
                        0 4px 14px rgba(99, 102, 241, 0.12);
            transition: all .25s ease;
            text-decoration: none;
            position: relative;
        }

        .year-pill:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
            color: #ffffff;
            box-shadow: 0 0 36px rgba(99, 102, 241, 0.55),
                        0 8px 24px rgba(99, 102, 241, 0.3);
        }

        .year-pill.disabled {
            pointer-events: none;
            opacity: .45;
            box-shadow: 0 0 12px rgba(99, 102, 241, 0.1);
        }
    </style>
@endpush

@section('content')

    <!-- ===== HERO ===== -->
    <section class="page-hero px-4 md:px-10 py-14 md:py-20 text-center">
        <div class="relative z-10 max-w-5xl mx-auto">
            <p class="uppercase tracking-[0.3em] text-blue-300 text-xs md:text-sm mb-3">Rathinam Global (Deemed to be University)</p>
            <h1 class="hero-title text-3xl md:text-5xl lg:text-6xl">Extension of Approval (EOA)</h1>
            <p class="mt-4 md:mt-6 text-gray-300 text-sm md:text-base max-w-3xl mx-auto">
                Click on any year below to view the official AICTE Extension of Approval document.
            </p>
        </div>
    </section>

    <!-- ===== YEARS GRID ===== -->
    <main class="max-w-6xl mx-auto px-4 md:px-8 py-12 md:py-16">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5 md:gap-8">
            @foreach ($approvals as $year => $documentUrl)
                @if ($documentUrl)
                    <a class="year-pill" href="{{ $documentUrl }}" target="_blank" rel="noopener">{{ $year }}</a>
                @else
                    <span class="year-pill disabled" title="Not available">{{ $year }}</span>
                @endif
            @endforeach
        </div>
    </main>
@endsection
