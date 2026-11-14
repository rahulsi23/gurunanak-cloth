@if(isset($salesChannels) && $salesChannels->count() > 0)
    <div class="pt-5 space-y-2.5 {{ isset($centered) && $centered ? 'flex flex-col items-center' : 'text-left' }}">
        <span class="text-[9px] uppercase tracking-[0.25em] text-[#786451] block font-semibold {{ isset($centered) && $centered ? 'text-center' : '' }}">
            Also Available On
        </span>
        <div class="flex flex-wrap items-center gap-2.5 {{ isset($centered) && $centered ? 'justify-center' : 'justify-start' }}">
            @foreach($salesChannels as $channel)
                <a href="{{ $channel->url }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#fdfbf7] hover:bg-[#f5efe6] border border-[#eae4d8] rounded-xl shadow-[0_2px_8px_rgba(139,115,85,0.03)] hover:shadow-[0_4px_12px_rgba(139,115,85,0.08)] hover:-translate-y-0.5 transition-all duration-300 text-[10px] text-[#1c1917] font-semibold font-brand uppercase tracking-wider" title="Shop GURUNANAK on {{ $channel->name }}">
                    @if($channel->icon)
                        <img src="{{ asset('storage/' . $channel->icon) }}" alt="{{ $channel->name }}" class="w-3.5 h-3.5 object-contain">
                    @else
                        <svg class="w-3 h-3 text-[#8b7355]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    @endif
                    <span>{{ $channel->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif
