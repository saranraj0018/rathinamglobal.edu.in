{{-- Office of Global Affairs (/global-affairs). Copy: resources/data/global-affairs.php. --}}
@extends('layouts.app')

@section('title', 'Office of Global Affairs | Rathinam Global Deemed to be University')
@section('description', 'Office of Global Affairs at Rathinam Global University — driving international partnerships, student & faculty mobility, collaborative research, and transformative global opportunities.')
@section('body-attributes') class="bg-[#050508] text-slate-100 font-['Outfit',sans-serif] selection:bg-purple-500 selection:text-white"@endsection

@push('head')
    <meta name="theme-color" content="#050508">
    <meta property="og:title" content="Office of Global Affairs | Rathinam Global University">
    <meta property="og:description" content="Discover global partnerships, exchange programs, semester abroad, and international research initiatives at Rathinam Global University.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ storage_asset('assets/images/logo.webp') }}">
    <style>
        body { margin: 0 !important; padding: 0 !important; background: #050508; color: #f8fafc; font-family: 'Outfit', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
        @keyframes marqueeScroll { 0% { transform: translateX(0) } 100% { transform: translateX(-50%) } }
        .animate-marquee { display: flex; width: max-content; animation: marqueeScroll 35s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }
        @media (prefers-reduced-motion: reduce) { .animate-marquee { animation: none; } }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ storage_asset('assets/css/style.css') }}">
@endpush

@section('navigation')
    <a href="#about" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[10001] focus:bg-white focus:text-black focus:px-3 focus:py-2 focus:rounded">Skip to main content</a>
    @include('global-affairs.partials.top-bar')
    @include('partials.nav', ['navMode' => 'solid'])
@endsection

@section('content')
    @include('global-affairs.partials.hero')
    @include('global-affairs.partials.vision-mission')
    @include('global-affairs.partials.objectives')
    @include('global-affairs.partials.opportunities')
    @include('global-affairs.partials.partners')
    @include('global-affairs.partials.team')
    @include('global-affairs.partials.gallery')
    @include('global-affairs.partials.call-to-action')
    @include('global-affairs.partials.contact')
@endsection
