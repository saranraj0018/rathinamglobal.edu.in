<section id="objectives" class="py-20 bg-[#080810] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-16">
            <div class="inline-flex gap-2 text-lime-400 uppercase text-xs font-semibold tracking-[0.25em] px-4 py-1.5 rounded-full bg-lime-400/10 border border-lime-400/20">
                Core Pillars
            </div>
            <h2 class="font-['Sora',sans-serif] font-black text-3xl sm:text-5xl text-white tracking-tight">
                Key <span class="bg-gradient-to-r from-lime-400 to-emerald-400 bg-clip-text text-transparent">Objectives</span>
            </h2>
            <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto">
                Three cornerstone objectives driving our global outreach and academic impact.
            </p>
        </div>

        <div class="space-y-6 max-w-5xl mx-auto">
            @foreach ($objectives as $objective)
                <div class="group relative overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-6 sm:p-8 backdrop-blur-md transition duration-300 {{ $objective['hover'] }} hover:bg-white/[0.07]">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br {{ $objective['badge'] }} font-['Sora',sans-serif] font-black text-xl flex items-center justify-center shadow-lg">
                            {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-['Sora',sans-serif] text-lg sm:text-xl font-bold text-white">{{ $objective['title'] }}</h3>
                            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">{{ $objective['text'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
