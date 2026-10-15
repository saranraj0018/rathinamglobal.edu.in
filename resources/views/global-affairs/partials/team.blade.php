<section id="team" class="py-20 bg-[#050508] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-16">
            <div class="inline-flex gap-2 text-sky-400 uppercase text-xs font-semibold tracking-[0.25em] px-4 py-1.5 rounded-full bg-sky-400/10 border border-sky-400/20">
                Leadership
            </div>
            <h2 class="font-['Sora',sans-serif] font-black text-3xl sm:text-5xl text-white tracking-tight">
                Office of <span class="bg-gradient-to-r from-purple-400 via-sky-400 to-amber-400 bg-clip-text text-transparent">Global Affairs Team</span>
            </h2>
            <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto">
                Dedicated leadership driving global partnerships, international student mobility, and institutional excellence.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach ($team as $member)
                <div class="relative overflow-hidden rounded-3xl border border-purple-500/20 bg-slate-900/80 backdrop-blur-xl shadow-2xl transition duration-300 hover:-translate-y-1 hover:border-purple-400/50 flex flex-col justify-between">
                    <div>
                        <div class="bg-gradient-to-r from-purple-900/80 via-purple-800/80 to-purple-900/80 p-6 flex justify-center items-center border-b border-purple-500/20">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 border-4 border-white/20 shadow-xl flex items-center justify-center font-['Sora',sans-serif] font-extrabold text-2xl text-white">
                                {{ $member['initials'] }}
                            </div>
                        </div>
                        <div class="p-6 text-center space-y-2">
                            <h3 class="font-['Sora',sans-serif] text-xl font-bold text-white">{{ $member['name'] }}</h3>
                            @isset($member['credentials'])
                                <p class="text-slate-400 text-xs italic font-medium">{{ $member['credentials'] }}</p>
                            @endisset
                            <p class="text-purple-400 font-semibold text-sm">{{ $member['role'] }}</p>
                            <p class="text-slate-300 text-xs leading-relaxed pt-2">
                                Rathinam Global Deemed to be University<br>
                                <span class="text-slate-400">{{ $contact['location'] }}</span>
                            </p>

                            @if (! empty($member['emails']) || ! empty($member['show_phone']))
                                <div class="pt-4 border-t border-white/10 space-y-2 text-xs">
                                    @if (! empty($member['show_phone']))
                                        <div>
                                            <a href="tel:{{ $contact['phone_link'] }}" class="inline-flex items-center gap-1.5 text-lime-400 hover:text-lime-300 font-medium transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                {{ $contact['phone'] }}
                                            </a>
                                        </div>
                                    @endif
                                    @foreach ($member['emails'] ?? [] as $email)
                                        <div>
                                            <a href="mailto:{{ $email }}" class="inline-flex items-center gap-1.5 text-sky-400 hover:text-sky-300 font-medium transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                {{ $email }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
