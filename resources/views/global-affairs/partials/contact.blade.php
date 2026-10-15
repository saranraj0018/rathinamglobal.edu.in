<section id="contact" class="border-t border-white/10 bg-[#050508]">
    <div class="flex h-[3px]">
        <div class="flex-1 bg-purple-500"></div>
        <div class="flex-1 bg-sky-400"></div>
        <div class="flex-1 bg-lime-400"></div>
        <div class="flex-1 bg-pink-400"></div>
        <div class="flex-1 bg-orange-400"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid gap-12 grid-cols-1 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_320px]">
            <div>
                <h2 class="font-['Sora',sans-serif] text-base font-bold text-white mb-4">On This Page</h2>
                <ul class="space-y-2 text-sm text-white/70">
                    <li><a href="#about" class="hover:text-purple-400 transition-colors">About Office of Global Affairs</a></li>
                    <li><a href="#objectives" class="hover:text-purple-400 transition-colors">Key Objectives</a></li>
                    <li><a href="#opportunities" class="hover:text-purple-400 transition-colors">Global Opportunities</a></li>
                    <li><a href="#partners" class="hover:text-purple-400 transition-colors">Partner Institutions</a></li>
                    <li><a href="#team" class="hover:text-purple-400 transition-colors">Team &amp; Contacts</a></li>
                </ul>
            </div>

            <div>
                <h2 class="font-['Sora',sans-serif] text-base font-bold text-white mb-4">Global Programs</h2>
                <ul class="space-y-2 text-sm text-white/70">
                    @foreach ($programs as $program)
                        <li><a href="#opportunities" class="hover:text-sky-400 transition-colors">{{ $program }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="font-['Sora',sans-serif] text-base font-bold text-white mb-4">Contact Office</h2>
                <p class="text-sm leading-6 text-white/70 mb-3">{{ $contact['address'] }}</p>
                <p class="text-sm text-white/70"><a href="tel:{{ $contact['phone_link'] }}" class="hover:text-white">📞 {{ $contact['phone'] }}</a></p>
                <p class="text-sm text-[#38bdf8] hover:underline mt-1"><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></p>
            </div>
        </div>
    </div>
</section>
