@php
$catalog = [
    'coat' => [
        'title' => 'Double Breasted Minimalist Wool Coat',
        'parent_cat' => 'Women',
        'sub_cat' => 'Outerwear',
        'price' => 380.00,
        'image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80'
    ],
    'blouse' => [
        'title' => 'Refined Raw Silk Drape Blouse',
        'parent_cat' => 'Women',
        'sub_cat' => 'Apparel',
        'price' => 145.00,
        'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=600&q=80'
    ],
    'dress' => [
        'title' => 'Sleek Minimalist Column Dress',
        'parent_cat' => 'Women',
        'sub_cat' => 'Dresses',
        'price' => 240.00,
        'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=600&q=80'
    ],
    'trousers' => [
        'title' => 'Wide Leg Pleated Woolen Trousers',
        'parent_cat' => 'Women',
        'sub_cat' => 'Tailoring',
        'price' => 195.00,
        'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=600&q=80'
    ],
    'knitwear' => [
        'title' => 'Cashmere Blend Minimalist Knitwear',
        'parent_cat' => 'Men',
        'sub_cat' => 'Knitwear',
        'price' => 210.00,
        'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80'
    ],
    'crewneck' => [
        'title' => 'Minimalist Core Ribbed Crewneck',
        'parent_cat' => 'Men',
        'sub_cat' => 'Basics',
        'price' => 110.00,
        'image' => 'https://images.unsplash.com/photo-1516762689617-e1cffcef479d?auto=format&fit=crop&w=600&q=80'
    ],
    'blazer' => [
        'title' => 'Tailored Mid-Weight Woolen Blazer',
        'parent_cat' => 'Men',
        'sub_cat' => 'Suiting',
        'price' => 420.00,
        'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=600&q=80'
    ],
    'trench' => [
        'title' => 'Beige Signature Structural Trench',
        'parent_cat' => 'Men',
        'sub_cat' => 'Coats',
        'price' => 290.00,
        'image' => 'https://images.unsplash.com/photo-1554412933-514a83d2f3c8?auto=format&fit=crop&w=600&q=80'
    ],
    'hoodie' => [
        'title' => 'Soft Minimalist Lounge Hoodie',
        'parent_cat' => 'Essentials',
        'sub_cat' => 'Loungewear',
        'price' => 160.00,
        'image' => 'https://images.unsplash.com/photo-1516826957135-700dedea698c?auto=format&fit=crop&w=600&q=80'
    ],
];

$catalog_db = [];
foreach ($catalog as $slug => $item) {
    $catalog_db[$slug] = \App\Models\Product::getOrCreateId(
        $slug,
        $item['title'],
        'Accessories Studio',
        $item['sub_cat'],
        $item['price'],
        $item['image']
    );
}

// Ensure 'overshirt' exists as it is referenced in the grid but not in the default catalog array
if (!isset($catalog_db['overshirt'])) {
    $catalog_db['overshirt'] = \App\Models\Product::getOrCreateId(
        'overshirt',
        'Voluminous Cotton Overshirt',
        'Accessories Studio',
        'Shirts',
        140.00,
        'https://images.pexels.com/photos/2703202/pexels-photo-2703202.jpeg?auto=compress&cs=tinysrgb&w=600'
    );
}

