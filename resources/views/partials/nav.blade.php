{{-- Main site navigation. $navMode: 'transparent' (over the homepage banner) | 'solid' (sticky, own background). --}}
<style>
    .rgu-dropdown{visibility:hidden;opacity:0;transition:opacity .2s ease, visibility .2s ease;}
    .group:hover > .rgu-dropdown{visibility:visible;opacity:1;}
    .rgu-submenu{visibility:hidden;opacity:0;transition:opacity .2s ease, visibility .2s ease;}
    .rgu-subwrap:hover > .rgu-submenu{visibility:visible;opacity:1;}
    .rgu-nav-solid{background:rgba(5,11,31,0.95);backdrop-filter:blur(8px);position:sticky;top:0;}
</style>

<nav class="{{ ($navMode ?? 'transparent') === 'solid' ? 'rgu-nav-solid' : 'relative' }} z-50 flex items-center justify-between px-4 py-2 md:px-10 md:py-3">
    <a href="{{ route('home') }}" class="flex-shrink-0">
        <img src="{{ storage_asset('assets/images/logo-360.webp') }}" alt="Rathinam Global University Logo" id="rgu-nav-logo"
            width="140" height="40" fetchpriority="high" decoding="async"
            class="h-8 md:h-9 w-auto object-contain x-kj3vph7g">
    </a>

    <!-- Desktop Menu -->
    <ul class="hidden md:flex items-center gap-6 lg:gap-8 text-white text-sm lg:text-base font-medium">
        <li><a href="{{ route('home') }}" class="hover:text-gray-300 transition-colors">Home</a></li>

        <!-- About dropdown -->
        <li class="relative group">
            <button class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                About
                <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.39a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"/></svg>
            </button>
            <ul class="rgu-dropdown absolute right-0 top-full pt-2 w-56 z-50">
                <li class="rgu-subwrap relative bg-black/90 backdrop-blur-md border border-white/10">
                    <button class="w-full flex items-center justify-between px-4 py-2 hover:bg-white/10 transition-colors text-left">
                        Committee
                        <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path d="M7.21 14.77a.75.75 0 01.02-1.06L11.06 10 7.23 6.29a.75.75 0 111.04-1.08l4.39 4.25a.75.75 0 010 1.08l-4.39 4.25a.75.75 0 01-1.06-.02z"/></svg>
                    </button>
                    <ul class="rgu-submenu absolute right-full top-0 w-64 bg-black/90 backdrop-blur-md border border-white/10">
                        <li><a href="{{ route('committees.statutory') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors">Statutory Committees</a></li>
                        <li><a href="{{ route('committees.non-statutory') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors">Non Statutory Committees</a></li>
                    </ul>
                </li>
                <li class="rgu-subwrap relative bg-black/90 backdrop-blur-md border border-white/10">
                    <button class="w-full flex items-center justify-between px-4 py-2 hover:bg-white/10 transition-colors text-left">
                        Administration
                        <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path d="M7.21 14.77a.75.75 0 01.02-1.06L11.06 10 7.23 6.29a.75.75 0 111.04-1.08l4.39 4.25a.75.75 0 010 1.08l-4.39 4.25a.75.75 0 01-1.06-.02z"/></svg>
                    </button>
                    <ul class="rgu-submenu absolute right-full top-0 w-48 bg-black/90 backdrop-blur-md border border-white/10">
                        <li><a href="{{ route('research.registrar') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors">Registrar</a></li>
                    </ul>
                </li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10">
                    <a href="{{ route('eoa') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors">EOA</a>
                </li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10">
                    <a href="{{ route('iqac') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors">IQAC</a>
                </li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10">
                    <a href="{{ route('events.index') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors">Events</a>
                </li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10">
                    <a href="{{ storage_asset('assets/AICTE-Mandatory Disclosures.pdf') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>AICTE-Mandatory Disclosures</a>
                </li>
                <li class="rgu-subwrap relative bg-black/90 backdrop-blur-md border border-white/10">
                    <button class="w-full flex items-center justify-between px-4 py-2 hover:bg-white/10 transition-colors text-left">
                        ERP
                        <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path d="M7.21 14.77a.75.75 0 01.02-1.06L11.06 10 7.23 6.29a.75.75 0 111.04-1.08l4.39 4.25a.75.75 0 010 1.08l-4.39 4.25a.75.75 0 01-1.06-.02z"/></svg>
                    </button>
                    <ul class="rgu-submenu absolute right-full top-0 w-48 bg-black/90 backdrop-blur-md border border-white/10">
                        <li><a href="https://teacher.camu.in/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>ERP</a></li>
                        
                        <li><a href="https://student.camu.in/#/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>Student LMS</a></li>
                        
                        <li><a href="https://play.google.com/store/search?q=camu+staff+app&c=apps&hl=en-IN" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>Staff ERP App</a></li>
                        
                        <li><a href="https://play.google.com/store/search?q=camu+student+app&c=apps&hl=en-IN" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>Student LMS App</a></li>
                        
                        <li><a href="https://teams.microsoft.com/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>Digital Delivery</a></li>
                        
                        <li><a href="https://admission.nopaperforms.com/colleges/login" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>CRM</a></li>
                    </ul>
                </li>
                
                <li class="rgu-subwrap relative bg-black/90 backdrop-blur-md border border-white/10">
                    <button class="w-full flex items-center justify-between px-4 py-2 hover:bg-white/10 transition-colors text-left">
                        Digital Library
                        <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path d="M7.21 14.77a.75.75 0 01.02-1.06L11.06 10 7.23 6.29a.75.75 0 111.04-1.08l4.39 4.25a.75.75 0 010 1.08l-4.39 4.25a.75.75 0 01-1.06-.02z"/></svg>
                    </button>
                    <ul class="rgu-submenu absolute right-full top-0 w-48 bg-black/90 backdrop-blur-md border border-white/10">
                        <li><a href="https://rathinamcollege.knimbus.com/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>Knimbus</a></li>
                        
                        <li><a href="https://iitkgp.ac.in/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>National Digital Library</a></li>
                        
                        <li><a href="https://nlist.inflibnet.ac.in/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>Delnet</a></li>
                        
                        <li><a href="https://nlist.inflibnet.ac.in/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>B-List</a></li>
                        
                        <li><a href="https://jgateplus.com/home/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>J-Gate</a></li>
                        
                        <li><a href="https://www.pdfdrive.com/" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>E-Books</a></li>
                    </ul>
                </li>
                
                <li class="bg-black/90 backdrop-blur-md border border-white/10">
                    <a href="https://rathinamglobal.ac.in/feedback-from-stakeholders" class="block px-4 py-2 hover:bg-white/10 transition-colors" target=_blank>Feedback From Stakeholders</a>
                </li>
                
                
            </ul>
        </li>

        <!-- Research dropdown (8 sub-menu items) -->
        <li class="relative group">
            <button class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                Research
                <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.39a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"/></svg>
            </button>
            <ul class="rgu-dropdown absolute right-0 top-full pt-2 w-64 z-50">
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="{{ route('research.index') }}"                       class="block px-4 py-2 hover:bg-white/10 transition-colors">R & D</a></li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="{{ route('research.grants') }}"    class="block px-4 py-2 hover:bg-white/10 transition-colors">Grants Received</a></li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="{{ route('research.publications') }}"       class="block px-4 py-2 hover:bg-white/10 transition-colors">Publications</a></li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="{{ route('research.book-chapters') }}"      class="block px-4 py-2 hover:bg-white/10 transition-colors">Book Chapters</a></li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="{{ route('research.patents') }}"            class="block px-4 py-2 hover:bg-white/10 transition-colors">Patents</a></li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="https://scholar.google.com/citations?hl=en&user=5ca4ktkAAAAJ"  target="_blank" class="block px-4 py-2 hover:bg-white/10 transition-colors">Citation Metrics</a></li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="{{ route('research.extension-consultancy') }}" class="block px-4 py-2 hover:bg-white/10 transition-colors">Extension &amp; Consultancy</a></li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="{{ route('research.hackathons') }}"         class="block px-4 py-2 hover:bg-white/10 transition-colors">Hackathons</a></li>
                <li class="bg-black/90 backdrop-blur-md border border-white/10"><a href="{{ route('research.startups') }}"           class="block px-4 py-2 hover:bg-white/10 transition-colors">Startups</a></li>
            </ul>
        </li>
        <li><a href="{{ route('global-affairs') }}" class="hover:text-gray-300 transition-colors">Global Affairs</a></li>
        <li><a href="{{ route('careers') }}" class="hover:text-gray-300 transition-colors">Careers</a></li>
    </ul>

    <!-- Mobile toggle -->
    <button id="rgu-mobile-toggle" class="md:hidden text-white p-2" aria-label="Toggle menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
