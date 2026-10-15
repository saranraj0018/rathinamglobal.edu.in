{{-- Careers (/careers). Openings are rendered by the Zimyo recruitment widget. --}}
@extends('layouts.app')

@section('title', 'Careers | Rathinam Global University')
@section('description', 'Careers at Rathinam Global University — discover current opportunities and join a vibrant academic community.')
@section('body-attributes') class="careers-shell"@endsection

@push('head')
    <meta name="theme-color" content="#050508">
    <meta property="og:title" content="Careers | Rathinam Global University">
    <meta property="og:description" content="Explore current openings and career opportunities at Rathinam Global University.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ storage_asset('assets/images/logo.webp') }}">
    <style>
        body { margin: 0 !important; padding: 0 !important; background: #050508; color: #e2e8f0; font-family: 'Outfit', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
        .careers-shell { background: radial-gradient(circle at top, rgba(124,58,237,0.12), transparent 40%), #050508; }
        .careers-hero { background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(148, 163, 184, 0.2); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ storage_asset('assets/css/style.css') }}">
@endpush

@section('content')
    <main class="mx-auto max-w-6xl px-4 py-12 md:py-20">
        <div class="careers-hero mb-8 rounded-[28px] px-4 py-10 text-center md:px-10 md:py-14">
            <span class="inline-flex items-center rounded-full border border-purple-300/40 bg-purple-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-purple-200">
                Join our team
            </span>
            <h1 class="mt-6 text-4xl font-black tracking-tight text-white md:text-6xl">Careers</h1>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-slate-300 md:text-lg">
                Explore meaningful opportunities to grow with Rathinam Global University and help shape the future of education.
            </p>
        </div>

        <div class="overflow-hidden rounded-[28px] border border-slate-700 bg-slate-900/85 shadow-[0_20px_60px_rgba(15,23,42,0.35)]">
            <div id="job-listing"></div>
            <script>var USERID = 7381;</script>
            <script src="https://zimyo.work/recruit/jobwidget.js"></script>
        </div>
    </main>
@endsection
