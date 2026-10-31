<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Assistant admin') | Rathinam</title>
    <link rel="stylesheet" href="{{ versioned_asset('css/assistant-admin.css') }}">
</head>
<body>
@auth
    <header class="top">
        <strong>Rathinam Assistant</strong>
        <a href="{{ route('admin.dashboard') }}">Analytics</a>
        <a href="{{ route('admin.faqs.index') }}">FAQs</a>
        <a href="{{ route('admin.categories.index') }}">Categories</a>
        <a href="{{ route('admin.documents.index') }}">Knowledge</a>
        <a href="{{ route('admin.unanswered') }}">Unanswered</a>
        <a href="{{ route('admin.settings.edit') }}">Settings</a>
        <form method="post" action="{{ route('admin.logout') }}">@csrf <button class="alt">Sign out</button></form>
    </header>
@endauth
<main>
    @if (session('status'))<div class="flash" role="status">{{ session('status') }}</div>@endif
    @yield('content')
</main>
</body>
</html>