</nav>

<div id="rgu-mobile-menu" class="hidden md:hidden relative z-40 bg-black/90 backdrop-blur-md text-white px-4 py-3 border-t border-white/10">
    <ul class="flex flex-col gap-1 text-sm">
        <li><a href="{{ route('home') }}" class="block py-2">Home</a></li>
        <li>
            <details>
                <summary class="py-2 cursor-pointer list-none flex items-center justify-between">About <span>+</span></summary>
                <div class="pl-3">
                    <details>
                        <summary class="py-2 cursor-pointer list-none flex items-center justify-between">Committee <span>+</span></summary>
                        <ul class="pl-3">
                            <li><a href="{{ route('committees.statutory') }}" class="block py-2">Statutory Committees</a></li>
                            <li><a href="{{ route('committees.non-statutory') }}" class="block py-2">Non Statutory Committees</a></li>
                        </ul>
                    </details>
                    <details>
                        <summary class="py-2 cursor-pointer list-none flex items-center justify-between">Administration <span>+</span></summary>
                        <ul class="pl-3">
                            <li><a href="{{ route('research.registrar') }}" class="block py-2">Registrar</a></li>
                        </ul>
                    </details>
                    <a href="{{ route('eoa') }}" class="block py-2">EOA</a>
                    <a href="{{ route('iqac') }}" class="block py-2">IQAC</a>
                    <a href="{{ route('events.index') }}" class="block py-2">Events</a>
                    
                    <a href="{{ storage_asset('assets/AICTE-Mandatory Disclosures.pdf') }}" class="block py-2" target=_blank>AICTE-Mandatory Disclosures</a>
                    <details>
                        <summary class="py-2 cursor-pointer list-none flex items-center justify-between">ERP <span>+</span></summary>
                        <ul class="pl-3">
                            <li><a href="https://teacher.camu.in/" class="block py-2" target=_blank>ERP</a></li>
                            <li><a href="https://student.camu.in/#/" class="block py-2" target=_blank>Student LMS</a></li>
                            <li><a href="https://play.google.com/store/search?q=camu+staff+app&c=apps&hl=en-IN" class="block py-2" target=_blank>Staff ERP App</a></li>
                            <li><a href="https://play.google.com/store/search?q=camu+student+app&c=apps&hl=en-IN" class="block py-2" target=_blank>Sudent LMS App</a></li>
                            <li><a href="https://teams.microsoft.com/" class="block py-2" target=_blank>Digital Delivery</a></li>
                            <li><a href="https://admission.nopaperforms.com/colleges/login" class="block py-2" target=_blank>CRM</a></li>
                            
                        </ul>
                        
                    </details>
                    
                    <details>
                        <summary class="py-2 cursor-pointer list-none flex items-center justify-between">Digital Library <span>+</span></summary>
                        <ul class="pl-3">
                            <li><a href="https://rathinamcollege.knimbus.com/" class="block py-2" target=_blank>Knimbus</a></li>
                            <li><a href="https://iitkgp.ac.in/" class="block py-2" target=_blank>Naional Digital Library</a></li>
                            <li><a href="https://nlist.inflibnet.ac.in/" class="block py-2" target=_blank>Delnet</a></li>
                            <li><a href="https://nlist.inflibnet.ac.in/" class="block py-2" target=_blank>B-List</a></li>
                            <li><a href="https://jgateplus.com/home/" class="block py-2" target=_blank>J-Gate</a></li>
                            <li><a href="https://www.pdfdrive.com/" class="block py-2" target=_blank>E-Books</a></li>
                            
                        </ul>
                        
                    </details>
                    
                    <a href="https://rathinamglobal.ac.in/feedback-from-stakeholders" class="block py-2" target=_blank>Feedback From Stakeholders</a>
                    
                </div>
            </details>
        </li>
        <li>
            <details>
                <summary class="py-2 cursor-pointer list-none flex items-center justify-between">Research <span>+</span></summary>
                <div class="pl-3">
                    <a href="{{ route('research.index') }}"                          class="block py-2">R & D</a>
                    <a href="{{ route('research.grants') }}"       class="block py-2">Grants Received</a>
                    <a href="{{ route('research.publications') }}"          class="block py-2">Publications</a>
                    <a href="{{ route('research.book-chapters') }}"         class="block py-2">Book Chapters</a>
                    <a href="{{ route('research.patents') }}"               class="block py-2">Patents</a>
                    <a href="https://scholar.google.com/citations?hl=en&user=5ca4ktkAAAAJ"   target="_blank"   class="block py-2">Citation Metrics</a>
                    <a href="{{ route('research.extension-consultancy') }}" class="block py-2">Extension &amp; Consultancy</a>
                    <a href="{{ route('research.hackathons') }}"            class="block py-2">Hackathons</a>
                    <a href="{{ route('research.startups') }}"              class="block py-2">Startups</a>
                </div>
            </details>
        </li>
        <li><a href="{{ route('global-affairs') }}" class="block py-2">Global Affairs</a></li>
        <li><a href="{{ route('careers') }}" class="block py-2 font-semibold text-purple-400">Careers</a></li>
    </ul>
</div>
<script>
    (function(){
        var t=document.getElementById('rgu-mobile-toggle');
        var m=document.getElementById('rgu-mobile-menu');
        if(t&&m){t.addEventListener('click',function(){m.classList.toggle('hidden');});}
    })();
</script>
