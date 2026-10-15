{{--
    Fixed navbar shared by the school pages and the programme landing pages.

    school-name   label shown in the mobile menu
    school-href   parent school page (or "#" on the school page itself)
    program-name  set on a programme page: shows the breadcrumb and makes the
                  #programmes / #careers / #how-to-apply anchors point back
                  to the school page
    apply-url     "Apply Now" target
    accent        purple | emerald | sky | amber | rose | indigo | pink
--}}
@props([
    'schoolName' => '',
    'schoolHref' => '#',
    'programName' => '',
    'applyUrl' => 'https://admissions.rathinamcollege.edu.in/',
    'accent' => 'purple',
])
@php
    $palettes = [
        'purple'  => ['from' => '#7e22ce', 'to' => '#6d28d9', 'soft' => '#f5f3ff', 'ring' => '#a855f7'],
        'emerald' => ['from' => '#059669', 'to' => '#047857', 'soft' => '#ecfdf5', 'ring' => '#10b981'],
        'sky'     => ['from' => '#0284c7', 'to' => '#0369a1', 'soft' => '#f0f9ff', 'ring' => '#0ea5e9'],
        'amber'   => ['from' => '#d97706', 'to' => '#b45309', 'soft' => '#fffbeb', 'ring' => '#f59e0b'],
        'rose'    => ['from' => '#e11d48', 'to' => '#be123c', 'soft' => '#fff1f2', 'ring' => '#f43f5e'],
        'indigo'  => ['from' => '#4f46e5', 'to' => '#4338ca', 'soft' => '#eef2ff', 'ring' => '#6366f1'],
        'pink'    => ['from' => '#db2777', 'to' => '#be185d', 'soft' => '#fdf2f8', 'ring' => '#ec4899'],
    ];
    $palette = $palettes[$accent] ?? $palettes['purple'];
    $anchorBase = $programName !== '' ? rtrim($schoolHref, '#') : '';
