{{--
    FAQ page. Content: resources/data/faqs.php (answers may contain HTML entities).
    Category pills filter the list; #<category-id> in the URL opens that category.
--}}
@extends('layouts.app')

@section('title', 'Frequently Asked Questions | Rathinam Global University')
@section('description', 'Answers to the questions applicants and parents ask most about Rathinam Global University — programmes, admissions, fees, scholarships, placements, hostel and campus life.')

@push('head')
    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ versioned_asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <script type="application/ld+json">@json($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    <style>
        body { font-family: 'Outfit', 'Sora', sans-serif; background: #080810; color: #e2e8f0; }

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
                radial-gradient(circle at 80% 70%, rgba(126, 34, 206, 0.18), transparent 50%);
            pointer-events: none;
        }
        .hero-title { font-family: 'Sora', sans-serif; font-weight: 800; text-shadow: 0 0 22px rgba(255, 255, 255, 0.35); }

        .faq-filters {
            position: sticky; top: 56px; z-index: 30;
            background: rgba(8, 8, 16, 0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
        }
        .faq-filters__list { display: flex; gap: 10px; overflow-x: auto; scrollbar-width: none; padding: 14px 0; }
        .faq-filters__list::-webkit-scrollbar { display: none; }
        .faq-pill {
            flex-shrink: 0;
            font-size: 13px; font-weight: 600; white-space: nowrap;
            color: rgba(226, 232, 240, 0.75);
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 9999px; padding: 8px 16px;
            cursor: pointer; transition: all .2s ease;
        }
        .faq-pill:hover { color: #fff; border-color: rgba(168, 85, 247, 0.45); }
        .faq-pill.is-active {
            color: #fff;
            background: linear-gradient(90deg, #7e22ce, #0284c7);
            border-color: transparent;
        }

        .faq-cat { scroll-margin-top: 140px; }
        .faq-cat + .faq-cat { margin-top: 56px; }
        .faq-cat__title { font-family: 'Sora', sans-serif; font-weight: 800; font-size: clamp(1.35rem, 3vw, 1.9rem); color: #f8fafc; }
        .faq-cat__blurb { margin-top: 6px; font-size: 15px; color: rgba(226, 232, 240, 0.6); }
        .faq-cat__list { margin-top: 22px; display: flex; flex-direction: column; gap: 12px; }

        .faq-item {
            background: rgba(15, 23, 42, 0.55);
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 16px;
            overflow: hidden;
            transition: border-color .25s ease, background .25s ease;
        }
        .faq-item:hover { border-color: rgba(168, 85, 247, 0.34); }
        .faq-item[open] { background: rgba(15, 23, 42, 0.85); border-color: rgba(168, 85, 247, 0.5); }
        .faq-item__q {
            display: flex; align-items: center; gap: 14px;
            padding: 18px 20px; cursor: pointer; list-style: none;
            font-size: 15px; font-weight: 600; color: #f1f5f9;
        }
        .faq-item__q::-webkit-details-marker { display: none; }
        .faq-item__q:focus-visible { outline: 2px solid rgba(168, 85, 247, 0.75); outline-offset: -2px; }
        .faq-item__qtext { flex: 1 1 auto; line-height: 1.5; }
        .faq-item__chev { flex-shrink: 0; color: rgba(226, 232, 240, 0.55); transition: transform .3s ease; }
        .faq-item[open] .faq-item__chev { transform: rotate(180deg); color: #d8b4fe; }
        .faq-item__a { padding: 0 20px 20px; font-size: 14.5px; line-height: 1.75; color: rgba(226, 232, 240, 0.7); }

        @media (max-width: 640px) {
            .faq-item__q { padding: 16px; }
            .faq-item__a { padding: 0 16px 16px; }
        }
        @media (prefers-reduced-motion: reduce) {
            .faq-item, .faq-item__chev, .faq-pill { transition: none; }
        }
    </style>
@endpush

@section('content')
    <!-- ===== HERO ===== -->
    <section class="page-hero px-4 md:px-10 py-14 md:py-20 text-center">
        <div class="relative z-10 max-w-5xl mx-auto">
            <p class="uppercase tracking-[0.3em] text-purple-300 text-xs md:text-sm mb-3">Rathinam Global (Deemed to be University)</p>
            <h1 class="hero-title text-3xl md:text-5xl lg:text-6xl">Frequently Asked Questions</h1>
            <p class="mt-4 md:mt-6 text-gray-300 text-sm md:text-base max-w-3xl mx-auto">
                The things applicants and parents ask us most, before they apply.
            </p>
        </div>
    </section>

    <!-- ===== CATEGORY FILTER ===== -->
    <nav class="faq-filters" aria-label="FAQ categories">
        <div class="max-w-5xl mx-auto px-4 md:px-6">
            <div class="faq-filters__list" role="tablist">
                <button type="button" class="faq-pill is-active" data-faq-filter="all">All</button>
                @foreach ($categories as $category)
                    <button type="button" class="faq-pill" data-faq-filter="{{ $category['id'] }}">{!! $category['label'] !!}</button>
                @endforeach
            </div>
        </div>
    </nav>

    <!-- ===== QUESTIONS ===== -->
    <main class="max-w-5xl mx-auto px-4 md:px-6 py-12 md:py-16">
        @foreach ($categories as $category)
            <section class="faq-cat" id="{{ $category['id'] }}" data-faq-category="{{ $category['id'] }}" aria-labelledby="faq-{{ $category['id'] }}-title">
                <h2 class="faq-cat__title" id="faq-{{ $category['id'] }}-title">{!! $category['title'] !!}</h2>
                <p class="faq-cat__blurb">{!! $category['blurb'] !!}</p>

                <div class="faq-cat__list">
                    @foreach ($category['items'] as $item)
                        <details class="faq-item">
                            <summary class="faq-item__q">
                                <span class="faq-item__qtext">{!! $item['q'] !!}</span>
                                <svg class="faq-item__chev" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </summary>
                            <div class="faq-item__a">{!! $item['a'] !!}</div>
                        </details>
                    @endforeach
                </div>
            </section>
        @endforeach
    </main>
@endsection

@push('scripts')
    <script>
        (function () {
            var pills = document.querySelectorAll('[data-faq-filter]');
            var sections = document.querySelectorAll('[data-faq-category]');

            function show(id) {
                var known = Array.prototype.some.call(sections, function (s) { return s.dataset.faqCategory === id; });
                if (!known) { id = 'all'; }
                pills.forEach(function (p) { p.classList.toggle('is-active', p.dataset.faqFilter === id); });
                sections.forEach(function (s) { s.hidden = id !== 'all' && s.dataset.faqCategory !== id; });
            }

            pills.forEach(function (pill) {
                pill.addEventListener('click', function () {
                    var id = pill.dataset.faqFilter;
                    show(id);
                    history.replaceState(null, '', id === 'all' ? location.pathname : '#' + id);
                });
            });

            var initial = location.hash.replace('#', '');
            if (initial) {
                show(initial);
                var target = document.getElementById(initial);
                if (target) { target.scrollIntoView(); }
            }
        })();
    </script>
@endpush
