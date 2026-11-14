<section id="promotional" class="py-12 sm:py-16 bg-[#fdfbf7] border-b border-[#eae4d8]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="relative rounded-none overflow-hidden bg-[#f5efe6] border border-[#eae4d8] shadow-sm">
            <div class="absolute inset-0 z-0">
                <img src="{{ $content['image'] ?? '' }}" alt="Banner" loading="lazy" class="w-full h-full object-cover object-center brightness-[0.92]">
            </div>
            <div class="relative z-10 max-w-xl p-8 sm:p-14 bg-white/95 my-8 mx-6 sm:mx-12 border border-[#f3f4f6] shadow-md space-y-4 text-left">
                <span class="text-[10px] font-brand uppercase tracking-[0.25em] text-[#8b7355] font-semibold block">
                    {{ $content['badge'] ?? '' }}
                </span>
                <h3 class="font-brand text-2xl sm:text-3xl text-[#292524] font-normal leading-tight tracking-tight">
                    {!! $content['title'] ?? '' !!}
                </h3>
                <p class="text-xs text-[#786451] font-light leading-relaxed">
                    {{ $content['subtitle'] ?? '' }}
                </p>
                <div class="pt-2">
                    <a href="{{ url($content['button_url'] ?? '/') }}" class="inline-block py-3 px-6 bg-[#292524] text-white font-brand text-[11px] uppercase tracking-widest font-medium hover:bg-[#8b7355] motion-soft shadow-sm">
                        {{ $content['button_text'] ?? 'Shop Now' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
