<!DOCTYPE html>
<html lang="@yield('lang', 'en')"@yield('html-attributes')>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="@yield('viewport', 'width=device-width, initial-scale=1.0')">
@hasSection('description')
    <meta name="description" content="@yield('description')">
@endif
    <title>@yield('title', 'Rathinam Global University')</title>
    <link rel="canonical" href="@yield('canonical', $canonicalUrl)">
@stack('head')
</head>
<body @yield('body-attributes')>
@yield('body')
@if (config('assistant.enabled'))
    @sectionMissing('without-voice-assistant')
        @include('components.voice-assistant')
    @endif
@endif
@stack('scripts')
</body>
</html>
