<section id="about" class="py-12 sm:py-16 bg-white border-b border-[#f3f4f6]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        
        <div class="aspect-[4/5] bg-[#f5efe6] overflow-hidden border border-[#f3f4f6] shadow-sm">
            <img src="{{ $content['image'] ?? '' }}" alt="About" class="w-full h-full object-cover hover:scale-105 motion-soft duration-1000">
        </div>

        <div class="space-y-6 lg:pl-6 text-left">
            <span class="text-xs uppercase tracking-[0.2em] text-[#8b7355] font-medium block">
                {{ $content['badge'] ?? '' }}
            </span>
            <h2 class="font-brand text-3xl sm:text-4xl text-[#292524] font-normal tracking-tight leading-tight">
                {!! $content['title'] ?? '' !!}
            </h2>
            <p class="text-xs sm:text-sm text-[#786451] font-light leading-relaxed">
                {{ $content['subtitle'] ?? '' }}
            </p>
            <p class="text-xs sm:text-sm text-[#786451] font-light leading-relaxed">
                {{ $content['description'] ?? '' }}
            </p>

            <div class="pt-4 border-t border-[#f3f4f6] flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-[#f5efe6] flex items-center justify-center font-brand font-bold text-xs text-[#8b7355]">
                    GC
                </div>
                <div>
                    <strong class="text-xs font-medium block text-[#292524]">{{ $content['signature_text'] ?? '' }}</strong>
                    <span class="text-[10px] text-[#a08a75] uppercase tracking-wider block">{{ $content['signature_sub'] ?? '' }}</span>
                </div>
            </div>
        </div>

    </div>
</section>
