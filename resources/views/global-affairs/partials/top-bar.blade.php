<div class="bg-[#080810] border-b border-white/10 text-xs text-slate-400 py-2 px-4 sm:px-8">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3 font-medium">
        <div class="flex items-center gap-2">
            <svg class="w-3.5 h-3.5 text-purple-400 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
            <span>{{ $contact['location'] }}</span>
        </div>
        <div class="flex flex-wrap items-center gap-4 sm:gap-6">
            <a href="tel:{{ $contact['phone_link'] }}" class="flex items-center gap-1.5 hover:text-purple-300 transition-colors">
                <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.46.57 3.58a1 1 0 0 1-.25 1.01l-2.2 2.2z"/></svg>
                {{ $contact['phone'] }}
            </a>
            <a href="mailto:{{ $contact['email'] }}" class="flex items-center gap-1.5 text-amber-400 hover:text-amber-300 transition-colors">
                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
                {{ $contact['email'] }}
            </a>
        </div>
    </div>
</div>
