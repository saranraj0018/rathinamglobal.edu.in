@php
    $tick = '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>';
    $chevron = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>';
@endphp

<section id="opportunities" class="py-20 bg-[#050508] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-16">
            <div class="inline-flex gap-2 text-pink-400 uppercase text-xs font-semibold tracking-[0.25em] px-4 py-1.5 rounded-full bg-pink-400/10 border border-pink-400/20">
                Global Ecosystem
            </div>
            <h2 class="font-['Sora',sans-serif] font-black text-3xl sm:text-5xl text-white tracking-tight">
                Opportunities with <span class="bg-gradient-to-r from-pink-400 via-purple-400 to-sky-400 bg-clip-text text-transparent">Global Affairs</span>
            </h2>
            <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto">
                Tailored global pathways for partner institutions and RGU students alike.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <div class="relative overflow-hidden rounded-3xl border border-purple-500/30 bg-gradient-to-b from-purple-950/30 to-slate-900/60 p-8 sm:p-10 backdrop-blur-xl shadow-2xl flex flex-col justify-between">
                <div>
                    <div class="inline-block px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs font-bold uppercase tracking-wider mb-6">
                        Institutional Collaboration
                    </div>
                    <h3 class="font-['Sora',sans-serif] text-2xl sm:text-3xl font-extrabold text-white mb-6 border-b border-purple-500/30 pb-4">
                        For Partner Universities
                    </h3>
                    <ul class="space-y-4 text-slate-300 font-medium text-sm sm:text-base">
                        @foreach ($forPartners as $item)
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-sky-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $tick !!}</svg>
                                <span><strong>{{ $item['title'] }}</strong>{{ $item['text'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-8 pt-6 border-t border-purple-500/20">
                    <a href="#contact" class="inline-flex items-center gap-2 text-purple-400 hover:text-purple-300 font-bold text-sm font-['Sora',sans-serif]">
                        Explore Partnership MoUs →
                    </a>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-3xl border border-sky-400/30 bg-gradient-to-b from-sky-950/30 to-slate-900/60 p-8 sm:p-10 backdrop-blur-xl shadow-2xl flex flex-col justify-between">
                <div>
                    <div class="inline-block px-3 py-1 rounded-full bg-sky-400/20 text-sky-300 text-xs font-bold uppercase tracking-wider mb-6">
                        Student Mobility &amp; Twinning
                    </div>
                    <h3 class="font-['Sora',sans-serif] text-2xl sm:text-3xl font-extrabold text-white mb-6 border-b border-sky-400/30 pb-4">
                        For RGU Students
                    </h3>
                    <ul class="space-y-4 text-slate-300 font-medium text-sm sm:text-base">
                        @foreach ($forStudents as $item)
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-lime-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $tick !!}</svg>
                                @if (! empty($item['items']))
                                    <div>
                                        <strong>{{ $item['title'] }}</strong>
                                        <ul class="mt-2 space-y-1.5 text-slate-300 text-xs sm:text-sm pl-4 border-l border-white/15">
                                            @foreach ($item['items'] as $subItem)
                                                <li class="flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-sky-400 inline shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $chevron !!}</svg>
                                                    {{ $subItem }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <span><strong>{{ $item['title'] }}</strong>{{ $item['text'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-8 pt-6 border-t border-sky-400/20">
                    <a href="https://admissions.rathinamcollege.edu.in/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sky-400 hover:text-sky-300 font-bold text-sm font-['Sora',sans-serif]">
                        Apply for Global Track →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
