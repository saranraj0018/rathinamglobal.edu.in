@extends('layouts.app')

@section('title', 'Statutory Committees | RGU')

@push('head')

    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ versioned_asset('css/style.css') }}">
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

        .coming-soon {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.07);
            border: 1px solid rgba(15, 23, 42, 0.06);
            padding: 3rem 2rem;
            text-align: center;
        }

        .coming-soon h2 {
            background: linear-gradient(135deg, #0b1538 0%, #1d4ed8 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: .75rem;
        }

        .coming-soon p {
            color: #475569;
            line-height: 1.7;
        }
    </style>
@endpush

@section('content')

    <!-- ===== HERO ===== -->
    <section class="page-hero px-4 md:px-10 py-14 md:py-20 text-center">
        <div class="relative z-10 max-w-5xl mx-auto">
            <p class="uppercase tracking-[0.3em] text-blue-300 text-xs md:text-sm mb-3">Rathinam Global (Deemed to be University)</p>
            <h1 class="hero-title text-3xl md:text-5xl lg:text-6xl">Statutory Committees</h1>
            <p class="mt-4 md:mt-6 text-gray-300 text-sm md:text-base max-w-3xl mx-auto">
                Statutory bodies and committees constituted under the regulations of the University.
            </p>
        </div>
    </section>

    <!-- ===== CONTENT ===== -->
    <main class="max-w-4xl mx-auto px-4 md:px-6 py-12 md:py-20">
        <div class="coming-soon">
            <h2>Content Coming Soon</h2>
            <p>Details of the University&rsquo;s Statutory Committees will be published here shortly.</p>
        </div>
    </main>
@endsection
