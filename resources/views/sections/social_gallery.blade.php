<section id="social-gallery" class="py-12 sm:py-16 bg-white border-b border-[#f3f4f6]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-[11px] uppercase tracking-[0.2em] text-[#8b7355] block mb-1 font-semibold">{{ $content['handle'] ?? '' }}</span>
                <h2 class="font-brand text-xl sm:text-2xl text-[#292524] font-normal tracking-tight">{{ $content['heading'] ?? '' }}</h2>
            </div>
            @if(!empty($content['button_text']))
                <a href="{{ $content['button_url'] ?? '#' }}" target="_blank" class="text-xs font-brand uppercase tracking-wider text-[#8b7355] hover:text-[#292524] hover:underline motion-soft font-semibold">
                    {{ $content['button_text'] }} →
                </a>
            @endif
        </div>

        <!-- Lifestyle Grid Layout -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($content['images'] ?? [] as $img)
                @if(!empty($img))
                    <div class="aspect-square bg-[#f5efe6] overflow-hidden border border-[#f3f4f6] rounded-xl shadow-sm">
                        <img src="{{ str_starts_with($img, 'http') ? $img : asset($img) }}" alt="Social Grid" class="w-full h-full object-cover hover:scale-105 motion-soft duration-700">
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</section>
