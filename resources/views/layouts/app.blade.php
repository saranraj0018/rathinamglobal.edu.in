{{--
    Inner pages of the main site: navigation bar, page content and the shared
    footer. Pages push their own stylesheets to the "head" stack; extracted.css
    is appended last so its utility classes keep winning the cascade, as they
    did on the legacy pages.

    The main nav (solid variant) is used unless the page defines its own
    @section('navigation') — school and programme pages have their own bars.
    @section('without-navigation', true) renders no navigation at all.
--}}
@extends('layouts.base')

@push('head')
    <link rel="icon" type="image/png" href="{{ storage_asset('assets/images/favicon.png') }}">
@endpush

@push('head')
    <link rel="stylesheet" href="{{ versioned_asset('css/extracted.css') }}">
@endpush

@section('body')
    @hasSection('navigation')
        @yield('navigation')
    @else
        @sectionMissing('without-navigation')
            @include('partials.nav', ['navMode' => 'solid'])
        @endif
    @endif

    @yield('content')

    @include('partials.footer')
@endsection
