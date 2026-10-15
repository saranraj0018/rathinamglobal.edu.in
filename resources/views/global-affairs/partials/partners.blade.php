<section id="partners" class="py-20 bg-[#080810] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-16">
            <div class="inline-flex gap-2 text-purple-400 uppercase text-xs font-semibold tracking-[0.25em] px-4 py-1.5 rounded-full bg-purple-400/10 border border-purple-400/20">
                Global Alliances
            </div>
            <h2 class="font-['Sora',sans-serif] font-black text-3xl sm:text-5xl text-white tracking-tight">
                Partnering <span class="bg-gradient-to-r from-purple-400 via-sky-400 to-emerald-400 bg-clip-text text-transparent">Institutions &amp; Universities</span>
            </h2>
            <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto">
                Fostering international academic excellence and worldwide institutional linkages.
            </p>
        </div>

        <div class="flex flex-wrap justify-center items-center gap-6 max-w-5xl mx-auto">
            @foreach ($partners as $partner)
                <div class="w-full sm:w-60 h-32 rounded-2xl border border-white/20 bg-white/95 p-4 flex items-center justify-center text-center backdrop-blur-md transition duration-300 hover:scale-105 hover:border-purple-400/60 shadow-xl">
                    <img src="{{ storage_asset($partner['logo']) }}" alt="{{ $partner['name'] }} logo" loading="lazy" decoding="async" class="max-h-full max-w-full object-contain">
                </div>
            @endforeach
        </div>
    </div>
</section>
