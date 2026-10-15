@extends('layouts.app')

@section('title', 'Publications | Research · Rathinam Global University')
@section('description', 'Scopus / Web of Science indexed publications by faculty at Rathinam Global University, listed by academic year.')

@push('head')
    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>

    <style>
        :root { --brand:#7e22ce; --brand-2:#6d28d9; --brand-soft:#f5f3ff; --ink:#0f172a; --muted:#64748b; }
        html,body{overflow-x:hidden;}
        body{font-family:'Outfit',system-ui,sans-serif;color:var(--ink);background:#f8fafc;}
        h1,h2,h3,.font-sora{font-family:'Sora',sans-serif;}

        /* ── Hero ─────────────────────────────────────────────── */
        .g-hero{
            position:relative;background:#080810;color:#fff;overflow:hidden;
            padding:120px 0 80px;
        }
        .g-hero::before{
            content:"";position:absolute;inset:0;
            background:
                radial-gradient(60% 60% at 15% 0%, rgba(126,34,206,0.55) 0%, transparent 60%),
                radial-gradient(50% 60% at 90% 100%, rgba(56,189,248,0.30) 0%, transparent 60%);
        }
        .g-hero::after{
            content:"";position:absolute;inset:0;pointer-events:none;
            background:linear-gradient(180deg, rgba(8,8,16,0) 60%, rgba(8,8,16,0.55) 100%);
        }
        .g-hero > *{position:relative;z-index:1;}
        .g-hero h1 span.grad{
            background:linear-gradient(100deg,#e9d5ff 0%,#f9a8d4 50%,#a5b4fc 100%);
            -webkit-background-clip:text;background-clip:text;color:transparent;
        }

        /* ── Stat pills ───────────────────────────────────────── */
        .g-stat{
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.12);
            backdrop-filter:blur(10px);
        }

        /* ── Year picker (sticky) ─────────────────────────────── */
        .yr-bar{position:sticky;top:0;z-index:30;background:rgba(255,255,255,0.96);backdrop-filter:blur(12px);border-bottom:1px solid #e2e8f0;box-shadow:0 6px 22px -18px rgba(15,23,42,.2);}
        .yr-tab{
            display:inline-flex;align-items:center;gap:6px;
            padding:8px 14px;border-radius:9999px;
            font-size:12px;font-weight:700;letter-spacing:.02em;
            color:#475569;background:#f1f5f9;border:1.5px solid transparent;
            cursor:pointer;white-space:nowrap;transition:.2s;
        }
        .yr-tab:hover{background:#ede9fe;color:var(--brand);}
        .yr-tab.is-active{
            background:linear-gradient(135deg,var(--brand),var(--brand-2));
            color:#fff;box-shadow:0 8px 22px -8px rgba(126,34,206,.45);
        }
        .yr-tab .cnt{
            display:inline-flex;align-items:center;justify-content:center;
            min-width:22px;height:20px;padding:0 6px;border-radius:9999px;
            font-size:10px;font-weight:800;
            background:rgba(255,255,255,0.35);color:inherit;
        }
        .yr-tab.is-active .cnt{ background:rgba(255,255,255,0.28); }
        .yr-tab:not(.is-active) .cnt{ background:rgba(126,34,206,.10); color:var(--brand);}

        /* ── Table ────────────────────────────────────────────── */
        .g-card{background:#fff;border:1px solid #e2e8f0;border-radius:20px;overflow:hidden;box-shadow:0 12px 32px -20px rgba(15,23,42,0.15);}
        .g-card-head{
            padding:20px 24px;background:linear-gradient(135deg,#0f172a 0%,#312e81 100%);color:#fff;
            display:flex;align-items:center;justify-content:space-between;gap:18px;flex-wrap:wrap;
        }
        .g-card-head h2{ font-family:'Sora',sans-serif;font-weight:700;font-size:18px;letter-spacing:.02em;}
        .g-card-head .total-pill{
            display:inline-flex;align-items:center;gap:8px;
            background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.20);
            padding:8px 14px;border-radius:9999px;font-size:12px;font-weight:700;
        }
        .g-table{width:100%;border-collapse:separate;border-spacing:0;font-size:13px;}
        .g-table thead th{
            background:#0f172a;color:#fff;
            font-family:'Sora',sans-serif;font-weight:600;font-size:11px;
            letter-spacing:.10em;text-transform:uppercase;
            padding:14px 14px;text-align:left;white-space:nowrap;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }
        .g-table tbody td{
            padding:14px;border-bottom:1px solid #eef2f7;color:#1e293b;
            vertical-align:top;line-height:1.55;
        }
        .g-table tbody tr:hover td{background:#faf5ff;}
        .g-table tbody td.sno{color:#64748b;font-weight:600;font-variant-numeric:tabular-nums;width:52px;}
        .g-table tbody td.title{font-weight:600;color:#0f172a;min-width:260px;}
        .g-table tbody td.journal{font-style:italic;color:#475569;min-width:180px;}
        .g-table tbody td.vol{white-space:nowrap;color:var(--brand);font-weight:600;font-variant-numeric:tabular-nums;}
        .g-scroll{overflow-x:auto;}

        /* Filter input */
        .g-search{ position:relative; }
        .g-search input{
            width:100%;padding:12px 14px 12px 42px;border-radius:12px;
            border:1.5px solid #e2e8f0;background:#fff;
            font-size:14px;font-family:'Outfit',sans-serif;
            transition:border-color .2s, box-shadow .2s;
        }
        .g-search input:focus{outline:0;border-color:var(--brand);box-shadow:0 0 0 4px rgba(126,34,206,.12);}
        .g-search svg{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;}

        /* Section panels */
        .yr-panel{display:none;}
        .yr-panel.is-active{display:block;animation:fadein .4s ease both;}
        @keyframes fadein{ from{opacity:0;transform:translateY(8px);} to{opacity:1;transform:translateY(0);} }

        .g-empty{
            padding:60px 20px;text-align:center;color:#64748b;
            background:#fff;border:1px dashed #cbd5e1;border-radius:20px;
        }
        .g-empty svg{width:36px;height:36px;color:#cbd5e1;margin:0 auto 12px;}
    </style>
@endpush

@section('content')
<!-- ══════════════ HERO ══════════════ -->
<section class="g-hero">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 rounded-full border border-purple-300/40 bg-purple-500/15 px-4 py-1.5 mb-6 backdrop-blur">
            <span class="h-1.5 w-1.5 rounded-full bg-purple-300 animate-pulse"></span>
            <span class="text-[11px] font-semibold uppercase tracking-[0.22em] text-purple-100">Directorate of Research · Development · Innovation</span>
        </div>
        <h1 class="font-sora text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.05] tracking-tight max-w-4xl">
            <span class="grad">Publications</span> — Scopus &amp; Web of Science Indexed Research
        </h1>
        <p class="mt-5 max-w-2xl text-base sm:text-lg text-white/75 leading-relaxed">
            A year-wise record of Scopus and Web of Science indexed publications authored by faculty at Rathinam Global University across all schools and departments.
        </p>

        <!-- Summary strip -->
        <div class="mt-10 grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4 max-w-2xl">
            <div class="g-stat rounded-2xl px-5 py-4">
                <p class="font-sora text-3xl font-black leading-none">{!! count($academicYears) !!}</p>
                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/55 mt-1">Academic Years</p>
            </div>
            <div class="g-stat rounded-2xl px-5 py-4">
                <p class="font-sora text-3xl font-black leading-none">{!! $totalRows !!}+</p>
                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/55 mt-1">Total Publications</p>
            </div>
            <div class="g-stat rounded-2xl px-5 py-4">
                <p class="font-sora text-3xl font-black leading-none">Scopus / WoS</p>
                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/55 mt-1">Indexing</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════ YEAR PICKER ══════════════ -->
<div class="yr-bar">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center gap-3">
            <p class="hidden sm:block text-[10px] font-bold uppercase tracking-widest text-slate-500 whitespace-nowrap">Academic Year</p>
            <div class="flex items-center gap-2 overflow-x-auto x-2r0jpuo6" id="yr-tabs">
                @foreach ($academicYears as $i => $y)
                    <button type="button" class="yr-tab {!! $i === 0 ? 'is-active' : '' !!}" data-year="{!! $i !!}">
                        {{ $y['year'] }}                        <span class="cnt">{!! count($y['rows']) !!}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
<style>#yr-tabs::-webkit-scrollbar{display:none;height:0;}</style>

<!-- ══════════════ SEARCH + TABLES ══════════════ -->
<section class="py-10 sm:py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <!-- Global search -->
        <div class="g-search max-w-md mx-auto mb-8">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>
            </svg>
            <input id="g-filter" type="search" placeholder="Search by author, department, journal or title…">
        </div>

        <!-- One panel per year -->
        @foreach ($academicYears as $i => $y)
            <div class="yr-panel {!! $i === 0 ? 'is-active' : '' !!}" data-year-panel="{!! $i !!}">
                <div class="g-card">
                    <div class="g-card-head">
                        <h2>Academic Year {{ $y['year'] }}</h2>
                        <span class="total-pill">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM3 9h18M9 3v18"/></svg>
                            {!! count($y['rows']) !!} publications
                        </span>
                    </div>

                    <div class="g-scroll">
                        <table class="g-table">
                            <thead>
                                <tr>
                                    <th class="x-1j8nvcyy">S.No.</th>
                                    <th>School / Department</th>
                                    <th>Title</th>
                                    <th>Authors</th>
                                    <th>Journal</th>
                                    <th>Volume, Issue, Page, Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($y['rows'] as $r)
                                    <tr>
                                        <td class="sno">{{ $r[0] }}</td>
                                        <td>{{ $r[1] }}</td>
                                        <td class="title">{{ $r[2] }}</td>
                                        <td>{{ $r[3] }}</td>
                                        <td class="journal">{{ $r[4] }}</td>
                                        <td class="vol">{{ $r[5] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="g-empty hidden" data-empty>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                    <p class="font-sora font-bold text-slate-700">No publications match your search</p>
                    <p class="text-sm mt-1">Try a different keyword or clear the filter.</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Shared footer -->
@endsection

@push('scripts')
<script>
    // Year tab switching
    document.querySelectorAll('.yr-tab').forEach(function(tab){
        tab.addEventListener('click', function(){
            var idx = tab.getAttribute('data-year');
            document.querySelectorAll('.yr-tab').forEach(function(t){ t.classList.toggle('is-active', t === tab); });
            document.querySelectorAll('.yr-panel').forEach(function(p){
                p.classList.toggle('is-active', p.getAttribute('data-year-panel') === idx);
            });
            var input = document.getElementById('g-filter');
            if (input && input.value) { input.value = ''; runFilter(''); }
        });
    });

    // Live filter — searches every visible panel's rows
    function runFilter(q){
        q = (q || '').toLowerCase().trim();
        document.querySelectorAll('.yr-panel').forEach(function(panel){
            if (!panel.classList.contains('is-active')) return;
            var visible = 0;
            panel.querySelectorAll('tbody tr').forEach(function(tr){
                var text = tr.textContent.toLowerCase();
                var show = q === '' || text.indexOf(q) !== -1;
                tr.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            var empty = panel.querySelector('[data-empty]');
            var card  = panel.querySelector('.g-card');
            if (empty && card) {
                empty.classList.toggle('hidden', visible !== 0);
                card.classList.toggle('hidden', visible === 0);
            }
        });
    }
    var input = document.getElementById('g-filter');
    if (input) input.addEventListener('input', function(){ runFilter(this.value); });

    if (window.lucide) lucide.createIcons();
</script>
@endpush
