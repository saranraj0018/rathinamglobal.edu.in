<section id="about" class="py-20 bg-[#050508] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-16">
            <div class="inline-flex gap-2 text-sky-400 uppercase text-xs font-semibold tracking-[0.25em] px-4 py-1.5 rounded-full bg-sky-400/10 border border-sky-400/20">
                Strategic Purpose
            </div>
            <h2 class="font-['Sora',sans-serif] font-black text-3xl sm:text-5xl text-white tracking-tight">
                Our Vision &amp; <span class="bg-gradient-to-r from-purple-400 to-sky-400 bg-clip-text text-transparent">Mission</span>
            </h2>
            <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto">
                Driving transformative global learning, academic excellence, and international collaboration.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            <div class="relative group overflow-hidden rounded-3xl border border-purple-500/30 bg-gradient-to-b from-purple-900/20 to-slate-900/50 p-8 sm:p-10 backdrop-blur-xl transition duration-500 hover:-translate-y-2 hover:border-purple-500/60 shadow-2xl">
                <div class="w-14 h-14 rounded-2xl bg-purple-600/20 border border-purple-500/40 flex items-center justify-center mb-6 text-purple-300 shadow-inner">
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10A15.3 15.3 0 0112 2z"></path>
                    </svg>
                </div>
                <h3 class="font-['Sora',sans-serif] text-2xl sm:text-3xl font-extrabold text-white mb-4">Vision</h3>
                <p class="text-slate-300 leading-relaxed text-sm sm:text-base">{{ $vision }}</p>
                <div class="mt-8 flex items-center gap-2 text-purple-400 font-semibold text-xs uppercase tracking-wider">
                    <span>Global Excellence</span>
                    <div class="h-0.5 w-12 bg-purple-500"></div>
                </div>
            </div>

            <div class="relative group overflow-hidden rounded-3xl border border-sky-400/30 bg-gradient-to-b from-sky-900/20 to-slate-900/50 p-8 sm:p-10 backdrop-blur-xl transition duration-500 hover:-translate-y-2 hover:border-sky-400/60 shadow-2xl">
                <div class="w-14 h-14 rounded-2xl bg-sky-500/20 border border-sky-400/40 flex items-center justify-center mb-6 text-sky-300 shadow-inner">
                    <svg class="w-8 h-8 text-sky-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.24a6 6 0 00-2.24 2.24"></path>
                    </svg>
                </div>
                <h3 class="font-['Sora',sans-serif] text-2xl sm:text-3xl font-extrabold text-white mb-4">Mission</h3>
                <p class="text-slate-300 leading-relaxed text-sm sm:text-base">{{ $mission }}</p>
                <div class="mt-8 flex items-center gap-2 text-sky-400 font-semibold text-xs uppercase tracking-wider">
                    <span>Strategic Mobility</span>
                    <div class="h-0.5 w-12 bg-sky-400"></div>
                </div>
            </div>
        </div>
    </div>
</section>
