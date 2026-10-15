{{--
    Secondary hero, directly below the banner.
    No accreditation ticker here on purpose: the marquee partial renders right
    below and already scrolls NAAC A++, NIRF, placements and partners.
--}}
<section class="rgu-hero2" aria-labelledby="rgu-hero2-title">
    <div class="rgu-hero2__inner">
        <a class="rgu-hero2__badge" href="https://admissions.rathinamcollege.edu.in/?utm_source=home&utm_medium=hero&utm_campaign=Admission">
            <span class="rgu-hero2__dot" aria-hidden="true"></span>
            Admissions 2026 are open
        </a>

        <h2 class="rgu-hero2__title" id="rgu-hero2-title">
            <span class="rgu-hero2__word"><i>Welcome</i></span>
            <span class="rgu-hero2__word"><i>to</i></span>
            <span class="rgu-hero2__word"><i>Rathinam</i></span>
            <span class="rgu-hero2__word rgu-hero2__word--grad"><i>Global</i></span>
        </h2>

        <p class="rgu-hero2__sub">
            Ten schools, a 70-acre campus shared with an operating technology park, and a way of
            teaching that puts students alongside working professionals from the first year.
        </p>

        <div class="rgu-hero2__acts">
            <a class="rgu-hero2__btn" href="https://admissions.rathinamcollege.edu.in/?utm_source=home&utm_medium=hero&utm_campaign=Admission">Apply 2026</a>
            <a class="rgu-hero2__ghost" href="{{ route('home') }}#courses">Explore programmes</a>
            <a class="rgu-hero2__ghost" href="{{ route('research.index') }}">Research at RGU</a>
        </div>

        <div class="rgu-hero2__chips">
            <a class="rgu-hero2__chip" href="#courses">
                <b>10</b><small>Schools</small>
            </a>
            <a class="rgu-hero2__chip" href="#ranking">
                <b>A++</b><small>NAAC accredited</small>
            </a>
            <a class="rgu-hero2__chip" href="{{ route('research.index') }}">
                <b>7</b><small>Research areas</small>
            </a>
            <a class="rgu-hero2__chip" href="#courses">
                <b>DBT</b><small>Star Scheme</small>
            </a>
        </div>
    </div>
</section>

