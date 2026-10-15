@extends('layouts.base')

@section('title', 'Rathinam Global University — The RGU Way')
@section('description', 'Rathinam Global University — Where Students Transform Into Leaders. The RGU Way: Global Readiness + Career Readiness + Future Readiness.')

@push('head')
    <meta name="theme-color" content="#080810" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sora:   ['Sora', 'system-ui', 'sans-serif'],
                        dm:     ['DM Sans', 'system-ui', 'sans-serif'],
                        outfit: ['Sora', 'system-ui', 'sans-serif'],
                        inter:  ['DM Sans', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ storage_asset('rgu-way/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ storage_asset('assets/css/extracted.css') }}">
@endpush

@section('body')
    @include('rgu-way.partials.navbar')
    @include('rgu-way.partials.hero')
    @include('rgu-way.partials.why-more-than-degree')
    @include('rgu-way.partials.what-is-rgu-way')
    @include('rgu-way.partials.core-brand-promise')
    @include('rgu-way.partials.skill-passport-banner')
    @include('rgu-way.partials.projected-outcomes')
    @include('rgu-way.partials.life-at-rgu')
    @include('rgu-way.partials.happening-at-rgu')
    @include('rgu-way.partials.footer')

<!-- Main JS -->
<script src="{{ storage_asset('rgu-way/assets/js/main.js') }}"></script>
@endsection
