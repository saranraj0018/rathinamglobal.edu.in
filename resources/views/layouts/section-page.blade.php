{{--
    Section pages (DBT Star College Scheme, ...): hero with breadcrumbs,
    title, lede and optional KPI tiles, then the page body.

    Expects: $title, $description, $breadcrumbs [[label, url|null], ...],
    optional $kpis [[value, label], ...] and $accent (plum|azure|lime|amber).
--}}
@extends('layouts.app')

@section('title', $title.' | Rathinam Global University')
@section('description', $description)
@section('body-attributes') class="rgu-page rgu-accent-{{ $accent ?? 'plum' }}"@endsection

@push('head')
    <meta name="theme-color" content="#050508">
    <meta property="og:title" content="{{ $title }} | Rathinam Global University">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ storage_asset('assets/images/logo.webp') }}">
    <style>body{margin:0!important;padding:0!important;background:#050508}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ storage_asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ storage_asset('assets/css/pages.css') }}">
@endpush

@section('content')
    <header class="rgu-pagehero">
        <div class="rgu-pagehero__glow" aria-hidden="true"></div>
        <div class="rgu-sec__wrap">
            <nav class="rgu-crumb" aria-label="Breadcrumb">
                @foreach ($breadcrumbs as [$label, $url])
                    @if ($url)
                        <a href="{{ $url }}">{{ $label }}</a><i aria-hidden="true">/</i>
                    @else
                        <span aria-current="page">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
            <h1 class="rgu-pagehero__title">{{ $title }}</h1>
            <p class="rgu-pagehero__lede">{{ $description }}</p>

            @if (! empty($kpis))
                <div class="rgu-kpis">
                    @foreach ($kpis as $kpi)
                        <div><b>{{ $kpi['value'] }}</b><small>{{ $kpi['label'] }}</small></div>
                    @endforeach
                </div>
            @endif
        </div>
    </header>

    <main id="main">
        @yield('main')
    </main>
@endsection