@endphp
<style>
    /* Reserve space for the fixed nav so it doesn't overlap page content */
    body { padding-top: 64px; }
    /* Anchor links land below the nav, not under it */
    html { scroll-padding-top: 72px; }

    .cn-bar {
        --cn-from:{{ $palette['from'] }}; --cn-to:{{ $palette['to'] }};
        --cn-soft:{{ $palette['soft'] }};  --cn-ring:{{ $palette['ring'] }};
        position:fixed; top:0; left:0; right:0; z-index:50;
        background:rgba(8,8,16,0.92);
        backdrop-filter:blur(14px);
        -webkit-backdrop-filter:blur(14px);
        border-bottom:1px solid rgba(255,255,255,0.08);
    }
    .cn-bar .cn-logo-pill{
        display:inline-flex;align-items:center;justify-content:center;
        background:#fff;border-radius:12px;padding:6px 12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.25);
    }
    .cn-bar .cn-logo{ display:block; }
    .cn-bar .cn-link {
        position:relative;
        color:rgba(255,255,255,0.75);
        font-size:.875rem;font-weight:500;
        transition:color .2s;
    }
    .cn-bar .cn-link:hover { color:#fff; }
    .cn-bar .cn-link::after{
        content:""; position:absolute; left:0; right:0; bottom:-6px; height:2px;
        background:linear-gradient(90deg,var(--cn-from),var(--cn-to));
        transform:scaleX(0); transform-origin:left; transition:transform .25s ease;
        border-radius:2px;
    }
    .cn-bar .cn-link:hover::after,
    .cn-bar .cn-link.is-active::after { transform:scaleX(1); }
    .cn-bar .cn-link.is-active        { color:#fff; }
    .cn-bar .cn-cta{
        background:linear-gradient(135deg,var(--cn-from),var(--cn-to));
        box-shadow:0 10px 24px -8px color-mix(in srgb, var(--cn-ring) 65%, transparent);
        transition:transform .2s, box-shadow .2s;
    }
    .cn-bar .cn-cta:hover{ transform:translateY(-1px) scale(1.02); }
    .cn-bar .cn-hamburger{
        color:#fff;
        border:1px solid rgba(255,255,255,0.25);
        background:linear-gradient(135deg,var(--cn-from),var(--cn-to));
        box-shadow:0 6px 18px -6px color-mix(in srgb, var(--cn-ring) 60%, transparent);
        transition:transform .2s, box-shadow .2s;
    }
    .cn-bar .cn-hamburger:hover{ transform:scale(1.05); }
    .cn-bar .cn-hamburger svg{ stroke:#fff; }

    @media (max-width: 767px){
        .cn-bar .cn-logo-pill{ padding:5px 10px; }
        .cn-bar .cn-logo{ height:32px !important; max-width:200px !important; }
    }
    @media (max-width: 374px){
        .cn-bar .cn-logo{ height:28px !important; max-width:170px !important; }
    }
    .cn-bar #cn-mob-menu{
        background:rgba(8,8,16,0.96);
        border-top:1px solid rgba(255,255,255,0.08);
    }
    .cn-bar #cn-mob-menu a { color:rgba(255,255,255,0.78); }
    .cn-bar #cn-mob-menu a:hover { background:rgba(255,255,255,0.06); color:#fff; }
</style>

<nav class="cn-bar shadow-lg shadow-black/20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">

            <!-- Logo on a clean white pill (keeps NAAC / Tamil-Nadu badges legible) -->
            <a href="{{ route('home') }}" class="cn-logo-pill flex-shrink-0">
                <img class="cn-logo x-1j8to08c"
                     src="{{ storage_asset('assets/images/logo-360.webp') }}"
                     onerror="this.onerror=null;this.src='{{ storage_asset('assets/images/logo.webp') }}';"
                     alt="Rathinam Global University logo"
                    >
            </a>

            <!-- Desktop links -->
            <div class="hidden md:flex items-center gap-5 lg:gap-7 flex-shrink-0">
                <a href="{{ route('home') }}" class="cn-link">Home</a>
                <a href="{{ route('home') }}#courses" class="cn-link">Schools</a>
                <a href="{{ $anchorBase }}#programmes"
                   class="cn-link {{ $programName !== '' ? 'is-active' : '' }}">Programmes</a>
                <a href="{{ $anchorBase }}#careers"      class="cn-link">Careers</a>
                <a href="{{ $anchorBase }}#how-to-apply" class="cn-link">How to Apply</a>

                <a href="{{ $applyUrl }}" target="_blank"
                   class="cn-cta inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold text-white">
                    Apply Now &#x2192;
                </a>
            </div>

            <!-- Mobile hamburger -->
            <button id="cn-mob-btn" class="cn-hamburger md:hidden p-2 rounded-xl" aria-label="Menu" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile dropdown -->
        <div id="cn-mob-menu" class="md:hidden hidden pb-4 space-y-1 mt-1 pt-3 px-1">
            @if ($schoolName !== '')
                <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-widest text-white/45">{{ $schoolName }}</p>
                @if ($programName !== '')
                    <p class="px-3 pb-2 text-xs font-bold text-white">{{ $programName }}</p>
                @endif
            @endif
            <a href="{{ route('home') }}"                                 class="block px-3 py-2.5 text-sm font-medium rounded-xl">Home</a>
            <a href="{{ route('home') }}#courses"                class="block px-3 py-2.5 text-sm font-medium rounded-xl">Schools</a>
            <a href="{{ $anchorBase }}#programmes"                     class="block px-3 py-2.5 text-sm font-medium rounded-xl">Programmes</a>
            <a href="{{ $anchorBase }}#careers"                        class="block px-3 py-2.5 text-sm font-medium rounded-xl">Careers</a>
            <a href="{{ $anchorBase }}#how-to-apply"                   class="block px-3 py-2.5 text-sm font-medium rounded-xl">How to Apply</a>
            <a href="{{ $applyUrl }}" target="_blank"
               class="cn-cta block px-3 py-2.5 text-sm font-bold text-white rounded-xl text-center mt-2">Apply Now</a>
        </div>
    </div>
</nav>

<script>
(function(){
    var btn = document.getElementById('cn-mob-btn');
    var menu = document.getElementById('cn-mob-menu');
    if (!btn || !menu) return;
    btn.addEventListener('click', function(){
        var open = !menu.classList.contains('hidden');
        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', String(!open));
    });
})();
</script>
