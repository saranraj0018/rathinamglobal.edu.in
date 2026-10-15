<section class="relative overflow-hidden pt-16 pb-24 lg:pt-24 lg:pb-32 bg-[#080810]">
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-purple-600/30 rounded-full blur-[120px]"></div>
        <div class="absolute top-1/2 right-0 w-[500px] h-[500px] bg-sky-500/20 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-pink-500/15 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 text-purple-300 uppercase text-xs font-semibold tracking-[0.25em] px-4 py-2 rounded-full bg-white/10 backdrop-blur-md mb-8 border border-white/15 shadow-lg">
            <span class="w-2.5 h-2.5 rounded-full bg-purple-400 shadow-[0_0_12px_#a855f7] animate-pulse"></span>
            <span>The Office of Global Affairs</span>
        </div>

        <h1 class="font-['Sora',sans-serif] font-black text-4xl sm:text-6xl lg:text-7xl leading-tight tracking-tight text-white max-w-5xl mx-auto">
            Connecting RGU to the <br>
            <span class="bg-gradient-to-r from-sky-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">World Ecosystem</span>
        </h1>

        <p class="mt-6 text-base sm:text-xl text-slate-300 max-w-3xl mx-auto font-normal leading-relaxed">
            Building a globally engaged university ecosystem — driving strategic international partnerships, student &amp; faculty mobility, collaborative research, and transformative global opportunities.
        </p>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-4 sm:gap-6">
            <a href="#opportunities"
               class="inline-flex items-center gap-3 rounded-2xl bg-gradient-to-r from-lime-400 to-emerald-400 px-8 py-4 text-sm sm:text-base font-extrabold text-[#0a0a14] shadow-[0_8px_32px_rgba(163,230,53,0.35)] transition duration-300 hover:scale-105 font-['Sora',sans-serif]">
                Explore Opportunities
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="#contact"
               class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/5 px-8 py-4 text-sm sm:text-base font-bold text-white backdrop-blur-md transition duration-300 hover:bg-white/10 hover:border-white/40 font-['Sora',sans-serif]">
                Partner With Us
            </a>
        </div>

        <div class="mt-16 sm:mt-24 grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 max-w-6xl mx-auto">
            @foreach ($stats as $stat)
                <div class="relative overflow-hidden rounded-2xl border {{ $stat['border'] }} bg-white/5 p-6 backdrop-blur-md text-left transition duration-300">
                    <div class="text-3xl sm:text-4xl font-extrabold font-['Sora',sans-serif] {{ $stat['color'] }}">{{ $stat['value'] }}</div>
                    <div class="mt-1 text-xs sm:text-sm text-slate-300 font-medium">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