<style>
    /* ── Secondary hero ─────────────────────────────────────── */
    .rgu-hero2 {
        position: relative;
        overflow: hidden;
        background: #080810;
        padding: 84px 16px 76px;
    }
    .rgu-hero2::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background:
            radial-gradient(68% 58% at 14% 4%,  rgba(126, 34, 206, 0.42) 0%, transparent 62%),
            radial-gradient(58% 52% at 86% 16%, rgba(56, 189, 248, 0.18) 0%, transparent 64%);
    }
    .rgu-hero2::after {
        content: "";
        position: absolute;
        inset: auto 0 0 0;
        height: 42%;
        pointer-events: none;
        background: linear-gradient(180deg, rgba(8, 8, 16, 0) 0%, #080810 92%);
    }
    .rgu-hero2__inner { position: relative; z-index: 1; max-width: 1080px; margin: 0 auto; text-align: center; }

    .rgu-hero2__badge {
        display: inline-flex; align-items: center; gap: 9px;
        font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 600;
        letter-spacing: .04em; color: #d8b4fe; text-decoration: none;
        background: rgba(168, 85, 247, 0.12);
        border: 1px solid rgba(216, 180, 254, 0.3);
        border-radius: 9999px; padding: 8px 16px;
        transition: background .25s ease, border-color .25s ease, transform .25s ease;
    }
    .rgu-hero2__badge:hover { background: rgba(168, 85, 247, 0.2); border-color: rgba(216, 180, 254, .55); transform: translateY(-2px); }
    .rgu-hero2__dot {
        width: 7px; height: 7px; border-radius: 50%; background: #a3e635;
        box-shadow: 0 0 0 4px rgba(163, 230, 53, .18);
        animation: rgu-hero2-pulse 2s ease-in-out infinite;
    }
    @keyframes rgu-hero2-pulse { 50% { opacity: .45; } }

    .rgu-hero2__title {
        font-family: 'Sora', sans-serif; font-weight: 900;
        font-size: clamp(2rem, 6vw, 4.2rem); line-height: 1.08;
        letter-spacing: -.035em; color: #f8fafc;
        margin: 22px 0 0;
    }
    .rgu-hero2__word { display: inline-block; overflow: hidden; vertical-align: bottom; }
    .rgu-hero2__word > i {
        display: inline-block; font-style: normal;
        animation: rgu-hero2-rise .8s cubic-bezier(.22,.61,.36,1) both;
    }
    .rgu-hero2__word:nth-child(1) > i { animation-delay: .02s; }
    .rgu-hero2__word:nth-child(2) > i { animation-delay: .10s; }
    .rgu-hero2__word:nth-child(3) > i { animation-delay: .18s; }
    .rgu-hero2__word:nth-child(4) > i { animation-delay: .26s; }
    @keyframes rgu-hero2-rise { from { transform: translateY(110%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .rgu-hero2__word--grad > i {
        background: linear-gradient(90deg, #a855f7, #38bdf8);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent; color: transparent;
    }

    .rgu-hero2__sub {
        font-family: 'Outfit', sans-serif; font-size: clamp(.95rem, 1.6vw, 1.1rem);
        line-height: 1.75; color: rgba(226, 232, 240, .62);
        max-width: 720px; margin: 20px auto 0;
    }

    .rgu-hero2__acts { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; margin-top: 32px; }
    .rgu-hero2__btn, .rgu-hero2__ghost {
        font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 800;
        text-decoration: none; border-radius: 12px; padding: 14px 26px;
        transition: transform .25s ease, box-shadow .25s ease, background .25s ease, border-color .25s ease;
    }
    .rgu-hero2__btn {
        color: #0a0a14; background: linear-gradient(90deg, #a3e635, #34d399);
        box-shadow: 0 8px 30px rgba(163, 230, 53, .28);
    }
    .rgu-hero2__btn:hover { transform: translateY(-2px); box-shadow: 0 12px 38px rgba(163, 230, 53, .42); }
    .rgu-hero2__ghost { color: rgba(226, 232, 240, .82); border: 1px solid rgba(148, 163, 184, .28); }
    .rgu-hero2__ghost:hover { transform: translateY(-2px); border-color: rgba(168, 85, 247, .6); background: rgba(168, 85, 247, .1); color: #fff; }

    .rgu-hero2__chips {
        display: grid; grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px; max-width: 760px; margin: 40px auto 0;
    }
    .rgu-hero2__chip {
        display: block; text-decoration: none; text-align: center;
        border: 1px solid rgba(148, 163, 184, .16);
        background: rgba(15, 23, 42, .55);
        border-radius: 16px; padding: 18px 10px;
        transition: transform .25s ease, border-color .25s ease, background .25s ease;
    }
    .rgu-hero2__chip:hover { transform: translateY(-4px); border-color: rgba(168, 85, 247, .45); background: rgba(15, 23, 42, .85); }
    .rgu-hero2__chip b {
        display: block; font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 900;
        background: linear-gradient(90deg, #a855f7, #38bdf8);
        -webkit-background-clip: text; background-clip: text;
        -webkit-text-fill-color: transparent; color: transparent;
    }
    .rgu-hero2__chip small {
        display: block; margin-top: 4px; font-family: 'Outfit', sans-serif;
        font-size: 11px; letter-spacing: .08em; text-transform: uppercase;
        color: rgba(226, 232, 240, .5);
    }

    @media (max-width: 860px) {
        .rgu-hero2 { padding: 60px 16px 54px; }
        .rgu-hero2__chips { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .rgu-hero2__acts a { flex: 1 1 auto; text-align: center; }
    }
    @media (prefers-reduced-motion: reduce) {
        .rgu-hero2__word > i { animation: none; }
        .rgu-hero2__dot { animation: none; }
        .rgu-hero2__badge, .rgu-hero2__btn, .rgu-hero2__ghost, .rgu-hero2__chip { transition: none; }
    }
</style>
