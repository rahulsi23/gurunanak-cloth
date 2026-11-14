@php
    $slugs = $content['product_slugs'] ?? [];
    if (!is_array($slugs)) {
        $slugs = [];
    }

    // Fallback static catalogue if database has not yet been seeded
    $fallbackProducts = [
        'coat' => ['title' => 'Double Breasted Minimalist Wool Coat', 'price' => 380, 'image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80', 'slug' => 'coat'],
        'knitwear' => ['title' => 'Cashmere Blend Minimalist Knitwear', 'price' => 210, 'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80', 'slug' => 'knitwear'],
        'blouse' => ['title' => 'Refined Raw Silk Drape Blouse', 'price' => 145, 'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=600&q=80', 'slug' => 'blouse'],
        'blazer' => ['title' => 'Tailored Mid-Weight Woolen Blazer', 'price' => 420, 'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=600&q=80', 'slug' => 'blazer'],
        'trench' => ['title' => 'Beige Signature Structural Trench', 'price' => 290, 'image' => 'https://images.unsplash.com/photo-1554412933-514a83d2f3c8?auto=format&fit=crop&w=600&q=80', 'slug' => 'trench'],
        'crewneck' => ['title' => 'Minimalist Core Ribbed Crewneck', 'price' => 110, 'image' => 'https://images.unsplash.com/photo-1516762689617-e1cffcef479d?auto=format&fit=crop&w=600&q=80', 'slug' => 'crewneck'],
        'dress' => ['title' => 'Sleek Minimalist Column Dress', 'price' => 240, 'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=600&q=80', 'slug' => 'dress'],
        'trousers' => ['title' => 'Wide Leg Pleated Woolen Trousers', 'price' => 195, 'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=600&q=80', 'slug' => 'trousers'],
    ];

    // Fetch chosen products from Database
    $products = !empty($slugs)
        ? \App\Models\Product::whereIn('slug', $slugs)->where('is_visible', true)->get()->keyBy('slug')
        : collect();

    // Map according to exact ordering selected by admin, with fallback
    $displayProducts = collect();
    if (!empty($slugs)) {
        foreach ($slugs as $slug) {
            if ($products->has($slug)) {
                $displayProducts->push($products->get($slug));
            } elseif (isset($fallbackProducts[$slug])) {
                $displayProducts->push((object) $fallbackProducts[$slug]);
            }
        }
    }

    // If still empty (e.g. no products selected yet in admin), show latest visible products from database
    if ($displayProducts->isEmpty()) {
        $displayProducts = \App\Models\Product::where('is_visible', true)->orderBy('sort_order', 'asc')->latest()->take(4)->get();
    }
@endphp

<section id="{{ Str::slug($content['heading'] ?? 'products') }}" class="py-12 sm:py-16 bg-[#fafafa] border-b border-[#f3f4f6]">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        
        <div class="text-center max-w-xl mx-auto mb-8 space-y-2">
            <span class="text-[11px] uppercase tracking-[0.2em] text-[#9a3412] font-semibold block">{{ $content['subheading'] ?? '' }}</span>
            <h2 class="font-brand text-2xl sm:text-3xl text-[#1c1917] font-normal tracking-tight">{{ $content['heading'] ?? '' }}</h2>
            <p class="text-xs text-[#475569] font-normal">{{ $content['description'] ?? '' }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($displayProducts as $product)
                @php
                    $pSlug = is_object($product) ? ($product->slug ?? '') : ($product['slug'] ?? '');
                    $pTitle = is_object($product) ? ($product->title ?? '') : ($product['title'] ?? '');
                    $pPrice = is_object($product) ? ($product->price ?? 0) : ($product['price'] ?? 0);
                    
                    // Resolving robust dynamic image URL
                    $pImg = '';
                    if (is_object($product)) {
                        $pImg = $product->image_url ?? $product->image_path ?? $product->image ?? $product->primary_image ?? '';
                    } elseif (is_array($product)) {
                        $pImg = $product['image_url'] ?? $product['image_path'] ?? $product['image'] ?? '';
                    }

                    if ($pImg && !str_starts_with($pImg, 'http')) {
                        $pImg = url($pImg);
                    }
                    if (empty($pImg)) {
                        $pImg = 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80';
                    }
                @endphp
                <a href="{{ route('product.detail', $pSlug) }}" class="group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500 rounded-sm">
                    <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                        <img src="{{ $pImg }}" 
                             alt="{{ $pTitle }}" 
                             loading="lazy" 
                             decoding="async" 
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80';"
                             class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                        <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                            <span class="w-full block text-center py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                                View Details
                            </span>
                        </div>
                    </div>
                    <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors line-clamp-1">{{ $pTitle }}</h3>
                        </div>
                        <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">${{ number_format($pPrice, 2) }}</span>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>
