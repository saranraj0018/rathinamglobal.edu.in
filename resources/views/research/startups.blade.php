@extends('layouts.app')

@section('title', 'Startups & Incubation | Research · Rathinam Global University')
@section('description', 'Student and faculty startups, registered MSME / Pvt Ltd ventures, and entrepreneurial innovation enterprises at Rathinam Global University.')

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

        /* ── Year / Category picker (sticky) ─────────────────── */
        .yr-bar{position:sticky;top:0;z-index:30;background:rgba(255,255,255,0.96);backdrop-filter:blur(12px);border-bottom:1px solid #e2e8f0;box-shadow:0 6px 22px -18px rgba(15,23,42,.2);}
        .yr-tab{
            display:inline-flex;align-items:center;gap:6px;
            padding:8px 16px;border-radius:9999px;
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
        .g-table tbody td.name{font-weight:700;color:#0f172a;min-width:180px;}
        .g-table tbody td.date{white-space:nowrap;color:#64748b;font-size:12px;font-weight:500;}
        .g-table tbody td.field{color:#334155;min-width:200px;font-weight:500;}
        .g-table tbody td.regno{white-space:nowrap;color:var(--brand);font-weight:600;font-family:monospace;font-size:12px;}
        .g-table tbody td.founder{color:#0f172a;font-weight:600;min-width:180px;}
        .g-table tbody td.members{color:#475569;min-width:180px;}

        /* Category badge styles */
        .cat-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px; border-radius: 9999px;
            font-size: 10px; font-weight: 700; text-transform: uppercase; tracking: .04em;
            white-space: nowrap;
        }
        .cat-student { background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; }
        .cat-faculty { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

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
            <span class="grad">Startups &amp; Incubation</span> — Enterprise Ventures
        </h1>
        <p class="mt-5 max-w-2xl text-base sm:text-lg text-white/75 leading-relaxed">
            A comprehensive record of registered student startups, faculty spin-off ventures, MSME/Pvt Ltd enterprises, and technology products incubated at Rathinam Global University.
        </p>

        <!-- Summary strip -->
        <div class="mt-10 grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 max-w-3xl">
            <div class="g-stat rounded-2xl px-5 py-4">
                <p class="font-sora text-3xl font-black leading-none">{!! $totalStartups !!}</p>
                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/55 mt-1">Total Startups</p>
            </div>
            <div class="g-stat rounded-2xl px-5 py-4">
                <p class="font-sora text-3xl font-black leading-none">{!! $totalStudent !!}</p>
                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/55 mt-1">Student Ventures</p>
            </div>
            <div class="g-stat rounded-2xl px-5 py-4">
                <p class="font-sora text-3xl font-black leading-none">{!! $totalFaculty !!}</p>
                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/55 mt-1">Faculty Spin-Offs</p>
            </div>
            <div class="g-stat rounded-2xl px-5 py-4">
                <p class="font-sora text-3xl font-black leading-none">100%</p>
                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/55 mt-1">MSME Registered</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════ CATEGORY PICKER ══════════════ -->
<div class="yr-bar">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center gap-3">
            <p class="hidden sm:block text-[10px] font-bold uppercase tracking-widest text-slate-500 whitespace-nowrap">Filter Category</p>
            <div class="flex items-center gap-2 overflow-x-auto x-2r0jpuo6" id="cat-tabs">
                <button type="button" class="yr-tab is-active" data-cat="all">
                    All Startups
                    <span class="cnt">{!! $totalStartups !!}</span>
                </button>
                <button type="button" class="yr-tab" data-cat="Student Startups">
                    Student Startups
                    <span class="cnt">{!! $totalStudent !!}</span>
                </button>
                <button type="button" class="yr-tab" data-cat="Faculty Startups">
                    Faculty Startups
                    <span class="cnt">{!! $totalFaculty !!}</span>
                </button>
            </div>
        </div>
    </div>
</div>
<style>#cat-tabs::-webkit-scrollbar{display:none;height:0;}</style>

<!-- ══════════════ SEARCH + TABLE ══════════════ -->
<section class="py-10 sm:py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <!-- Global search -->
        <div class="g-search max-w-md mx-auto mb-8">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>
            </svg>
            <input id="g-filter" type="search" placeholder="Search by startup name, proprietor, domain field or regn no…">
        </div>

        <div class="g-card" id="main-card">
            <div class="g-card-head">
                <h2>Rathinam Global University — Registered Startups &amp; Incubated Ventures</h2>
                <span class="total-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4.5 4.5 0 0 0 0-9"/></svg>
                    <span id="card-count">{!! $totalStartups !!}</span> ventures
                </span>
            </div>

            <div class="g-scroll">
                <table class="g-table">
                    <thead>
                        <tr>
                            <th class="x-1j8nvcyy">S.No.</th>
                            <th>Startup Name &amp; Regn Date</th>
                            <th>Category</th>
                            <th>Field / Domain Area</th>
                            <th>MSME / LLP / Regn Number</th>
                            <th>Proprietor / Founder</th>
                            <th>Team Members</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allRows as $r)
                            <tr data-category="{{ $r['category'] }}" data-year="{{ $r['year'] }}">
                                <td class="sno">{{ $r['sno'] }}</td>
                                <td class="name">
                                    <div>{{ $r['name'] }}</div>
                                    @if ($r['date'] !== '')                                        <div class="date mt-1 flex items-center gap-1">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                            {{ $r['date'] }}                                        </div>
                                    @endif                                </td>
                                <td>
                                    <span class="cat-badge {{ $r['badge'] }}">
                                        {{ $r['category'] }}                                    </span>
                                </td>
                                <td class="field">{{ $r['field'] }}</td>
                                <td class="regno">{{ $r['regno'] }}</td>
                                <td class="founder">{{ $r['founder'] }}</td>
                                <td class="members">{{ $r['members'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="g-empty hidden" id="g-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <p class="font-sora font-bold text-slate-700">No startups match your search</p>
            <p class="text-sm mt-1">Try a different keyword or select another category.</p>
        </div>

    </div>
</section>

<!-- Shared footer -->
@endsection

@push('scripts')
<script>
    var currentCat = 'all';

    // Category tab switching
    document.querySelectorAll('.yr-tab').forEach(function(tab){
        tab.addEventListener('click', function(){
            currentCat = tab.getAttribute('data-cat');
            document.querySelectorAll('.yr-tab').forEach(function(t){ t.classList.toggle('is-active', t === tab); });
            var input = document.getElementById('g-filter');
            runFilter(input ? input.value : '');
        });
    });

    // Live filter — searches text & filters category
    function runFilter(q){
        q = (q || '').toLowerCase().trim();
        var card  = document.getElementById('main-card');
        var empty = document.getElementById('g-empty');
        var countSpan = document.getElementById('card-count');
        var visible = 0;
        
        card.querySelectorAll('tbody tr').forEach(function(tr){
            var catMatch = currentCat === 'all' || tr.getAttribute('data-category') === currentCat;
            var text = tr.textContent.toLowerCase();
            var searchMatch = q === '' || text.indexOf(q) !== -1;
            var show = catMatch && searchMatch;
            
            tr.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        
        if (countSpan) countSpan.textContent = visible;
        if (empty && card) {
            empty.classList.toggle('hidden', visible !== 0);
            card.classList.toggle('hidden', visible === 0);
        }
    }
    
    var input = document.getElementById('g-filter');
    if (input) input.addEventListener('input', function(){ runFilter(this.value); });

    if (window.lucide) lucide.createIcons();
</script>
@endpush
