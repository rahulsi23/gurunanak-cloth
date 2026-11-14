<section id="reviews" class="py-12 sm:py-16 bg-[#fafafa] border-b border-[#f3f4f6]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        
        <div class="text-center max-w-xl mx-auto mb-8 space-y-2">
            <span class="text-[11px] uppercase tracking-[0.2em] text-[#8b7355] block">{{ $content['subheading'] ?? '' }}</span>
            <h2 class="font-brand text-2xl sm:text-3xl text-[#292524] font-normal tracking-tight">{{ $content['heading'] ?? '' }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($content['reviews'] ?? [] as $review)
            <div class="bg-white border border-[#f3f4f6] p-8 shadow-sm flex flex-col justify-between motion-soft hover:border-[#eae4d8]">
                <div class="space-y-4">
                    <div class="flex text-[#8b7355] gap-0.5">
                        @for($i=0; $i<($review['rating'] ?? 5); $i++)
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-xs text-[#44403c] font-light leading-relaxed">
                        {{ $review['comment'] ?? '' }}
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-[#f3f4f6] flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#f5efe6] text-[#8b7355] font-brand font-medium text-xs flex items-center justify-center shrink-0">
                        {{ $review['initials'] ?? '??' }}
                    </div>
                    <div>
                        <h4 class="text-xs font-medium text-[#292524]">{{ $review['name'] ?? '' }}</h4>
                        <span class="text-[9px] text-[#a08a75] uppercase tracking-wider block">{{ $review['role'] ?? '' }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
