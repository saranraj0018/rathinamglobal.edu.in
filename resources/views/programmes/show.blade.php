@extends('layouts.app')

@section('title')
{{ $meta['department_name'] }} | {{ $meta['school'] }} | RGU
@endsection
@section('description'){{ $meta['department_name'] }} at Rathinam Global University — Curriculum, Eligibility, Fees, Outcomes and Career Pathways.@endsection

@push('head')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800&display=swap">

    <!-- Tailwind (compiled site stylesheet) + project styles -->
    <link rel="stylesheet" href="{{ storage_asset('assets/css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ storage_asset('assets/css/style.css') }}">

    <!-- Icons + Swiper for galleries -->
    <script src="https://unpkg.com/lucide@latest" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    <style>
        :root { --brand:#7e22ce; --brand-2:#6d28d9; --brand-soft:#f5f3ff; --ink:#0f172a; --muted:#64748b; }

        html { overflow-x: clip; }
        body { overflow-x: clip; font-family:'Outfit',system-ui,sans-serif; color:var(--ink); background:#fff; }
        h1,h2,h3,.font-sora{font-family:'Sora',sans-serif;}

        .lp-subnav{
            position:sticky;top:64px;z-index:40;
            background:rgba(255,255,255,0.96);
            backdrop-filter:blur(12px);
            border-bottom:1px solid #e2e8f0;
            transition:background .35s ease, border-color .35s ease, color .35s ease;
        }
        .lp-subnav-links{display:flex;flex-wrap:nowrap;gap:32px;overflow-x:auto;scrollbar-width:none;-ms-overflow-style:none;}
        .lp-subnav-links::-webkit-scrollbar{display:none;height:0;width:0;}
        .lp-subnav a{position:relative;padding:16px 4px;font-size:12px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:#64748b;transition:color .3s ease;white-space:nowrap;display:inline-block;}
        .lp-subnav a:hover{color:var(--brand);}
        .lp-subnav a.is-active{color:var(--brand);}
        .lp-subnav a.is-active::after{content:"";position:absolute;left:0;right:0;bottom:-1px;height:2px;background:var(--brand);border-radius:2px;transition:background .3s ease;}

        body.subnav-stuck .cn-bar{
            background:rgba(255,255,255,0.96) !important;
            border-bottom-color:rgba(15,23,42,0.10) !important;
            box-shadow:0 4px 18px -8px rgba(15,23,42,0.18) !important;
        }
        body.subnav-stuck .cn-bar .cn-link        { color:#475569 !important; }
        body.subnav-stuck .cn-bar .cn-link:hover  { color:var(--brand) !important; }
        body.subnav-stuck .cn-bar .cn-link.is-active{ color:var(--brand) !important; }

        body.subnav-stuck .lp-subnav{
            background:rgba(8,8,16,0.96);
            border-bottom-color:rgba(255,255,255,0.10);
            box-shadow:0 6px 22px -10px rgba(0,0,0,0.45);
        }
        body.subnav-stuck .lp-subnav a            { color:rgba(255,255,255,0.65); }
        body.subnav-stuck .lp-subnav a:hover      { color:#fff; }
        body.subnav-stuck .lp-subnav a.is-active  { color:#fff; }
        body.subnav-stuck .lp-subnav a.is-active::after{
            background:linear-gradient(90deg,#a855f7,#7e22ce);
        }

    
        .lp-hero{
            position:relative;min-height:86vh;display:flex;align-items:center;
            color:#fff;background-color:#0b0420;overflow:hidden;
        }
        .lp-hero img.lp-hero-bg{
            position:absolute;inset:0;width:100%;height:100%;object-fit:cover;
            object-position:65% 35%;opacity:1;z-index:0;
        }
        @media (max-width: 768px){
            .lp-hero img.lp-hero-bg{ object-position:center 30%; }
        }
        .lp-hero::before{
            content:"";position:absolute;inset:0;z-index:1;
            background:linear-gradient(90deg,
                rgba(11,4,32,0.78) 0%,
                rgba(11,4,32,0.55) 30%,
                rgba(11,4,32,0.18) 60%,
                rgba(11,4,32,0)    85%);
        }
        /* Very mild top/bottom vignette so the hero blends with the nav and page */
        .lp-hero::after{
            content:"";position:absolute;inset:0;z-index:1;pointer-events:none;
            background:linear-gradient(180deg,
                rgba(11,4,32,0.30) 0%,
                rgba(11,4,32,0)    14%,
                rgba(11,4,32,0)    82%,
                rgba(11,4,32,0.35) 100%);
        }
        /* Mobile: lighter wash, no purple tint */
        @media (max-width: 768px){
            .lp-hero::before{
                background:linear-gradient(180deg,
                    rgba(11,4,32,0.35) 0%,
                    rgba(11,4,32,0.70) 100%);
            }
        }
        .lp-hero .lp-hero-inner{position:relative;z-index:2;padding-top:96px;padding-bottom:72px;}
        @media (max-width: 640px){
            .lp-hero{min-height:auto;}
            .lp-hero .lp-hero-inner{padding-top:72px;padding-bottom:56px;}
        }
        .lp-hero h1{background:linear-gradient(100deg,#fff 0%,#fff 40%,#d8b4fe 90%);-webkit-background-clip:text;background-clip:text;color:transparent;}
        .lp-hero .btn-primary{background:linear-gradient(135deg,#a855f7,#7e22ce);color:#fff;box-shadow:0 18px 40px -10px rgba(168,85,247,0.65);}
        .lp-hero .btn-primary:hover{transform:scale(1.04);}
        .lp-hero .btn-ghost{background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.25);color:#fff;}
        .lp-hero .btn-ghost:hover{background:rgba(255,255,255,0.15);}

        .lp-hero .lp-hero-tag{
            position:absolute;right:6%;bottom:7%;z-index:2;
            display:none;align-items:center;gap:10px;
            padding:10px 14px;border-radius:14px;
            background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.22);
            backdrop-filter:blur(10px);
            font-size:12px;font-weight:600;color:#fff;
        }
        @media (min-width:1024px){ .lp-hero .lp-hero-tag{display:inline-flex;} }
        .lp-hero .lp-hero-tag .dot{width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 0 4px rgba(52,211,153,0.18);}

        .lp-section{padding:80px 0;scroll-margin-top:72px;position:relative;}

        .lp-bg-white   { background:#ffffff; }
        .lp-bg-lavender{ background:linear-gradient(180deg,#f3ebff 0%,#e9dcff 100%); }
        .lp-bg-mist    { background:linear-gradient(180deg,#e4efff 0%,#d6e6ff 100%); }
        .lp-bg-cream   {background:linear-gradient(180deg,#f3ebff 0%,#e9dcff 100%); }
        .lp-bg-mint    { background:linear-gradient(180deg,#e7f9ee 0%,#d2f1de 100%); }
        .lp-bg-slate   { background:#eef2f8; }

     
        .lp-bg-lavender::before,
        .lp-bg-mist::before,
        .lp-bg-cream::before,
        .lp-bg-mint::before,
        .lp-bg-slate::before{
            content:"";position:absolute;inset:0 0 auto 0;height:1px;
            background:linear-gradient(90deg,transparent 0%,rgba(126,34,206,0.25) 50%,transparent 100%);
        }
        .lp-eyebrow{display:inline-flex;align-items:center;gap:8px;font-size:11px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--brand);}
        .lp-eyebrow::before{content:"";width:32px;height:2px;background:var(--brand);}
        .lp-eyebrow--center::after{content:"";width:32px;height:2px;background:var(--brand);}
        .lp-title{font-size:clamp(28px,3.4vw,40px);font-weight:800;line-height:1.15;letter-spacing:-0.01em;color:var(--ink);margin-top:8px;margin-bottom:24px;}

      
        .pillar{
            position:relative;border-radius:18px;padding:28px;color:#fff;overflow:hidden;
            box-shadow:0 18px 36px -16px rgba(76,29,149,0.45);
            transition:transform .3s ease, box-shadow .3s ease;
        }
        .pillar:hover{ transform:translateY(-4px); box-shadow:0 24px 44px -16px rgba(76,29,149,0.55); }
        .pillar h4{font-family:'Sora',sans-serif;font-weight:700;font-size:17px;margin-bottom:14px;}
        .pillar ul li{font-size:13px;line-height:1.5;padding:4px 0;}
        .pillar .pillar-note{margin-top:14px;font-size:12px;line-height:1.55;color:rgba(255,255,255,0.85);}

        /* Four shades of the same violet family — light → deep, all on-brand. */
        .pillar.color-emerald{ background:linear-gradient(160deg,#c084fc 0%,#a855f7 100%); }  /* light lilac */
        .pillar.color-indigo { background:linear-gradient(160deg,#a855f7 0%,#7e22ce 100%); }  /* mid violet */
        .pillar.color-amber  { background:linear-gradient(160deg,#7e22ce 0%,#5b21b6 100%); }  /* deep purple */
        .pillar.color-rose   { background:linear-gradient(160deg,#5b21b6 0%,#312e81 100%); }  /* indigo-violet */
        /* Inner soft highlight on the top edge so each card still has dimension */
        .pillar::before{
            content:"";position:absolute;inset:0 0 auto 0;height:1px;
            background:linear-gradient(90deg,transparent 0%,rgba(255,255,255,0.4) 50%,transparent 100%);
        }

      
        details.acc{
            border:1px solid #e2e8f0;border-radius:14px;background:#fff;
            margin-bottom:10px;overflow:hidden;
            transition:box-shadow .35s ease, border-color .35s ease;
        }
        details.acc[open]{box-shadow:0 12px 32px -10px rgba(126,34,206,.18);border-color:#e9d5ff;}
        details.acc > summary{list-style:none;cursor:pointer;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px;font-weight:600;color:var(--ink);transition:background .25s ease, color .25s ease;}
        details.acc > summary::-webkit-details-marker{display:none;}
        details.acc[open] > summary{background:#faf5ff;color:var(--brand);}
        details.acc > summary .acc-plus{width:28px;height:28px;border-radius:50%;border:1.5px solid #cbd5e1;color:#64748b;display:inline-flex;align-items:center;justify-content:center;font-size:18px;line-height:1;transition:transform .4s cubic-bezier(.2,.7,.2,1), background .25s ease, border-color .25s ease, color .25s ease;}
        details.acc[open] > summary .acc-plus{background:var(--brand);border-color:var(--brand);color:#fff;transform:rotate(45deg);}

        details.acc > .acc-anim{
            display:grid !important;
            grid-template-rows:0fr;
            transition:grid-template-rows .45s cubic-bezier(.2,.7,.2,1), opacity .35s ease;
            opacity:0;
        }
        details.acc[open] > .acc-anim{ grid-template-rows:1fr; opacity:1; }
        details.acc > .acc-anim > .acc-body{ min-height:0; overflow:hidden; }

        details.acc .acc-body{padding:6px 20px 22px;color:var(--muted);font-size:14px;line-height:1.7;}

      
        .sem-grid{
            display:grid;
            grid-template-columns:1fr;
            gap:0;
            background:#fff;
            border:1px solid #e2e8f0;
            border-radius:24px;
            overflow:hidden;
        }
        @media (min-width: 900px){
            .sem-grid{grid-template-columns:240px 1fr;}
        }
        .sem-aside{
            background:#fafafa;
            border-bottom:1px solid #e2e8f0;
            padding:8px 0;
        }
        @media (min-width: 900px){
            .sem-aside{border-bottom:0;border-right:1px solid #e2e8f0;padding:14px 0;}
        }
        .sem-tab{
            position:relative;display:flex;align-items:center;gap:12px;width:100%;text-align:left;
            padding:14px 18px 14px 22px;font-size:13px;font-weight:600;color:#475569;
            border:0;border-left:3px solid transparent;
            background:#ffffff;cursor:pointer;
            margin:4px 8px;border-radius:12px;
            transition:background .25s ease, color .25s ease, transform .25s ease, box-shadow .25s ease;
        }
        .sem-tab .sem-num{
            display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;
            width:26px;height:26px;border-radius:8px;
            background:#f1f5f9;color:#64748b;font-weight:800;font-size:11px;
            transition:background .25s ease, color .25s ease;
        }
        .sem-tab .sem-label{flex:1;line-height:1.25;}
        .sem-tab .sem-chev{
            opacity:0;transform:translateX(-4px);
            transition:opacity .25s ease, transform .25s ease;
            color:rgba(255,255,255,0.85);font-size:14px;
        }
        .sem-tab:hover{
            background:linear-gradient(135deg,#faf5ff,#ede9fe);color:var(--brand);
            transform:translateX(2px);
        }
        .sem-tab:hover .sem-num{background:#e9d5ff;color:var(--brand);}
        .sem-tab.is-active{
            color:#fff;border-left-color:transparent;font-weight:700;
            background:linear-gradient(135deg,#7e22ce 0%,#6d28d9 60%,#4f46e5 100%);
            box-shadow:0 12px 28px -10px rgba(126,34,206,0.6);
            transform:translateX(4px);
        }
        .sem-tab.is-active::before{
            content:"";position:absolute;left:-4px;top:14%;bottom:14%;width:4px;border-radius:4px;
            background:linear-gradient(180deg,#fde047,#f59e0b);
            box-shadow:0 0 12px rgba(253,224,71,0.6);
        }
        .sem-tab.is-active .sem-num{background:rgba(255,255,255,0.22);color:#fff;}
        .sem-tab.is-active .sem-chev{opacity:1;transform:translateX(0);}

        .sem-content{padding:24px;overflow-x:auto;position:relative;}
        @media (min-width: 900px){ .sem-content{padding:32px;} }

        /* Animated panel transition */
        .sem-panel{display:none;opacity:0;transform:translateY(14px);}
        .sem-panel.is-active{
            display:block;
            animation:sem-fade-in .5s cubic-bezier(.2,.7,.2,1) forwards;
        }
        @keyframes sem-fade-in{
            from{opacity:0;transform:translateY(14px);}
            to  {opacity:1;transform:translateY(0);}
        }

        .sem-panel.is-active .curr-table tbody tr{
            animation:row-rise .55s cubic-bezier(.2,.7,.2,1) both;
        }
        .sem-panel.is-active .curr-table tbody tr:nth-child(1){animation-delay:.04s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(2){animation-delay:.08s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(3){animation-delay:.12s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(4){animation-delay:.16s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(5){animation-delay:.20s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(6){animation-delay:.24s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(7){animation-delay:.28s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(8){animation-delay:.32s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(9){animation-delay:.36s;}
        .sem-panel.is-active .curr-table tbody tr:nth-child(n+10){animation-delay:.40s;}
        @keyframes row-rise{
            from{opacity:0;transform:translateY(8px);}
            to  {opacity:1;transform:translateY(0);}
        }

        .curr-table{width:100%;border-collapse:separate;border-spacing:0;font-size:13px;min-width:560px;}
        .curr-table thead th{background:#f8fafc;color:#475569;font-size:11px;letter-spacing:.08em;text-transform:uppercase;padding:12px 14px;text-align:left;border-bottom:1px solid #e2e8f0;}
        .curr-table tbody td{padding:14px;border-bottom:1px solid #e2e8f0;color:#0f172a;vertical-align:top;}
        .curr-table tbody tr:hover td{background:#fafaff;}
        .curr-table tfoot td{padding:14px;background:#f5f3ff;color:var(--brand);font-weight:700;font-size:12px;letter-spacing:.06em;text-transform:uppercase;}

        /* Hide the sidebar tabs on mobile — switch to accordions */
        @media (max-width: 899px){
            .sem-aside{display:none;}
            .sem-content{padding:0;}
            .sem-grid{ border-radius:16px; }

            .sem-panel{
                display:block !important;
                opacity:1 !important;
                transform:none !important;
                animation:none !important;
                border-bottom:1px solid #e2e8f0;
                margin:0 !important;
            }
            .sem-panel:last-child{ border-bottom:0; }

            .sem-panel .sem-mobile-head{
                display:flex !important;align-items:center;justify-content:space-between;gap:10px;
                padding:12px 16px;cursor:pointer;background:#fff;font-weight:700;color:#0f172a;
                font-size:13px;
                transition:background .2s ease, color .2s ease;
            }
            .sem-panel.is-active .sem-mobile-head{background:#f5f3ff;color:var(--brand);}

            /* Collapsed = 0 height (no padding). Open = natural content height. */
            .sem-panel .sem-mobile-body{
                max-height:0;
                opacity:0;
                overflow:hidden;
                padding:0 16px;
                transition:max-height .35s ease, opacity .25s ease, padding .25s ease;
            }
            .sem-panel.is-active .sem-mobile-body{
                max-height:1400px;        /* generous cap — enough for tallest semester */
                opacity:1;
                padding:8px 16px 18px;
                overflow-x:auto;            /* wide tables scroll sideways */
            }

            .sem-panel .sem-mobile-head .acc-plus{
                transition:.3s cubic-bezier(.2,.7,.2,1);
                display:inline-flex;align-items:center;justify-content:center;
                width:24px;height:24px;border-radius:50%;
                border:1.5px solid #cbd5e1;color:#64748b;font-size:15px;line-height:1;
                flex-shrink:0;
            }
            .sem-panel.is-active .sem-mobile-head .acc-plus{
                background:var(--brand);color:#fff;border-color:var(--brand);transform:rotate(45deg);
            }

            /* Curriculum table — compact on mobile */
            .sem-panel .sem-mobile-body .curr-table{ min-width:480px; font-size:12px; }
            .sem-panel .sem-mobile-body .curr-table thead th,
            .sem-panel .sem-mobile-body .curr-table tbody td,
            .sem-panel .sem-mobile-body .curr-table tfoot td{ padding:8px 10px; }
            .sem-panel .sem-mobile-body .flex.flex-wrap{ margin-bottom:10px; }
        }
        @media (min-width: 900px){
            .sem-panel .sem-mobile-head{display:none;}
            .sem-panel .sem-mobile-body{display:block;padding:0;}
        }

        .out-tab{padding:10px 22px;font-size:13px;font-weight:700;color:var(--brand);border-radius:999px;border:1.5px solid #e9d5ff;background:#faf5ff;cursor:pointer;transition:.2s;}
        .out-tab:hover{background:#f3e8ff;border-color:#d8b4fe;transform:translateY(-1px);}
        /* All three outcome tabs share the violet family — light → deep */
        .out-tab[data-out="peo"].is-active{background:linear-gradient(135deg,#c084fc,#a855f7);color:#fff;border-color:transparent;box-shadow:0 8px 22px -4px rgba(168,85,247,.45);}
        .out-tab[data-out="pso"].is-active{background:linear-gradient(135deg,#a855f7,#7e22ce);color:#fff;border-color:transparent;box-shadow:0 8px 22px -4px rgba(126,34,206,.45);}
        .out-tab[data-out="po"].is-active {background:linear-gradient(135deg,#6d28d9,#4c1d95);color:#fff;border-color:transparent;box-shadow:0 8px 22px -4px rgba(76,29,149,.5);}
        .out-panel{display:none;}
        .out-panel.is-active{display:grid;}

        .out-panel[data-out-panel="peo"] > div{background:#faf5ff;border-color:#ede9fe;}
        .out-panel[data-out-panel="peo"] > div span:first-child{background:linear-gradient(135deg,#c084fc,#a855f7);}
        .out-panel[data-out-panel="pso"] > div{background:#f3e8ff;border-color:#e9d5ff;}
        .out-panel[data-out-panel="pso"] > div span:first-child{background:linear-gradient(135deg,#a855f7,#7e22ce);}
        .out-panel[data-out-panel="po"]  > div{background:#ede9fe;border-color:#ddd6fe;}
        .out-panel[data-out-panel="po"]  > div span:first-child{background:linear-gradient(135deg,#6d28d9,#4c1d95);}

        .dl-card{display:flex;align-items:center;gap:14px;padding:18px;border:1px solid #e2e8f0;border-radius:14px;background:#fff;transition:.2s;}
        .dl-card:hover{border-color:var(--brand);box-shadow:0 8px 28px rgba(126,34,206,.12);transform:translateY(-2px);}
        .dl-icon{width:46px;height:46px;border-radius:12px;background:var(--brand-soft);color:var(--brand);display:inline-flex;align-items:center;justify-content:center;}

        .apply-strip{background:linear-gradient(135deg,#7e22ce,#5b21b6);color:#fff;}

        .blank-hint{font-size:11px;color:#94a3b8;font-style:italic;}

        .lp-facilities, .lp-gallery{padding-bottom:42px;}
        .lp-fac-card{position:relative;height:280px;border-radius:20px;overflow:hidden;box-shadow:0 12px 30px -10px rgba(15,23,42,0.18);}
        .lp-fac-card img{width:100%;height:100%;object-fit:cover;display:block;transition:transform 6s ease;background:#e2e8f0;}
        .lp-fac-card:hover img{transform:scale(1.08);}
        .lp-fac-overlay{position:absolute;inset:0;display:flex;flex-direction:column;justify-content:flex-end;padding:20px 22px;background:linear-gradient(180deg,rgba(11,4,32,0) 35%,rgba(11,4,32,0.85) 100%);}

        /* Violet pill pagination — applied to BOTH carousels */
        .lp-fac-pagination,
        .lp-gallery .swiper-pagination{
            position:relative;margin-top:18px;text-align:center;
        }
        .lp-fac-pagination .swiper-pagination-bullet,
        .lp-gallery .swiper-pagination .swiper-pagination-bullet{
            background:#cbd5e1;opacity:1;width:8px;height:8px;margin:0 4px;transition:.2s;
        }
        .lp-fac-pagination .swiper-pagination-bullet-active,
        .lp-gallery .swiper-pagination .swiper-pagination-bullet-active{
            background:var(--brand);width:22px;border-radius:6px;
        }

        /* Campus gallery image card */
        .lp-gallery .swiper-slide img{
            width:100%;height:256px;object-fit:cover;border-radius:16px;
            background:#e2e8f0;box-shadow:0 8px 22px -10px rgba(15,23,42,0.18);
        }
    </style>
@endpush

@section('navigation')
    <x-courses-nav
        :school-name="$meta['school']"
        :school-href="route('schools.show', $meta['school_slug'])"
        :program-name="$meta['department_name']"
        :apply-url="$meta['apply_url']"
        accent="purple"
    />
@endsection

@section('content')
<!-- 1 · HERO -->
<section id="overview-hero" class="lp-hero">
    <img class="lp-hero-bg" src="{{ $programme['hero']['image'] }}"
         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1600&h=900&q=80';"
         alt="Students learning in the B.Sc Computer Science lab">


    <div class="lp-hero-inner mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8">
        <div class="lg:max-w-md"><!-- narrow text column so the students remain the focus of the photo -->
        <span class="inline-flex items-center gap-2 rounded-full border border-purple-300/40 bg-purple-500/15 px-4 py-1.5 mb-5 backdrop-blur">
            <span class="h-1.5 w-1.5 rounded-full bg-purple-300 animate-pulse"></span>
            <span class="text-[11px] font-semibold uppercase tracking-[0.22em] text-purple-100">{{ $programme['hero']['eyebrow'] }}</span>
        </span>

        <h1 class="font-sora text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-[1.1] tracking-tight max-w-[18ch]">
            {{ $programme['hero']['title'] }}        </h1>
        <p class="mt-4 max-w-md text-sm sm:text-base text-white/85 leading-relaxed">{{ $programme['hero']['subtitle'] }}</p>

        <div class="mt-10 flex flex-wrap gap-3">
            <a href="{{ $meta['apply_url'] }}" target="_blank"
               class="btn-primary inline-flex items-center gap-2 rounded-xl px-7 py-3.5 text-sm font-extrabold transition">
                APPLY NOW &rarr;
            </a>
            <a href="{{ $meta['brochure_url'] }}"
               class="btn-ghost inline-flex items-center gap-2 rounded-xl px-7 py-3.5 text-sm font-bold transition">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download Brochure
            </a>
        </div>

        </div><!-- /lg:max-w-2xl -->
    </div>
</section>

<!-- 2 · STICKY IN-PAGE NAV -->
<nav class="lp-subnav">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ul class="flex flex-nowrap gap-6 sm:gap-8 overflow-x-auto lp-subnav-links">
            <li><a href="#overview"        data-target="overview">Overview</a></li>
            <li><a href="#why-choose"      data-target="why-choose">Why Choose</a></li>
            <li><a href="#why-rgu"         data-target="why-rgu">Why RGU</a></li>
            <li><a href="#curriculum"      data-target="curriculum">Curriculum</a></li>
            <li><a href="#outcomes"        data-target="outcomes">Outcomes</a></li>
            <li><a href="#course-template" data-target="course-template">Course Template</a></li>
            <li><a href="#eligibility"     data-target="eligibility">Eligibility</a></li>
            <li><a href="#fees"            data-target="fees">Fee Structure</a></li>
            <li><a href="#facilities"      data-target="facilities">Facilities</a></li>
            <li><a href="#contact"         data-target="contact">Contact</a></li>
        </ul>
    </div>
</nav>

<!-- 3 · OVERVIEW -->
<section id="overview" class="lp-section lp-bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-[1.2fr_1fr] gap-12 items-center">
        <div>
            <span class="lp-eyebrow">Overview</span>
            <h2 class="lp-title">{{ $programme['overview']['headline'] }}</h2>
            @foreach ($programme['overview']['paragraphs'] as $p)
                <p class="text-[15px] leading-[1.85] text-slate-600 mb-5">{{ $p }}</p>
            @endforeach
            <div class="mt-6 inline-flex items-center gap-3 rounded-full bg-purple-50 border border-purple-100 px-5 py-2.5 text-xs font-semibold text-purple-700">
                <i data-lucide="award" class="w-4 h-4"></i>
                {{ $meta['duration_label'] }}            </div>
        </div>
    </div>
</section>

<!-- 4 · WHY CHOOSE -->
<section id="why-choose" class="lp-section lp-bg-lavender">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="lp-eyebrow">Why Choose This Program</span>
            <h2 class="lp-title">Future-Ready by Design</h2>
            <p class="max-w-2xl mx-auto text-slate-500 text-[15px] leading-7">A balanced blend of core computing fundamentals, frontier AI, hands-on labs and research orientation.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($programme['why_choose'] as $p)
                <div class="pillar color-{{ $p['color'] }}">
                    <div class="w-11 h-11 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center mb-4">
                        <i data-lucide="{{ $p['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <h4>{{ $p['title'] }}</h4>
                    <ul class="space-y-0.5 mt-2">
                        @foreach ($p['points'] as $pt)
                            <li>&bull; {{ $pt }}</li>
                        @endforeach
                    </ul>
                    <p class="pillar-note">{{ $p['note'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 13 · WHY RGU -->
<section id="why-rgu" class="lp-section lp-bg-white">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 text-center">
        <span class="lp-eyebrow lp-eyebrow--center">Why RGU</span>
        <h2 class="lp-title mx-auto max-w-3xl">{{ $programme['why_rgu']['headline'] }}</h2>
        <p class="mx-auto max-w-3xl text-[15px] text-slate-600 leading-7">{{ $programme['why_rgu']['body'] }}</p>

        <div class="mt-10 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-4xl mx-auto">
            @foreach ($programme['why_rgu']['stats'] as $s)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 flex flex-col items-center justify-center text-center">
                    <p class="font-sora text-3xl sm:text-4xl font-black text-purple-700">{{ $s['value'] }}</p>
                    <p class="text-[11px] font-semibold uppercase tracking-widest text-slate-500 mt-1">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- 8 · CURRICULUM -->
<section id="curriculum" class="lp-section lp-bg-mist">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="lp-eyebrow">Curriculum</span>
            <h2 class="lp-title">{{ $semesterCount }}-Semester Course Plan</h2>
            <p class="max-w-2xl mx-auto text-slate-500 text-[15px] leading-7">Select a semester to view its course listing, LTPC format and total credits.</p>
        </div>

        <div class="sem-grid">
            <!-- Desktop: vertical tab rail (hidden on mobile) -->
            <aside class="sem-aside">
                @foreach ($programme['curriculum'] as $i => $sem)
                    <button type="button" class="sem-tab {!! $i === 0 ? 'is-active' : '' !!}" data-sem="{!! $i !!}">
                        <span class="sem-num">{{ $sem['short_label'] }}</span>
                        <span class="sem-label">{{ $sem['sem'] }}</span>
                        <span class="sem-chev">&rsaquo;</span>
                    </button>
                @endforeach
            </aside>

            <div class="sem-content">
                @foreach ($programme['curriculum'] as $i => $sem)
                    <div class="sem-panel {!! $i === 0 ? 'is-active' : '' !!}" data-panel="{!! $i !!}">

                        <!-- Mobile-only collapsible header -->
                        <div class="sem-mobile-head" data-mobile-sem="{!! $i !!}">
                            <span>{{ $sem['sem'] }}</span>
                            <span class="acc-plus">+</span>
                        </div>

                        <div class="sem-mobile-body">
                            <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-widest text-purple-700">Semester</p>
                                    <h3 class="font-sora text-xl font-extrabold text-slate-900">{{ $sem['sem'] }}</h3>
                                </div>
                                <div class="flex gap-3 flex-wrap">
                                    <span class="rounded-lg bg-purple-50 border border-purple-100 px-3 py-1.5 text-xs font-semibold text-purple-700">Hours: {{ $sem['total_hours'] !== '' ? $sem['total_hours'] : '—' }}</span>
                                    <span class="rounded-lg bg-purple-50 border border-purple-100 px-3 py-1.5 text-xs font-semibold text-purple-700">Credits: {{ $sem['total_credits'] !== '' ? $sem['total_credits'] : '—' }}</span>
                                </div>
                            </div>
                            <table class="curr-table">
                                <thead>
                                    <tr>
                                        <th>CAT</th><th>Code</th><th>Course Title</th><th>LTPC</th><th>Credit</th><th>Evaluation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sem['courses'] as $c)
                                        <tr>
                                            <td>{!! $c['cat']    !== '' ? htmlspecialchars($c['cat'])    : '<span class="blank-hint">&mdash;</span>' !!}</td>
                                            <td class="font-mono text-xs">{!! $c['code']  !== '' ? htmlspecialchars($c['code'])  : '<span class="blank-hint">&mdash;</span>' !!}</td>
                                            <td>{!! $c['title']  !== '' ? htmlspecialchars($c['title'])  : '<span class="blank-hint">&mdash; elective slot &mdash;</span>' !!}</td>
                                            <td>{!! $c['ltpc']   !== '' ? htmlspecialchars($c['ltpc'])   : '<span class="blank-hint">&mdash;</span>' !!}</td>
                                            <td class="font-semibold">{!! $c['credit'] !== '' ? htmlspecialchars($c['credit']) : '<span class="blank-hint">&mdash;</span>' !!}</td>
                                            <td>{!! $c['eval']   !== '' ? htmlspecialchars($c['eval'])   : '<span class="blank-hint">&mdash;</span>' !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Total</td>
                                        <td>Total Hours: {{ $sem['total_hours'] !== '' ? $sem['total_hours'] : '—' }}</td>
                                        <td></td>
                                        <td colspan="2">Total Credits: {{ $sem['total_credits'] !== '' ? $sem['total_credits'] : '—' }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-10 bg-white border border-slate-200 rounded-2xl p-7">
            <h3 class="font-sora text-lg font-extrabold text-slate-900 mb-4">Curriculum Recommendations</h3>
            <ol class="grid sm:grid-cols-2 gap-3">
                @foreach ($programme['recommendations'] as $r)
                    <li class="flex items-start gap-3 text-sm">
                        <span class="w-7 h-7 rounded-full bg-purple-100 text-purple-700 font-extrabold text-xs flex items-center justify-center flex-shrink-0">{{ $r['no'] }}</span>
                        <span class="text-slate-700 leading-6">
                            {!! $r['point'] !== '' ? htmlspecialchars($r['point']) : '<span class="blank-hint">&mdash; recommendation pending &mdash;</span>' !!}                        </span>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>

<!-- 9 · OUTCOMES -->
<section id="outcomes" class="lp-section lp-bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="lp-eyebrow">Program Outcomes</span>
            <h2 class="lp-title">PEO &middot; PSO &middot; PO</h2>
            <p class="max-w-2xl mx-auto text-slate-500 text-[15px] leading-7">Educational objectives, specific outcomes, and program-level competencies that every graduate carries forward.</p>
        </div>

        <div class="flex flex-wrap justify-center gap-3 mb-8">
            <button type="button" class="out-tab is-active" data-out="peo">Educational Objectives (PEO)</button>
            <button type="button" class="out-tab" data-out="pso">Specific Outcomes (PSO)</button>
            <button type="button" class="out-tab" data-out="po">Program Outcomes (PO)</button>
        </div>

        @foreach (['peo','pso','po'] as $k)
            <div class="out-panel {!! $k === 'peo' ? 'is-active' : '' !!} grid sm:grid-cols-2 lg:grid-cols-4 gap-4" data-out-panel="{!! $k !!}">
                @foreach ($programme['outcomes'][$k] as $o)
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 hover:shadow-md transition flex flex-col">
                        <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-600 to-violet-700 text-white font-extrabold text-xs flex items-center justify-center mb-3 flex-shrink-0">{{ $o['no'] }}</span>
                        <h4 class="font-sora text-[15px] font-bold text-slate-900 leading-snug mb-2">{{ $o['title'] }}</h4>
                        <p class="text-[13px] leading-6 text-slate-600">{{ $o['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- 10 · COURSE TEMPLATE -->
<section id="course-template" class="lp-section lp-bg-lavender">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="lp-eyebrow">Detailed Course Template</span>
            <h2 class="lp-title">Per-Course Information</h2>
            <p class="max-w-2xl mx-auto text-slate-500 text-[15px] leading-7">A preview of the per-course detail template that faculty will duplicate for every course title in the curriculum.</p>
        </div>

        <details class="acc" open>
            <summary><span>i) Course Details</span><span class="acc-plus">+</span></summary>
            <div class="acc-body">
                <table class="w-full text-sm">
                    <tbody>
                        @foreach ($courseTemplate['details'] as $d)
                            <tr class="border-b border-slate-100 last:border-0">
                                <td class="py-3 pr-4 font-semibold text-slate-700 w-1/3">{{ $d['field'] }}</td>
                                <td class="py-3 text-slate-600">{!! $d['value'] !== '' ? htmlspecialchars($d['value']) : '<span class="blank-hint">&mdash; to be supplied</span>' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </details>

        <details class="acc">
            <summary><span>ii) Syllabus</span><span class="acc-plus">+</span></summary>
            <div class="acc-body">
                @foreach ($courseTemplate['syllabus'] as $u)
                    <div class="mb-3 last:mb-0">
                        <p class="text-sm font-bold text-purple-700">{{ $u['unit'] }}</p>
                        <p class="text-sm text-slate-600 mt-1">
                            {!! $u['content'] !== '' ? htmlspecialchars($u['content']) : '<span class="blank-hint">&mdash; unit content pending &mdash;</span>' !!}                        </p>
                    </div>
                @endforeach
            </div>
        </details>

        <details class="acc">
            <summary><span>iii) Objectives &amp; Outcomes</span><span class="acc-plus">+</span></summary>
            <div class="acc-body">
                <p class="text-sm font-bold text-purple-700 mb-1">Course Objectives</p>
                <p class="text-sm text-slate-600 mb-4">
                    {!! $courseTemplate['objectives'] !== '' ? htmlspecialchars($courseTemplate['objectives']) : '<span class="blank-hint">&mdash; objectives pending &mdash;</span>' !!}                </p>
                <p class="text-sm font-bold text-purple-700 mb-2">Course Outcomes</p>
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="text-left py-2 pr-3 text-[11px] uppercase tracking-widest text-slate-400 w-24">CO</th>
                            <th class="text-left py-2 text-[11px] uppercase tracking-widest text-slate-400">Statement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseTemplate['outcomes'] as $co)
                            <tr class="border-t border-slate-100">
                                <td class="py-3 pr-3 font-semibold text-purple-700">{{ $co['co'] }}</td>
                                <td class="py-3 text-slate-600">
                                    {!! $co['statement'] !== '' ? htmlspecialchars($co['statement']) : '<span class="blank-hint">&mdash; pending &mdash;</span>' !!}                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </details>

        <details class="acc">
            <summary><span>iv) CO &times; PO / PSO Mapping</span><span class="acc-plus">+</span></summary>
            <div class="acc-body overflow-x-auto">
                <table class="w-full text-xs border border-slate-200 rounded-md overflow-hidden">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-3 py-2 text-left">CO</th>
                            @foreach ($courseTemplate['co_po_mapping']['cols'] as $col)
                                <th class="px-2 py-2 text-center text-slate-500">{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseTemplate['co_po_mapping']['rows'] as $r)
                            <tr class="border-t border-slate-100">
                                <td class="px-3 py-2 font-semibold text-purple-700">{{ $r['co'] }}</td>
                                @foreach ($r['map'] as $v)
                                    <td class="px-2 py-2 text-center">{!! $v !== '' ? htmlspecialchars($v) : '<span class="blank-hint">&mdash;</span>' !!}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-[11px] text-slate-500 mt-2">Mapping levels: 1 &mdash; Low, 2 &mdash; Medium, 3 &mdash; High. Blank = no mapping.</p>
            </div>
        </details>

        <details class="acc">
            <summary><span>v) Evaluation Pattern</span><span class="acc-plus">+</span></summary>
            <div class="acc-body">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[11px] uppercase tracking-widest text-slate-400">
                            <th class="py-2 pr-3">Assessment</th><th class="py-2 pr-3">Internal Weightage</th><th class="py-2">End Semester Weightage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseTemplate['evaluation'] as $e)
                            <tr class="border-t border-slate-100">
                                <td class="py-3 pr-3 font-semibold text-slate-700">{{ $e['assessment'] }}</td>
                                <td class="py-3 pr-3 text-slate-600">{!! $e['internal'] !== '' ? htmlspecialchars($e['internal']) : '<span class="blank-hint">&mdash;</span>' !!}</td>
                                <td class="py-3 text-slate-600">{!! $e['end_sem']  !== '' ? htmlspecialchars($e['end_sem'])  : '<span class="blank-hint">&mdash;</span>' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </details>

        <details class="acc">
            <summary><span>vi) Text Books / References</span><span class="acc-plus">+</span></summary>
            <div class="acc-body">
                {!! $courseTemplate['textbooks'] !== '' || $courseTemplate['references'] !== ''
                    ? nl2br(htmlspecialchars($courseTemplate['textbooks']."\n\n".$courseTemplate['references']))
                    : '<span class="blank-hint">&mdash; textbook &amp; reference list pending &mdash;</span>' !!}            </div>
        </details>
    </div>
</section>


<!-- 6 · ELIGIBILITY -->
<section id="eligibility" class="lp-section lp-bg-mist">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="lp-eyebrow">Eligibility</span>
            <h2 class="lp-title">Admission Criteria</h2>
        </div>
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <table class="w-full text-sm">
                <tbody>
                    @foreach ($programme['eligibility'] as $row)
                        <tr class="border-b border-slate-100 last:border-0">
                            <td class="px-6 py-4 font-semibold text-slate-700 w-1/2 bg-slate-50">{{ $row['field'] }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                {!! $row['value'] !== '' ? htmlspecialchars($row['value']) : '<span class="blank-hint">&mdash; to be supplied</span>' !!}                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- 7 · FEE STRUCTURE -->
<section id="fees" class="lp-section lp-bg-white">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="lp-eyebrow">Fee Structure</span>
            <h2 class="lp-title">Investment in Your Future</h2>
        </div>
        @foreach ($programme['fees'] as $f)
            <details class="acc">
                <summary>
                    <span>{{ $f['heading'] }}</span>
                    <span class="acc-plus">+</span>
                </summary>
                <div class="acc-body">
                    {!! $f['body'] !== '' ? nl2br(htmlspecialchars($f['body'])) : '<span class="blank-hint">Fee details will be published as per institutional approval.</span>' !!}                </div>
            </details>
        @endforeach
    </div>
</section>






<!-- 11 · FACILITIES + Gallery -->
<section id="facilities" class="lp-section lp-bg-cream">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="lp-eyebrow">Facilities</span>
            <h2 class="lp-title">Labs, Software &amp; Learning Resources</h2>
        </div>
        @if (! empty($programme['facilities']))
            <div class="grid {{ $facilitiesGrid }} gap-5 mb-12">
                @foreach ($programme['facilities'] as $f)
                    <div class="bg-white/60 border border-slate-100 rounded-2xl p-6">
                        <h4 class="font-sora font-bold text-slate-900 mb-2">{{ $f['name'] }}</h4>
                        <p class="text-sm text-slate-600 leading-7">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        @endif
        <!-- Facilities moving carousel (auto-rotates) -->
        <div class="swiper lp-facilities">
            <div class="swiper-wrapper">
                @foreach ($programme['facilities_carousel'] as $i => $f)
                    <div class="swiper-slide">
                        <div class="lp-fac-card">
                            <img src="{{ $f['img'] }}" alt="{{ $f['label'] }}" loading="lazy"
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&h=800&q=80';">
                            <div class="lp-fac-overlay">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-purple-200 mb-1">Facility</p>
                                <h4 class="font-sora text-base font-extrabold text-white leading-tight">{{ $f['label'] }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination lp-fac-pagination"></div>
        </div>

        <!-- Campus gallery -->
        <div class="mt-12">
            <h3 class="font-sora text-lg font-extrabold text-slate-900 mb-4">Campus Gallery</h3>
            <div class="swiper lp-gallery">
                <div class="swiper-wrapper">
                    @foreach ($gallery as $i => $image)
                        <div class="swiper-slide">
                            <img src="{{ $image['src'] }}" loading="lazy" alt="{{ $programme['image_alts']['gallery'] }}"
                                 onerror="this.onerror=null;this.src='{{ $image['fallback'] }}';">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-4 relative"></div>
            </div>
        </div>
    </div>
</section>


<!-- 14 · DOWNLOADS -->
<section class="lp-section lp-bg-mist py-16">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <span class="lp-eyebrow">Downloads</span>
            <h2 class="lp-title">Helpful PDFs</h2>
        </div>
        <div class="grid sm:grid-cols-3 gap-4">
            @foreach ($programme['downloads'] as $d)
                <a href="{{ $d['url'] }}" target="_blank" class="dl-card">
                    <span class="dl-icon"><i data-lucide="book-open" class="w-5 h-5"></i></span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Download</p>
                        <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $d['title'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- 15 · CONTACT -->
<section id="contact" class="lp-section lp-bg-slate">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="lp-eyebrow">Contact</span>
            <h2 class="lp-title">Talk to Admissions</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-7">
                <h4 class="font-sora font-bold text-slate-900 mb-3">Admissions Office</h4>
                <p class="text-sm text-slate-600 leading-7">{{ $programme['contact']['admissions']['address'] }}</p>
                <p class="mt-3 text-sm text-slate-600"><span class="font-semibold">Phone:</span> {{ $programme['contact']['admissions']['phone'] }}</p>
                <p class="text-sm text-slate-600"><span class="font-semibold">Email:</span> {{ $programme['contact']['admissions']['email'] }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-7">
                <h4 class="font-sora font-bold text-slate-900 mb-3">Department Head</h4>
                <p class="text-sm text-slate-600"><span class="font-semibold">HoD:</span> {!! $programme['contact']['department']['head']  !== '' ? htmlspecialchars($programme['contact']['department']['head'])  : '<span class="blank-hint">&mdash; to be supplied</span>' !!}</p>
                <p class="mt-1 text-sm text-slate-600"><span class="font-semibold">Phone:</span> {!! $programme['contact']['department']['phone'] !== '' ? htmlspecialchars($programme['contact']['department']['phone']) : '<span class="blank-hint">&mdash; to be supplied</span>' !!}</p>
                <p class="text-sm text-slate-600"><span class="font-semibold">Email:</span> {!! $programme['contact']['department']['email'] !== '' ? htmlspecialchars($programme['contact']['department']['email']) : '<span class="blank-hint">&mdash; to be supplied</span>' !!}</p>
            </div>
        </div>
    </div>
</section>

<!-- Shared footer -->
@endsection

@push('scripts')
<script>
    window.addEventListener('DOMContentLoaded', function(){
        if (window.lucide) lucide.createIcons();

        /* ── Swap main-nav / sub-nav palettes when the sub-nav docks ── */
        (function(){
            var sub = document.querySelector('.lp-subnav');
            if (!sub) return;
            // Capture the sub-nav's natural Y position once (relative to document).
            var naturalTop = sub.getBoundingClientRect().top + window.scrollY;
            var dockY = 64; // main-nav height
            function update(){
                var stuck = window.scrollY + dockY >= naturalTop;
                document.body.classList.toggle('subnav-stuck', stuck);
            }
            window.addEventListener('scroll', update, { passive:true });
            window.addEventListener('resize', function(){
                // recalc the natural top if layout changed
                document.body.classList.remove('subnav-stuck');
                naturalTop = sub.getBoundingClientRect().top + window.scrollY;
                update();
            });
            update();
        })();

        (function(){
            // 1. Wrap every .acc-body in a .acc-anim div for the grid-rows transition
            document.querySelectorAll('details.acc > .acc-body').forEach(function(body){
                var wrapper = document.createElement('div');
                wrapper.className = 'acc-anim';
                body.parentNode.insertBefore(wrapper, body);
                wrapper.appendChild(body);
            });

            // 2. Group every set of sibling <details.acc>; treat each group as a single-open accordion
            var groups = new Set();
            document.querySelectorAll('details.acc').forEach(function(d){ groups.add(d.parentElement); });

            groups.forEach(function(parent){
                var details = Array.from(parent.querySelectorAll(':scope > details.acc'));
                if (!details.length) return;

                // 3. Open the first by default (close the rest, even if markup said open)
                details.forEach(function(d, i){
                    if (i === 0) d.setAttribute('open', '');
                    else d.removeAttribute('open');
                });

                // 4. Wire single-open behaviour
                details.forEach(function(d){
                    d.addEventListener('toggle', function(){
                        if (!d.open) return;
                        details.forEach(function(other){
                            if (other !== d && other.open) other.removeAttribute('open');
                        });
                    });
                });
            });
        })();

        // ── Semester switcher (desktop tabs + mobile accordion) ──
        function activateSem(idx){
            document.querySelectorAll('.sem-tab').forEach(function(t){
                t.classList.toggle('is-active', t.getAttribute('data-sem') === String(idx));
            });
            document.querySelectorAll('.sem-panel').forEach(function(p){
                p.classList.toggle('is-active', p.getAttribute('data-panel') === String(idx));
            });
        }
        document.querySelectorAll('.sem-tab').forEach(function(tab){
            tab.addEventListener('click', function(){
                activateSem(tab.getAttribute('data-sem'));
            });
        });
        // Mobile: click any semester header to toggle.
        // Single-open behaviour — clicking another head closes the current and opens the new.
        document.querySelectorAll('.sem-mobile-head').forEach(function(head){
            head.addEventListener('click', function(){
                var idx = head.getAttribute('data-mobile-sem');
                var panel = head.closest('.sem-panel');
                if (panel.classList.contains('is-active')) {
                    // Same panel tapped — collapse it
                    document.querySelectorAll('.sem-panel').forEach(function(p){ p.classList.remove('is-active'); });
                    document.querySelectorAll('.sem-tab').forEach(function(t){ t.classList.remove('is-active'); });
                } else {
                    activateSem(idx);
                }
            });
        });

        // Outcome tabs
        document.querySelectorAll('.out-tab').forEach(function(tab){
            tab.addEventListener('click', function(){
                var key = tab.getAttribute('data-out');
                document.querySelectorAll('.out-tab').forEach(function(t){ t.classList.toggle('is-active', t === tab); });
                document.querySelectorAll('.out-panel').forEach(function(p){
                    p.classList.toggle('is-active', p.getAttribute('data-out-panel') === key);
                });
            });
        });

        // Sub-nav: scrollspy + smooth scroll on click
        var links = document.querySelectorAll('.lp-subnav-links a');
        var subnavEl = document.querySelector('.lp-subnav');
        var sections = Array.from(links).map(function(a){
            return document.getElementById(a.getAttribute('data-target'));
        }).filter(Boolean);

        function subnavOffset(){
            // 64 = fixed main nav (.cn-bar) + sub-nav height + 12px buffer
            return 64 + (subnavEl ? subnavEl.offsetHeight : 0) + 12;
        }

        links.forEach(function(a){
            a.addEventListener('click', function(e){
                var id = a.getAttribute('data-target');
                var target = document.getElementById(id);
                if (!target) return;
                e.preventDefault();
                var top = target.getBoundingClientRect().top + window.scrollY - subnavOffset();
                window.scrollTo({ top: top, behavior: 'smooth' });
                history.replaceState(null, '', '#' + id);
            });
        });

        function onScroll(){
            var y = window.scrollY + subnavOffset() + 40;
            var current = null;
            sections.forEach(function(s){ if (s.offsetTop <= y) current = s.id; });
            links.forEach(function(a){
                a.classList.toggle('is-active', a.getAttribute('data-target') === current);
            });
        }
        window.addEventListener('scroll', onScroll, { passive:true });
        onScroll();

        // Swipers (gallery + facilities) — wait for swiper-bundle if needed
        function initSwipers(){
            if (!window.Swiper) return;
            new Swiper('.lp-gallery', {
                slidesPerView: 1, spaceBetween: 16, loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: '.lp-gallery .swiper-pagination', clickable: true },
                breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
            new Swiper('.lp-facilities', {
                slidesPerView: 1, spaceBetween: 20, loop: true,
                autoplay: { delay: 3500, disableOnInteraction: false, pauseOnMouseEnter: true },
                speed: 700,
                pagination: { el: '.lp-fac-pagination', clickable: true },
                breakpoints: {
                    640:  { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });
        }
        if (window.Swiper) initSwipers();
        else window.addEventListener('load', initSwipers);
    });
</script>
@endpush