$wishlist_status = [];
if (auth()->check()) {
    $wishlist_status = \App\Models\Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray();
}
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($pageSeo))
        <title>{{ $pageSeo->meta_title ?? 'Accessories | Gurunanak Cloth House' }}</title>
        <meta name="description" content="{{ $pageSeo->meta_description ?? 'Leather bags, sunglasses, scarves, and daily essentials.' }}">
        @if(!empty($pageSeo->meta_keywords))
            <meta name="keywords" content="{{ $pageSeo->meta_keywords }}">
        @endif
        <meta property="og:title" content="{{ $pageSeo->og_title ?? $pageSeo->meta_title }}">
        <meta property="og:description" content="{{ $pageSeo->og_description ?? $pageSeo->meta_description }}">
        @if(!empty($pageSeo->og_image))
            <meta property="og:image" content="{{ $pageSeo->og_image }}">
        @endif
    @else
        <title>Accessories | Gurunanak Cloth House</title>
    @endif

    <!-- Google Fonts Optimization for Editorial Readability -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v3 Play CDN for dynamic luxury theme compilation -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        brand: ['Montserrat', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fcfbf9; /* Soothing Warm Pearl tone to eliminate eye-straining pure white glare */
            color: #1c1917; /* Gentle Dark Charcoal tone for sharp readability without visual stress */
        }
        .font-brand {
            font-family: 'Montserrat', sans-serif;
        }
        /* Soft Motion transitions */
        .motion-soft {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        /* Hide scrollbar for premium aesthetic grids while keeping functionality */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Smooth Infinite Loop Marquee */
        @keyframes smoothMarquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: smoothMarquee 28s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#f5efe6] selection:text-[#8b7355] overflow-x-hidden text-[#1c1917] bg-[#fcfbf9]">

    @include('partials.header')

    <!-- Catalog Header Studio Banner -->
    <section class="bg-[#f5efe6]/40 py-12 border-b border-[#eae4d8]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 text-center max-w-2xl mx-auto space-y-3">
            <span class="text-[11px] uppercase tracking-[0.25em] text-[#8b7355] font-semibold block">Everyday Accents</span>
            <h1 class="font-brand text-3xl sm:text-4xl text-[#1c1917] font-normal tracking-tight">Accessories</h1>
            <p class="text-xs text-[#786451] font-light max-w-lg mx-auto leading-relaxed">
                Leather bags, sunglasses, scarves, and everyday items to complete your outfit.
            </p>

            <!-- Inline Category Tabs Strip -->
            <div class="pt-6 flex flex-wrap justify-center gap-2 sm:gap-4 text-xs font-brand uppercase tracking-wider text-[#786451]">
                <span onclick="filterCollection('all')" id="btn-cat-all" class="px-4 py-1.5 bg-[#1c1917] text-white border border-[#1c1917] cursor-pointer font-medium transition-all">All Items</span>
                <span onclick="filterCollection('handbags')" id="btn-cat-handbags" class="px-4 py-1.5 bg-white border border-[#eae4d8] hover:border-[#8b7355] hover:text-[#1c1917] cursor-pointer motion-soft">Handbags</span>
                <span onclick="filterCollection('eyewear')" id="btn-cat-eyewear" class="px-4 py-1.5 bg-white border border-[#eae4d8] hover:border-[#8b7355] hover:text-[#1c1917] cursor-pointer motion-soft">Eyewear</span>
                <span onclick="filterCollection('scarves')" id="btn-cat-scarves" class="px-4 py-1.5 bg-white border border-[#eae4d8] hover:border-[#8b7355] hover:text-[#1c1917] cursor-pointer motion-soft">Scarves</span>
            </div>
        </div>
    </section>

    <!-- Dynamic Catalog Grid -->
    <section class="py-12 sm:py-16 max-w-7xl mx-auto px-6 sm:px-8">
        
        <!-- Results Bar -->
        <div class="flex justify-between items-center pb-8 border-b border-[#f3f4f6] text-xs text-[#786451]">
            <span>Showing <strong id="visible-results-count">8 items</strong></span>
            <div class="flex items-center gap-2">
                <span>Sort By:</span>
                <select class="bg-transparent border-none font-medium text-[#1c1917] focus:ring-0 cursor-pointer">
                    <option>Editorial Selection</option>
                    <option>Price: High to Low</option>
                    <option>Price: Low to High</option>
                    <option>Newest Additions</option>
                </select>
            </div>
        </div>

        <!-- Product Grid Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 pt-8">
            
            <!-- Item 1 -->
            <a href="{{ route('product.detail', 'coat') }}" data-category="handbags" class="product-card group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500">
                <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                    <img src="https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Structured Grain Handbag" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                    <div class="absolute inset-x-0 top-0 p-2 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1.5 pointer-events-none">
                        <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold shadow-sm">OS</span>
                    </div>
                    <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db['coat'] ?? 0).'/toggle') }}';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">
                        <svg class="w-3.5 h-3.5 {{ in_array($catalog_db['coat'] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                        <button onclick="event.preventDefault(); executeDirectCartAddition('coat', 'Structured Grain Handbag', 380.00, 'https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=600', 'OS')" class="w-full py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-[#8b7355] block mb-1">Leather Goods</span>
                        <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors">Structured Grain Handbag</h3>
                    </div>
                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">$380.00</span>
                </div>
            </a>

            <!-- Item 2 -->
            <a href="{{ route('product.detail', 'blazer') }}" data-category="eyewear" class="product-card group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500">
                <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                    <img src="https://images.pexels.com/photos/1926769/pexels-photo-1926769.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Minimalist Core Eyewear" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                    <div class="absolute inset-x-0 top-0 p-2 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1.5 pointer-events-none">
                        <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold shadow-sm">OS</span>
                    </div>
                    <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db['blazer'] ?? 0).'/toggle') }}';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">
                        <svg class="w-3.5 h-3.5 {{ in_array($catalog_db['blazer'] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                        <button onclick="event.preventDefault(); executeDirectCartAddition('blazer', 'Minimalist Core Eyewear', 165.00, 'https://images.pexels.com/photos/1926769/pexels-photo-1926769.jpeg?auto=compress&cs=tinysrgb&w=600', 'OS')" class="w-full py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-[#8b7355] block mb-1">Eyewear</span>
                        <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors">Minimalist Core Eyewear</h3>
                    </div>
                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">$165.00</span>
                </div>
            </a>

            <!-- Item 3 -->
            <a href="{{ route('product.detail', 'dress') }}" data-category="handbags" class="product-card group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500">
                <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                    <img src="https://images.pexels.com/photos/322207/pexels-photo-322207.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Sculptured Minimalist Tote" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                    <div class="absolute inset-x-0 top-0 p-2 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1.5 pointer-events-none">
                        <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold shadow-sm">OS</span>
                    </div>
                    <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db['dress'] ?? 0).'/toggle') }}';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">
                        <svg class="w-3.5 h-3.5 {{ in_array($catalog_db['dress'] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                        <button onclick="event.preventDefault(); executeDirectCartAddition('dress', 'Sculptured Minimalist Tote', 290.00, 'https://images.pexels.com/photos/322207/pexels-photo-322207.jpeg?auto=compress&cs=tinysrgb&w=600', 'OS')" class="w-full py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-[#8b7355] block mb-1">Leather Goods</span>
                        <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors">Sculptured Minimalist Tote</h3>
                    </div>
                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">$290.00</span>
                </div>
            </a>

            <!-- Item 4 -->
            <a href="{{ route('product.detail', 'trench') }}" data-category="eyewear" class="product-card group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500">
                <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                    <img src="https://images.pexels.com/photos/934673/pexels-photo-934673.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Acetate Round Frames" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                    <div class="absolute inset-x-0 top-0 p-2 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1.5 pointer-events-none">
                        <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold shadow-sm">OS</span>
                    </div>
                    <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db['trench'] ?? 0).'/toggle') }}';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">
                        <svg class="w-3.5 h-3.5 {{ in_array($catalog_db['trench'] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                        <button onclick="event.preventDefault(); executeDirectCartAddition('trench', 'Acetate Round Frames', 145.00, 'https://images.pexels.com/photos/934673/pexels-photo-934673.jpeg?auto=compress&cs=tinysrgb&w=600', 'OS')" class="w-full py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-[#8b7355] block mb-1">Eyewear</span>
                        <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors">Acetate Round Frames</h3>
                    </div>
                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">$145.00</span>
                </div>
            </a>

            <!-- Item 5 -->
            <a href="{{ route('product.detail', 'knitwear') }}" data-category="handbags" class="product-card group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500">
                <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                    <img src="https://images.pexels.com/photos/1152077/pexels-photo-1152077.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Handcrafted Satchel Bag" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                    <div class="absolute inset-x-0 top-0 p-2 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1.5 pointer-events-none">
                        <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold shadow-sm">OS</span>
                    </div>
                    <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db['knitwear'] ?? 0).'/toggle') }}';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">
                        <svg class="w-3.5 h-3.5 {{ in_array($catalog_db['knitwear'] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                        <button onclick="event.preventDefault(); executeDirectCartAddition('knitwear', 'Handcrafted Satchel Bag', 210.00, 'https://images.pexels.com/photos/1152077/pexels-photo-1152077.jpeg?auto=compress&cs=tinysrgb&w=600', 'OS')" class="w-full py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-[#8b7355] block mb-1">Leather Goods</span>
                        <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors">Handcrafted Satchel Bag</h3>
                    </div>
                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">$210.00</span>
                </div>
            </a>

            <!-- Item 6 -->
            <a href="{{ route('product.detail', 'blouse') }}" data-category="handbags" class="product-card group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500">
                <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                    <img src="https://images.pexels.com/photos/248077/pexels-photo-248077.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Minimal Pocket Clutch" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                    <div class="absolute inset-x-0 top-0 p-2 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1.5 pointer-events-none">
                        <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold shadow-sm">OS</span>
                    </div>
                    <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db['blouse'] ?? 0).'/toggle') }}';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">
                        <svg class="w-3.5 h-3.5 {{ in_array($catalog_db['blouse'] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                        <button onclick="event.preventDefault(); executeDirectCartAddition('blouse', 'Minimal Pocket Clutch', 115.00, 'https://images.pexels.com/photos/248077/pexels-photo-248077.jpeg?auto=compress&cs=tinysrgb&w=600', 'OS')" class="w-full py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-[#8b7355] block mb-1">Small Leather</span>
                        <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors">Minimal Pocket Clutch</h3>
                    </div>
                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">$115.00</span>
                </div>
            </a>

            <!-- Item 7 -->
            <a href="{{ route('product.detail', 'crewneck') }}" data-category="scarves" class="product-card group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500">
                <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                    <img src="https://images.pexels.com/photos/3731256/pexels-photo-3731256.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Silk Patterned Hair Scarf" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                    <div class="absolute inset-x-0 top-0 p-2 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1.5 pointer-events-none">
                        <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold shadow-sm">OS</span>
                    </div>
                    <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db['crewneck'] ?? 0).'/toggle') }}';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">
                        <svg class="w-3.5 h-3.5 {{ in_array($catalog_db['crewneck'] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                        <button onclick="event.preventDefault(); executeDirectCartAddition('crewneck', 'Silk Patterned Hair Scarf', 65.00, 'https://images.pexels.com/photos/3731256/pexels-photo-3731256.jpeg?auto=compress&cs=tinysrgb&w=600', 'OS')" class="w-full py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-[#8b7355] block mb-1">Scarves</span>
                        <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors">Silk Patterned Hair Scarf</h3>
                    </div>
                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">$65.00</span>
                </div>
            </a>

            <!-- Item 8 -->
            <a href="{{ route('product.detail', 'overshirt') }}" data-category="handbags" class="product-card group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500">
                <div class="aspect-[3/4] overflow-hidden bg-[#f5efe6] relative mb-3">
                    <img src="https://images.pexels.com/photos/1374910/pexels-photo-1374910.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Chic Daily Companion Set" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                    <div class="absolute inset-x-0 top-0 p-2 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1.5 pointer-events-none">
                        <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold shadow-sm">OS</span>
                    </div>
                    <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db['overshirt'] ?? 0).'/toggle') }}';" class="absolute top-2.5 right-2.5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft" aria-label="Add to Wishlist">
                        <svg class="w-3.5 h-3.5 {{ in_array($catalog_db['overshirt'] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                        <button onclick="event.preventDefault(); executeDirectCartAddition('overshirt', 'Chic Daily Companion Set', 185.00, 'https://images.pexels.com/photos/1374910/pexels-photo-1374910.jpeg?auto=compress&cs=tinysrgb&w=600', 'OS')" class="w-full py-2.5 bg-[#1c1917] text-white text-[10px] font-brand uppercase tracking-widest font-semibold hover:bg-[#8b7355] shadow-md motion-soft">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                    <div>
                        <span class="text-[9px] uppercase tracking-widest text-[#8b7355] block mb-1">Gift Set</span>
                        <h3 class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors">Chic Daily Companion Set</h3>
                    </div>
                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-2 block">$185.00</span>
                </div>
            </a>

        </div>

        <!-- Custom Pagination Strip Simulation -->
        <div class="pt-12 flex items-center justify-center gap-2 font-brand text-xs font-medium">
            <span class="w-8 h-8 flex items-center justify-center bg-[#1c1917] text-white cursor-default shadow-sm">1</span>
            <span onclick="alert('Navigating to Page 2')" class="w-8 h-8 flex items-center justify-center bg-white border border-[#eae4d8] text-[#786451] hover:border-[#1c1917] hover:text-[#1c1917] cursor-pointer motion-soft">2</span>
            <span onclick="alert('Navigating to Next Page')" class="px-3 h-8 flex items-center justify-center bg-white border border-[#eae4d8] text-[#786451] hover:border-[#1c1917] hover:text-[#1c1917] cursor-pointer motion-soft">Next →</span>
        </div>

    </section>

    <!-- 12. Footer -->
    <footer id="footer" class="bg-white pt-12 pb-10 border-t border-[#f3f4f6]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-10 pb-12 border-b border-[#f3f4f6]">
                <!-- Col 1: Branding -->
                <div class="col-span-2 space-y-4 pr-4">
                    @if(($settings['footer_logo_type'] ?? 'text') === 'image' && !empty($settings['footer_logo_image']))
                        <img src="{{ asset('storage/' . $settings['footer_logo_image']) }}" alt="{{ $settings['footer_logo_text'] ?? 'GURUNANAK' }}" class="h-8 w-auto object-contain">
                    @else
                        <span class="font-brand font-bold text-base tracking-[0.2em] text-[#292524] block">
                            {{ $settings['footer_logo_text'] ?? 'GURUNANAK' }}
                        </span>
                    @endif
                    <p class="text-xs text-[#786451] font-light max-w-sm leading-relaxed">
                        A premium fashion brand creating clean, simple, and elegant clothing designed for everyday comfort and ultimate modern beauty.
                    </p>
                    @if(!empty($settings['footer_qr_code']))
                        <div class="pt-1">
                            <span class="text-[9px] uppercase tracking-widest text-[#786451] block mb-1 font-bold">Scan to Connect</span>
                            <div class="w-16 h-16 bg-white p-1 border border-[#eae4d8] rounded-lg shadow-xs">
                                <img src="{{ asset('storage/' . $settings['footer_qr_code']) }}" alt="Contact QR Code" class="w-full h-full object-contain">
                            </div>
                        </div>
                    @endif
                    <div class="pt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs font-brand uppercase tracking-wider text-[#8b7355]">
                        @php
                            $socialLinks = [];
                            foreach(['instagram' => 'Insta', 'facebook' => 'Facebook', 'twitter' => 'Twitter', 'pinterest' => 'Pinterest', 'youtube' => 'Youtube', 'linkedin' => 'LinkedIn', 'tiktok' => 'TikTok'] as $key => $label) {
                                $url = $settings[$key . '_url'] ?? null;
                                if (!empty($url) && $url !== '#') {
                                    $socialLinks[] = '<a href="' . e($url) . '" target="_blank" class="hover:underline">' . e($label) . '</a>';
                                }
                            }
                            if (empty($socialLinks)) {
                                $socialLinks[] = '<a href="#" class="hover:underline">Insta</a>';
                                $socialLinks[] = '<a href="#" class="hover:underline">Twitter</a>';
                                $socialLinks[] = '<a href="#" class="hover:underline">Pinterest</a>';
                            }
                        @endphp
                        {!! implode(' <span class="text-[#e5e7eb] select-none">|</span> ', $socialLinks) !!}
                    </div>
                    @include('partials.sales-channels')
                </div>

                @include('partials.footer-links')
                <div class="space-y-3">
                    <h5 class="font-brand text-xs uppercase tracking-widest font-semibold text-[#1c1917]">Client Support</h5>
                    <div class="text-xs text-[#475569] space-y-2">
                        <p>Email Us:<br><strong class="text-[#1c1917] font-semibold">support@gurunanak.com</strong></p>
                        <p>Working Hours:<br>Mon - Fri, 09:00 - 17:00</p>
                        <div class="pt-1">
                            <a href="{{ route('admin.login') }}" class="text-[10px] text-[#9a3412] font-brand uppercase tracking-wider font-semibold hover:underline block">🔒 Admin Access</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-[11px] text-[#475569]">
                <p>© {{ date('Y') }} GURUNANAK Fashion Group. Designed with passion for a premium online shopping experience.</p>
                <div class="flex items-center gap-3 text-[10px] font-brand uppercase tracking-widest text-[#1c1917] font-medium">
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Visa</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Mastercard</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Amex</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">ApplePay</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bespoke Floating Concierge Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-[#9a3412] to-[#8b7355] rounded-full blur opacity-75 group-hover:opacity-100 transition duration-500 animate-pulse"></div>
            <button onclick="alert('Hello! How can our stylist help you find the finest curated accessories today?')" class="relative flex items-center gap-2.5 bg-[#1c1917] text-white px-5 py-3.5 rounded-full shadow-2xl border border-[#eae4d8]/40 hover:bg-[#292524] transition-all duration-300">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#f5efe6] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#eae4d8]"></span>
                </span>
                <span class="font-brand text-[10px] font-bold uppercase tracking-[0.2em]">Chat with Stylist</span>
                <svg class="w-3.5 h-3.5 text-[#f5efe6]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </button>
        </div>
    </div>

    <!-- MASTER PERSISTENT CART DRAWER MODULE (SLIDE-OVER) -->
    <div id="bag-backdrop" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-[100] hidden transition-opacity duration-300 opacity-0" onclick="toggleShoppingBagDrawer()"></div>
    
    <div id="bag-drawer" class="fixed top-0 right-0 bottom-0 w-full max-w-md bg-white z-[101] shadow-2xl translate-x-full transition-transform duration-500 ease-out flex flex-col border-l border-[#eae4d8]">
        
        <!-- Drawer Header -->
        <div class="p-5 bg-[#fdfbf7] border-b border-[#eae4d8] flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-[#8b7355]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span class="font-brand text-xs font-bold uppercase tracking-widest text-[#1c1917]">Shopping Bag</span>
                <span id="drawer-qty-badge" class="text-[10px] bg-[#8b7355] text-white px-2 py-0.5 font-bold">0</span>
            </div>
            <button onclick="toggleShoppingBagDrawer()" class="text-xs font-bold text-[#a08a75] hover:text-[#1c1917] p-1 uppercase tracking-wider">✕ Close</button>
        </div>

        <!-- Drawer Line Items Wrap -->
        <div id="bag-items-wrapper" class="flex-1 overflow-y-auto p-5 divide-y divide-[#eae4d8]/60">
            <!-- Rendered live via Javascript engine -->
        </div>

        <!-- Drawer Footer Summary -->
        <div class="p-5 border-t border-[#eae4d8] bg-[#fdfbf7] space-y-4">
            <div class="space-y-1.5 text-xs">
                <div class="flex justify-between text-[#786451]">
                    <span>Subtotal</span>
                    <span id="drawer-subtotal" class="font-brand font-semibold text-[#1c1917]">$0.00</span>
                </div>
                <div class="flex justify-between text-[#786451]">
                    <span>Standard Shipping</span>
                    <span class="text-[#8b7355] italic">Complimentary</span>
                </div>
                <div class="flex justify-between text-[#1c1917] font-bold text-sm pt-2 border-t border-[#eae4d8]/40">
                    <span>Estimated Total</span>
                    <span id="drawer-total" class="font-brand text-[#9a3412]">$0.00</span>
                </div>
            </div>

            <div class="space-y-2 pt-2">
                <a href="{{ route('checkout.index') }}" class="w-full py-3.5 bg-[#1c1917] text-white font-brand text-xs font-bold uppercase tracking-[0.15em] hover:bg-[#8b7355] transition-colors shadow-md block text-center">
                    Proceed to Checkout
                </a>
                <button onclick="toggleShoppingBagDrawer()" class="w-full py-2 bg-transparent text-[#786451] hover:text-[#1c1917] font-brand text-[11px] font-semibold uppercase tracking-wider text-center block">
                    Continue Shopping
                </button>
            </div>
        </div>

    </div>

    <!-- Master Autocomplete Search & Storage Hooks -->
    <script>
        const globalCatalogJS = @json($catalog);
        const CART_STORAGE_KEY = 'gurunanak_bespoke_bag';

        function getClientBag() {
            try {
                const raw = localStorage.getItem(CART_STORAGE_KEY);
                return raw ? JSON.parse(raw) : [];
            } catch(e) {
                return [];
            }
        }

        function saveClientBag(bag) {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(bag));
            renderShoppingBagState();
        }

        function executeDirectCartAddition(id, title, price, img, fallbackSize = 'OS', fallbackColor = 'Atelier Selection') {
            const bag = getClientBag();
            const existingIdx = bag.findIndex(item => item.id === id && item.size === fallbackSize && item.color === fallbackColor);
            
            if (existingIdx > -1) {
                bag[existingIdx].qty += 1;
            } else {
                bag.push({
                    id: id,
                    title: title,
                    price: parseFloat(price),
                    image: img,
                    size: fallbackSize,
                    color: fallbackColor,
                    qty: 1
                });
            }

            saveClientBag(bag);
            toggleShoppingBagDrawer(true);
        }

        function updateBagQty(index, delta) {
            const bag = getClientBag();
            if(bag[index]) {
                bag[index].qty += delta;
                if(bag[index].qty <= 0) {
                    bag.splice(index, 1);
                }
                saveClientBag(bag);
            }
        }

        function removeFromBag(index) {
            const bag = getClientBag();
            if(bag[index]) {
                bag.splice(index, 1);
                saveClientBag(bag);
            }
        }

        function toggleShoppingBagDrawer(forceOpen = false) {
            const backdrop = document.getElementById('bag-backdrop');
            const drawer = document.getElementById('bag-drawer');

            const isClosed = drawer.classList.contains('translate-x-full');
            
            if (isClosed || forceOpen) {
                renderShoppingBagState();
                backdrop.classList.remove('hidden');
                setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
                drawer.classList.remove('translate-x-full');
            } else {
                backdrop.classList.add('opacity-0');
                drawer.classList.add('translate-x-full');
                setTimeout(() => backdrop.classList.add('hidden'), 300);
            }
        }

        function renderShoppingBagState() {
            const bag = getClientBag();
            const wrapper = document.getElementById('bag-items-wrapper');
            const counterPill = document.getElementById('bag-counter-pill');
            const headerPill = document.getElementById('bag-header-pill');
            const drawerBadge = document.getElementById('drawer-qty-badge');
            const subtotalNode = document.getElementById('drawer-subtotal');
            const totalNode = document.getElementById('drawer-total');

            const totalQty = bag.reduce((sum, item) => sum + parseInt(item.qty), 0);
            const totalPrice = bag.reduce((sum, item) => sum + (parseFloat(item.price) * parseInt(item.qty)), 0);

            if(counterPill) counterPill.innerText = totalQty;
            if(headerPill) headerPill.innerText = totalQty;
            if(drawerBadge) drawerBadge.innerText = totalQty + ' pieces';
            if(subtotalNode) subtotalNode.innerText = '$' + totalPrice.toFixed(2);
            if(totalNode) totalNode.innerText = '$' + totalPrice.toFixed(2);

            if(bag.length === 0) {
                wrapper.innerHTML = `
                    <div class="py-16 text-center space-y-3">
                        <div class="w-12 h-12 rounded-full bg-[#f5efe6] flex items-center justify-center mx-auto text-[#8b7355]">
                            <svg class="w-5 h-5 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <p class="font-brand text-xs uppercase tracking-wider text-[#1c1917] font-semibold">Your Shopping Bag is Empty</p>
                        <p class="text-[11px] text-[#786451] max-w-xs mx-auto">Browse our collections and add items to your bag.</p>
                    </div>
                `;
                return;
            }

            let html = '';
            bag.forEach((item, idx) => {
                html += `
                    <div class="flex items-start gap-4 py-4 group">
                        <img src="${item.image}" alt="${item.title}" class="w-16 h-20 object-cover object-top border border-[#eae4d8] shrink-0 bg-[#f5efe6]">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-semibold text-[#1c1917] truncate leading-tight">${item.title}</h4>
                            <div class="text-[10px] text-[#8b7355] mt-1 space-x-1">
                                <span>Size: <strong class="text-[#1c1917] font-bold uppercase">${item.size}</strong></span>
                                <span class="text-[#eae4d8]">|</span>
                                <span>Color: <strong class="text-[#1c1917] font-medium">${item.color}</strong></span>
                            </div>
                            
                            <div class="flex items-center justify-between mt-3 pt-1">
                                <div class="inline-flex items-center border border-[#eae4d8] bg-white">
                                    <button onclick="updateBagQty(${idx}, -1)" class="px-2 py-0.5 text-[#786451] hover:bg-[#f5efe6] text-xs font-bold transition-colors">-</button>
                                    <span class="px-2 text-xs font-brand font-bold text-[#1c1917] min-w-[20px] text-center">${item.qty}</span>
                                    <button onclick="updateBagQty(${idx}, 1)" class="px-2 py-0.5 text-[#786451] hover:bg-[#f5efe6] text-xs font-bold transition-colors">+</button>
                                 </div>
                                <span class="font-brand text-xs font-bold text-[#9a3412]">$${(parseFloat(item.price) * parseInt(item.qty)).toFixed(2)}</span>
                            </div>
                        </div>
                        <button onclick="removeFromBag(${idx})" class="text-[#a08a75] hover:text-[#9a3412] p-1 font-bold shrink-0 transition-colors" title="Remove item">✕</button>
                    </div>
                `;
            });

            wrapper.innerHTML = html;
        }

        function triggerCheckoutPhotoAutocomplete(query) {
            const container = document.getElementById('predictive-search-dropdown');
            const queryClean = query.toLowerCase().trim();

            if (queryClean.length === 0) {
                container.classList.add('hidden');
                return;
            }

            let resultsHTML = '';
            let matchesFound = 0;

            for (const key in globalCatalogJS) {
                const item = globalCatalogJS[key];
                const matchString = (item.title + ' ' + item.parent_cat + ' ' + item.sub_cat).toLowerCase();
                
                if (matchString.includes(queryClean)) {
                    matchesFound++;
                    resultsHTML += `
                        <a href="{{ route('product.detail', '') }}/${key}" class="flex items-center gap-3 p-2.5 hover:bg-[#f5efe6]/70 transition-colors block text-left group">
                            <img src="${item.image}" alt="${item.title}" class="w-10 h-11 object-cover object-top shrink-0 border border-[#eae4d8]">
                            <div class="min-w-0 flex-1">
                                <div class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] truncate transition-colors">
                                    ${item.title}
                                </div>
                                <div class="text-[10px] text-[#8b7355] font-brand font-bold mt-0.5 flex items-center gap-1.5">
                                    <span>$${parseFloat(item.price).toFixed(2)}</span>
                                    <span class="text-[#eae4d8]">|</span>
                                    <span class="uppercase tracking-wider text-[9px] text-[#a08a75] font-medium">${item.parent_cat} • ${item.sub_cat}</span>
                                </div>
                            </div>
                            <span class="text-[10px] text-[#8b7355] font-bold opacity-0 group-hover:opacity-100 transition-opacity shrink-0 pr-1">▸ View</span>
                        </a>
                    `;
                }
            }

            if (matchesFound > 0) {
                container.innerHTML = resultsHTML;
                container.classList.remove('hidden');
            } else {
                container.innerHTML = `
                    <div class="p-3 text-center text-xs text-[#a08a75] italic">
                        No real image profiles matched "${query}".
                    </div>
                `;
                container.classList.remove('hidden');
            }
        }

        document.addEventListener('click', (e) => {
            const wrap = document.getElementById('header-search-container');
            if (wrap && !wrap.contains(e.target)) {
                const drop = document.getElementById('predictive-search-dropdown');
                if (drop) drop.classList.add('hidden');
            }
        });

        function filterCollection(cat) {
            const cards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const itemCat = card.getAttribute('data-category');
                if (cat === 'all' || itemCat === cat) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const countEl = document.getElementById('visible-results-count');
            if (countEl) {
                countEl.innerText = visibleCount + (visibleCount === 1 ? ' Premium Piece' : ' Premium Pieces');
            }

            // Update tab button visual state
            const buttons = ['all', 'handbags', 'eyewear', 'scarves'];
            buttons.forEach(b => {
                const btn = document.getElementById('btn-cat-' + b);
                if (btn) {
                    if (b === cat) {
                        btn.className = "px-4 py-1.5 bg-[#1c1917] text-white border border-[#1c1917] cursor-pointer font-medium transition-all";
                    } else {
                        btn.className = "px-4 py-1.5 bg-white border border-[#eae4d8] hover:border-[#8b7355] hover:text-[#1c1917] cursor-pointer motion-soft";
                    }
                }
            });
        }

        function syncHeaderBagCounter() {
            renderShoppingBagState();
        }

        window.addEventListener('DOMContentLoaded', () => {
            syncHeaderBagCounter();
        });
    </script>
</body>
</html>
