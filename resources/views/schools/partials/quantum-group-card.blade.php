{{-- Quantum school programme group card. $number: card badge, $group: [label, icon, color, courses => [[name, url]]]. --}}
            <div class="relative bg-white rounded-2xl border border-slate-100 shadow-sm p-7 hover:shadow-md transition">
                <span class="absolute -top-4 left-6 w-9 h-9 rounded-full bg-gradient-to-br from-purple-600 to-violet-600 text-white text-sm font-black flex items-center justify-center shadow-lg shadow-purple-500/30">{!! $number !!}</span>
                <h3 class="mt-2 mb-5 text-base font-extrabold uppercase tracking-wider text-slate-900">{!! $group['label'] !!}</h3>
                <ul class="space-y-3">
                    @foreach ($group['courses'] as $course)
                        <li class="flex items-start gap-2 text-sm leading-6">
                            <i data-lucide="arrow-right" class="w-4 h-4 {!! $group['color'] !!} mt-1 flex-shrink-0"></i>
                            @if ($course['url'])                                <a href="{{ $course['url'] }}" class="text-slate-700 hover:text-purple-700 hover:underline underline-offset-4 decoration-purple-400/60 transition inline-flex items-center gap-1.5">
                                    <span>{!! $course['name'] !!}</span>
                                    <span class="inline-flex items-center rounded-full bg-purple-100 text-purple-700 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider">View</span>
                                </a>
                            @else                                <span class="text-slate-700">{!! $course['name'] !!}</span>
                            @endif                        </li>
                    @endforeach                </ul>
            </div>
