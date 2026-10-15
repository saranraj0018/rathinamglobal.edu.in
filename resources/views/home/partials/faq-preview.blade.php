{{-- Homepage FAQ preview: four high-intent questions from resources/data/faqs.php, linking to the full FAQ page. --}}
<section class="rgu-faq" id="faq" aria-labelledby="rgu-faq-heading">
    <div class="rgu-faq__inner">

        <header class="rgu-faq__head">
            <span class="rgu-faq__eyebrow">Questions? Answered</span>
            <h2 class="rgu-faq__title" id="rgu-faq-heading">
                Frequently Asked <span class="rgu-faq__grad">Questions</span>
            </h2>
            <p class="rgu-faq__sub">
                The things applicants and parents ask us most, before they apply.
            </p>
        </header>

        <div class="rgu-faq__list">
            @foreach ($faqPreview as $i => $item)
                <details class="rgu-faq__item"@if ($i === 0) open @endif>
                    <summary class="rgu-faq__q">
                        <span class="rgu-faq__tag">{!! $item['label'] !!}</span>
                        <span class="rgu-faq__qtext">{!! $item['q'] !!}</span>
                        <svg class="rgu-faq__chev" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </summary>
                    <div class="rgu-faq__a">{!! $item['a'] !!}</div>
                </details>
            @endforeach        </div>

        <div class="rgu-faq__cta">
            <a class="rgu-faq__btn" href="{{ route('faq') }}">
                Read More FAQs
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>

    <style>
        .rgu-faq { background: linear-gradient(180deg, #080810, #0c0c18); padding: 80px 0; }
        .rgu-faq__inner { max-width: 1000px; margin: 0 auto; padding: 0 16px; }

        .rgu-faq__head { text-align: center; margin-bottom: 40px; }
        .rgu-faq__eyebrow {
            display: inline-block;
            font-family: 'Outfit', sans-serif;
            font-size: 11px; font-weight: 600;
            letter-spacing: 0.25em; text-transform: uppercase;
            color: #d8b4fe;
            background: rgba(168, 85, 247, 0.12);
            border: 1px solid rgba(216, 180, 254, 0.28);
            border-radius: 9999px;
            padding: 9px 18px; margin-bottom: 20px;
        }
        .rgu-faq__title {
            font-family: 'Sora', sans-serif; font-weight: 900;
            font-size: clamp(1.8rem, 4.5vw, 3.2rem);
            letter-spacing: -0.03em; line-height: 1.15;
            color: #f8fafc; margin: 0 0 14px;
        }
        .rgu-faq__grad {
            background: linear-gradient(90deg, #a855f7, #38bdf8);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent; color: transparent;
        }
        .rgu-faq__sub {
            font-family: 'Outfit', sans-serif; font-size: 15px;
            color: rgba(226, 232, 240, 0.6); margin: 0;
        }

        .rgu-faq__list { display: flex; flex-direction: column; gap: 12px; }

        .rgu-faq__item {
            background: rgba(15, 23, 42, 0.55);
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 16px;
            overflow: hidden;
            transition: border-color .25s ease, background .25s ease;
        }
        .rgu-faq__item:hover { border-color: rgba(168, 85, 247, 0.34); }
        .rgu-faq__item[open] {
            background: rgba(15, 23, 42, 0.85);
            border-color: rgba(168, 85, 247, 0.5);
        }

        .rgu-faq__q {
            display: flex; align-items: center; gap: 14px;
            padding: 18px 20px; cursor: pointer;
            font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 600;
            color: #f1f5f9; list-style: none;
        }
        .rgu-faq__q::-webkit-details-marker { display: none; }
        .rgu-faq__q:focus-visible { outline: 2px solid rgba(168, 85, 247, 0.75); outline-offset: -2px; }

        .rgu-faq__tag {
            flex-shrink: 0;
            font-size: 10px; font-weight: 700;
            letter-spacing: 0.08em; text-transform: uppercase;
            color: #d8b4fe;
            background: rgba(168, 85, 247, 0.14);
            border: 1px solid rgba(168, 85, 247, 0.28);
            border-radius: 9999px; padding: 4px 10px;
        }
        .rgu-faq__qtext { flex: 1 1 auto; line-height: 1.5; }
        .rgu-faq__chev { flex-shrink: 0; color: rgba(226, 232, 240, 0.55); transition: transform .3s ease; }
        .rgu-faq__item[open] .rgu-faq__chev { transform: rotate(180deg); color: #d8b4fe; }

        .rgu-faq__a {
            padding: 0 20px 20px;
            font-family: 'Outfit', sans-serif; font-size: 14.5px; line-height: 1.75;
            color: rgba(226, 232, 240, 0.66);
        }

        .rgu-faq__cta { text-align: center; margin-top: 34px; }
        .rgu-faq__btn {
            display: inline-flex; align-items: center; gap: 9px;
            font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 800;
            color: #0a0a14; text-decoration: none;
            background: linear-gradient(90deg, #a3e635, #34d399);
            border-radius: 12px; padding: 14px 28px;
            box-shadow: 0 8px 30px rgba(163, 230, 53, 0.28);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .rgu-faq__btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 36px rgba(163, 230, 53, 0.42);
        }

        @media (max-width: 640px) {
            .rgu-faq { padding: 56px 0; }
            .rgu-faq__q { flex-wrap: wrap; gap: 10px; padding: 16px; }
            .rgu-faq__qtext { flex: 1 1 100%; order: 3; }
            .rgu-faq__chev { margin-left: auto; }
            .rgu-faq__a { padding: 0 16px 16px; }
        }
        @media (prefers-reduced-motion: reduce) {
            .rgu-faq__item, .rgu-faq__chev, .rgu-faq__btn { transition: none; }
        }
    </style>
</section>
