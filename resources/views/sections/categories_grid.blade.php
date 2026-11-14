<section id="categories" class="py-12 sm:py-16 bg-white border-b border-[#f3f4f6]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-[11px] uppercase tracking-[0.2em] text-[#9a3412] font-semibold block mb-1">{{ $content['subheading'] ?? '' }}</span>
                <h2 class="font-brand text-2xl sm:text-3xl text-[#1c1917] font-normal tracking-tight">{{ $content['heading'] ?? '' }}</h2>
            </div>
            <p class="text-xs text-[#475569] max-w-xs sm:text-right font-normal">
                {{ $content['description'] ?? '' }}
            </p>
        </div>

        <!-- Dynamic Grid Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($content['categories'] ?? [] as $cat)
            <a href="{{ url($cat['url'] ?? '/') }}" class="group block relative overflow-hidden bg-[#fafafa] border border-[#f3f4f6] p-3 shadow-sm motion-soft hover:border-[#eae4d8]">
                <div class="aspect-[4/3] overflow-hidden relative mb-4 bg-[#f5efe6]">
                    <img src="{{ $cat['image'] ?? '' }}" alt="{{ $cat['name'] ?? '' }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 motion-soft duration-700">
                </div>
                <div class="flex items-center justify-between px-2 pb-1">
                    <span class="font-brand text-xs uppercase tracking-wider font-medium text-[#292524] group-hover:text-[#8b7355] motion-soft">{{ $cat['name'] ?? '' }}</span>
                    <span class="text-[10px] text-[#8b7355]">Explore →</span>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>
