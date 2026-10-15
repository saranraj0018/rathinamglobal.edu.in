{{--
    Research portal (/research, /research/directorate, /research/registrar).
    Pages set @section('page-title') and @section('page-description'); the
    controller passes $active to highlight the current nav item.
--}}
@extends('layouts.base')

@section('title')@yield('page-title', 'Research') | Research · Rathinam Global University @endsection
@section('description')@yield('page-description', 'Research, innovation and doctoral programmes at Rathinam Global University.')@endsection
@section('body-attributes') class="antialiased text-slate-800 bg-[#f8fafc]"@endsection

@push('head')
    <link rel="icon" type="image/png" href="{{ storage_asset('assets/images/favicon.png') }}">
    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ storage_asset('research/assets/research.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <noscript><style>.r-reveal{opacity:1!important;transform:none!important}.r-bar{height:auto!important}</style></noscript>
    <link rel="stylesheet" href="{{ storage_asset('assets/css/extracted.css') }}">
@endpush

@section('body')
    @include('research.partials.nav')

    @yield('content')

    @include('research.partials.footer')
@endsection
