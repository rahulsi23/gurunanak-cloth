@php
// Complete Catalog array mapped with rich categorization matrices and image attributes
$catalog = [
    'coat' => [
        'title' => 'Double Breasted Minimalist Wool Coat',
        'parent_cat' => 'women',
        'sub_cat' => 'outerwear',
        'sub_sub_cat' => 'coats',
        'price' => 380.00,
        'old_price' => '$450.00',
        'color' => 'camel',
        'color_name' => 'Rich Camel',
        'size' => ['xs', 's', 'm', 'l'],
        'image' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80',
        'badge' => 'Bespoke Atelier'
    ],
    'blouse' => [
        'title' => 'Refined Raw Silk Drape Blouse',
        'parent_cat' => 'women',
        'sub_cat' => 'apparel',
        'sub_sub_cat' => 'blouses',
        'price' => 145.00,
        'old_price' => '$185.00',
        'color' => 'pearl',
        'color_name' => 'Raw Off-White',
        'size' => ['xs', 's', 'm'],
        'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=600&q=80',
        'badge' => 'Pure Mulberry Silk'
    ],
    'dress' => [
        'title' => 'Sleek Minimalist Column Dress',
        'parent_cat' => 'women',
        'sub_cat' => 'apparel',
        'sub_sub_cat' => 'dresses',
        'price' => 240.00,
        'old_price' => '$295.00',
        'color' => 'charcoal',
        'color_name' => 'Obsidian Black',
        'size' => ['xs', 's', 'm'],
        'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=600&q=80',
        'badge' => 'Runway Editorial'
    ],
    'trousers' => [
        'title' => 'Wide Leg Pleated Woolen Trousers',
        'parent_cat' => 'women',
        'sub_cat' => 'tailoring',
        'sub_sub_cat' => 'bottoms',
        'price' => 195.00,
        'old_price' => '$240.00',
        'color' => 'charcoal',
        'color_name' => 'Slate Grey',
        'size' => ['s', 'm', 'l', 'xl'],
        'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=600&q=80',
        'badge' => 'Structured'
    ],
    'knitwear' => [
        'title' => 'Cashmere Blend Minimalist Knitwear',
        'parent_cat' => 'men',
        'sub_cat' => 'knitwear',
        'sub_sub_cat' => 'sweaters',
        'price' => 210.00,
        'old_price' => '$260.00',
        'color' => 'pearl',
        'color_name' => 'Oatmeal Pearl',
        'size' => ['s', 'm', 'l'],
        'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
        'badge' => 'Client Favorite'
    ],
    'crewneck' => [
        'title' => 'Minimalist Core Ribbed Crewneck',
        'parent_cat' => 'men',
        'sub_cat' => 'knitwear',
        'sub_sub_cat' => 'basics',
        'price' => 110.00,
        'old_price' => '$140.00',
        'color' => 'sage',
        'color_name' => 'Warm Sage',
        'size' => ['xs', 's', 'm', 'l', 'xl'],
        'image' => 'https://images.unsplash.com/photo-1516762689617-e1cffcef479d?auto=format&fit=crop&w=600&q=80',
        'badge' => 'Organic Blend'
    ],
    'blazer' => [
        'title' => 'Tailored Mid-Weight Woolen Blazer',
        'parent_cat' => 'men',
        'sub_cat' => 'tailoring',
        'sub_sub_cat' => 'blazers',
        'price' => 420.00,
        'old_price' => '$490.00',
        'color' => 'charcoal',
        'color_name' => 'Deep Charcoal',
        'size' => ['s', 'm', 'l', 'xl'],
        'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=600&q=80',
        'badge' => 'Limited Loom'
    ],
    'trench' => [
        'title' => 'Beige Signature Structural Trench',
        'parent_cat' => 'men',
        'sub_cat' => 'outerwear',
        'sub_sub_cat' => 'coats',
        'price' => 290.00,
        'old_price' => '$360.00',
        'color' => 'camel',
        'color_name' => 'Classic Sand',
        'size' => ['s', 'm', 'l'],
        'image' => 'https://images.unsplash.com/photo-1554412933-514a83d2f3c8?auto=format&fit=crop&w=600&q=80',
        'badge' => 'All Weather'
    ],
    'hoodie' => [
        'title' => 'Soft Minimalist Lounge Hoodie',
        'parent_cat' => 'essentials',
        'sub_cat' => 'loungewear',
        'sub_sub_cat' => 'hoodies',
        'price' => 160.00,
        'old_price' => '$195.00',
        'color' => 'blue',
        'color_name' => 'Deep Navy',
        'size' => ['s', 'm', 'l', 'xl'],
        'image' => 'https://images.unsplash.com/photo-1516826957135-700dedea698c?auto=format&fit=crop&w=600&q=80',
        'badge' => 'Ultra Soft Heavyweight'
    ],
];

$catalog_db = [];
foreach ($catalog as $slug => $item) {
    $catalog_db[$slug] = \App\Models\Product::getOrCreateId(
        $slug,
        $item['title'],
        ucfirst($item['parent_cat']),
        ucfirst($item['sub_cat']),
        $item['price'],
        $item['image']
    );
}

$wishlist_status = [];
if (auth()->check()) {
    $wishlist_status = \App\Models\Wishlist::where('user_id', auth()->id())
        ->whereIn('product_id', array_values($catalog_db))
        ->pluck('product_id')
        ->toArray();
}
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(isset($pageSeo))
        <title>{{ $pageSeo->meta_title ?? 'Shop All Collections | Gurunanak Cloth House' }}</title>
        <meta name="description" content="{{ $pageSeo->meta_description ?? 'Browse our complete collection of men\'s, women\'s, and seasonal clothing, crafted with natural fabrics and comfortable fits.' }}">
        @if(!empty($pageSeo->meta_keywords))
            <meta name="keywords" content="{{ $pageSeo->meta_keywords }}">
        @endif
        <meta property="og:title" content="{{ $pageSeo->og_title ?? $pageSeo->meta_title }}">
        <meta property="og:description" content="{{ $pageSeo->og_description ?? $pageSeo->meta_description }}">
        @if(!empty($pageSeo->og_image))
            <meta property="og:image" content="{{ $pageSeo->og_image }}">
        @endif
    @else
        <title>Shop All Collections | Gurunanak Cloth House</title>
        <meta name="description" content="Browse our complete collection of men's, women's, and seasonal clothing, crafted with natural fabrics and comfortable fits.">
    @endif
    
    <!-- Premium Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS v3 Engine Compiler -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            light: '#f5efe6',
                            accent: '#8b7355',
                            dark: '#292524',
                            muted: '#786451'
                        }
                    },
                    keyframes: {
                        scaleUp: {
                            '0%': { opacity: '0', transform: 'scale(0.97) translateY(10px)' },
                            '100%': { opacity: '1', transform: 'scale(1) translateY(0)' }
                        }
                    },
                    animation: {
                        'grid-render': 'scaleUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fcfbf9;
            color: #1c1917;
        }
        .font-brand { font-family: 'Montserrat', sans-serif; }
        .motion-soft { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Nested guidelines */
        .tree-line-sub { position: relative; }
        .tree-line-sub::before {
            content: ""; position: absolute; left: 0.35rem; top: 0; bottom: 0; width: 1px; background-color: #eae4d8;
        }
        .tree-line-sub-sub { position: relative; }
        .tree-line-sub-sub::before {
            content: ""; position: absolute; left: 1rem; top: 0; bottom: 0; width: 1px; background-color: #eae4d8;
        }

        .tree-link-active {
            color: #9a3412 !important;
            font-weight: 600 !important;
            background-color: #fdfbf7;
            border-right: 2px solid #8b7355;
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
<body class="antialiased selection:bg-[#f5efe6] selection:text-[#8b7355] bg-[#fcfbf9] text-[#1c1917]">

    @include('partials.header')

    <!-- Visual Presentation Heading Banner -->
    <div class="bg-gradient-to-b from-[#fdfbf7] to-white border-b border-[#eae4d8]/60 py-10">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-[11px] font-brand text-[#a08a75] mb-2">
                    <a href="{{ url('/') }}" class="hover:text-[#1c1917]">Home</a>
                    <span>/</span>
                    <span class="text-[#1c1917] font-medium">Shop</span>
                </nav>
                <h1 class="font-brand text-3xl sm:text-4xl text-[#1c1917] font-normal tracking-tight">All Products</h1>
            </div>
            <p class="text-xs text-[#786451] max-w-sm sm:text-right font-light leading-relaxed">
                Browse our full collection of coats, knitwear, trousers, and shirts. Filter by category, color, or price to find what you need.
            </p>
        </div>
    </div>

    <!-- Active Filters Tracker Ribbon Strip -->
    <section class="max-w-7xl mx-auto px-6 sm:px-8 pt-8">
        <div id="active-filters-container" class="hidden items-center flex-wrap gap-2 pb-4 border-b border-[#eae4d8]/40 text-xs">
            <span class="font-brand text-[10px] uppercase tracking-widest text-[#8b7355] font-bold flex items-center gap-1">
                <svg class="w-3 h-3 stroke-[2]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <span>Active Filters:</span>
            </span>
            <div id="chips-area" class="flex flex-wrap items-center gap-1.5">
                <!-- Javascript maps bounds chips dynamically -->
            </div>
            <button onclick="resetFilters()" class="text-[10px] font-brand underline text-[#9a3412] uppercase tracking-wider ml-2 hover:text-[#1c1917] font-semibold">Clear All Filters</button>
        </div>
    </section>

    <!-- Showroom Main Layer -->
    <section class="max-w-7xl mx-auto px-6 sm:px-8 py-6">
        
        <!-- Controls Matrix Strip Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pb-6 border-b border-[#eae4d8]/60 mb-8">
            <div class="flex items-center justify-between sm:justify-start gap-4">
                <button onclick="toggleMobileFilter()" class="lg:hidden flex items-center gap-2 py-2.5 px-4 bg-[#1c1917] text-white font-brand text-xs uppercase tracking-wider shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    <span>Filter Products</span>
                </button>
                <div class="text-xs font-brand text-[#786451] uppercase tracking-wider">
                    Showing <strong id="visible-count" class="text-[#1c1917] font-bold text-sm">{{ count($catalog) }}</strong> items
                </div>
            </div>

            <!-- Mobile Inline Search Autocomplete Module & Sort Alignment -->
            <div class="flex flex-wrap items-center justify-end gap-4 font-brand text-xs w-full sm:w-auto">
                
                <div class="relative w-full sm:w-56 lg:hidden" id="mobile-search-wrapper">
                    <input type="text" 
                           id="mobile-quick-search" 
                           oninput="triggerPhotoAutocomplete(this.value, 'mobile-suggestions')" 
                           onfocus="triggerPhotoAutocomplete(this.value, 'mobile-suggestions')"
                           placeholder="Search products..." 
                           autocomplete="off"
                           class="w-full bg-white border border-[#eae4d8] py-2 pl-3 pr-8 text-xs focus:outline-none focus:border-[#8b7355]">
                    <svg class="w-3.5 h-3.5 absolute right-2.5 top-2.5 text-[#a08a75] pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    
                    <!-- Mobile Suggestions Dropdown Container -->
                    <div id="mobile-suggestions" class="absolute left-0 right-0 top-full mt-1 bg-white border border-[#8b7355]/40 shadow-[0_15px_40px_rgba(0,0,0,0.12)] z-50 hidden max-h-80 overflow-y-auto divide-y divide-[#eae4d8]/60 text-left">
                    </div>
                </div>
                
                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                    <span class="text-[#786451] text-[10px] uppercase tracking-widest hidden sm:inline">Sort:</span>
                    <select id="sort-select" onchange="applyFilters()" class="bg-white border border-[#eae4d8] py-2 px-3 text-[#1c1917] font-medium focus:outline-none focus:border-[#8b7355] text-xs shadow-sm w-full sm:w-auto">
                        <option value="default">Featured</option>
                        <option value="low-high">Price: Low to High</option>
                        <option value="high-low">Price: High to Low</option>
                        <option value="name">Name: A to Z</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Master Showroom Workspace Matrix (12 Columns) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left Side Tier Tree Navigation Console (3 Cols) -->
            <aside id="filter-panel" class="lg:col-span-3 bg-white border border-[#eae4d8]/80 p-5 sticky top-28 hidden lg:block shadow-[0_10px_30px_rgba(139,115,85,0.04)] space-y-7">
                
                <div class="flex items-center justify-between pb-3 border-b border-[#eae4d8]">
                    <span class="font-brand text-xs uppercase tracking-widest text-[#1c1917] font-bold tracking-wider">Filters</span>
                    <button onclick="resetFilters()" class="text-[10px] text-[#8b7355] hover:text-[#9a3412] uppercase tracking-wider font-brand font-medium">Reset All</button>
                </div>

                <!-- 1. Recursive Multi-Tier Category Folder Guides -->
                <div class="space-y-3 pb-3 border-b border-[#eae4d8]/60">
                    <div class="flex items-center justify-between">
                        <label class="font-brand text-xs uppercase tracking-wider text-[#1c1917] font-bold block">Categories</label>
                    </div>

                    <!-- Master Category Tree Container -->
                    <div class="space-y-2 text-xs font-medium text-[#44403c]">
                        
                        <!-- Root Level All Option -->
                        <button onclick="selectCategoryNode('all', 'all', 'all', this)" class="tree-link-node w-full text-left py-1 px-2 hover:bg-[#f5efe6]/40 transition-colors flex items-center justify-between tree-link-active" data-tier="all">
                            <span>All Items</span>
                            <span class="text-[10px] text-[#a08a75]">({{ count($catalog) }})</span>
                        </button>

                        <!-- PARENT 1: WOMEN'S COLLECTION -->
                        <div class="pt-1">
                            <div class="flex items-center justify-between group">
                                <button onclick="selectCategoryNode('women', 'all', 'all', this)" class="tree-link-node text-left py-1 px-2 flex-1 hover:text-[#8b7355] font-semibold text-[#1c1917]" data-tier="parent-women">
                                    <span>▸ Women's Collection</span>
                                </button>
                                <button onclick="toggleSubTree('tree-women', this)" class="px-2 text-base text-[#8b7355] focus:outline-none" title="Fold Layer">− </button>
                            </div>

                            <!-- SUB-TREE WOMEN -->
                            <div id="tree-women" class="tree-line-sub pl-3 space-y-1 pt-1 overflow-hidden transition-all duration-300">
                                
                                <!-- SUBCATEGORY 1: Outerwear -->
                                <div>
                                    <div class="flex items-center justify-between">
                                        <button onclick="selectCategoryNode('women', 'outerwear', 'all', this)" class="tree-link-node text-left py-0.5 px-2 flex-1 hover:text-[#8b7355] text-[11px] text-[#786451]" data-tier="sub-women-outerwear">
                                            <span>↳ Outerwear</span>
                                        </button>
                                        <button onclick="toggleSubTree('tree-women-out', this)" class="px-1 text-xs text-[#a08a75]">▼</button>
                                    </div>
                                    <!-- SUB-SUB: Coats -->
                                    <div id="tree-women-out" class="tree-line-sub-sub pl-4 space-y-0.5 pt-0.5">
                                        <button onclick="selectCategoryNode('women', 'outerwear', 'coats', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-women-outerwear-coats">
                                            <span>• Wool Coats</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- SUBCATEGORY 2: Apparel -->
                                <div class="pt-1">
                                    <div class="flex items-center justify-between">
                                        <button onclick="selectCategoryNode('women', 'apparel', 'all', this)" class="tree-link-node text-left py-0.5 px-2 flex-1 hover:text-[#8b7355] text-[11px] text-[#786451]" data-tier="sub-women-apparel">
                                            <span>↳ Fine Apparel</span>
                                        </button>
                                        <button onclick="toggleSubTree('tree-women-app', this)" class="px-1 text-xs text-[#a08a75]">▼</button>
                                    </div>
                                    <div id="tree-women-app" class="tree-line-sub-sub pl-4 space-y-0.5 pt-0.5">
                                        <button onclick="selectCategoryNode('women', 'apparel', 'blouses', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-women-apparel-blouses">
                                            <span>• Raw Silk Blouses</span>
                                        </button>
                                        <button onclick="selectCategoryNode('women', 'apparel', 'dresses', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-women-apparel-dresses">
                                            <span>• Column Dresses</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- SUBCATEGORY 3: Tailoring -->
                                <div class="pt-1">
                                    <div class="flex items-center justify-between">
                                        <button onclick="selectCategoryNode('women', 'tailoring', 'all', this)" class="tree-link-node text-left py-0.5 px-2 flex-1 hover:text-[#8b7355] text-[11px] text-[#786451]" data-tier="sub-women-tailoring">
                                            <span>↳ Tailoring</span>
                                        </button>
                                        <button onclick="toggleSubTree('tree-women-tail', this)" class="px-1 text-xs text-[#a08a75]">▼</button>
                                    </div>
                                    <div id="tree-women-tail" class="tree-line-sub-sub pl-4 space-y-0.5 pt-0.5">
                                        <button onclick="selectCategoryNode('women', 'tailoring', 'bottoms', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-women-tailoring-bottoms">
                                            <span>• Pleated Bottoms</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- PARENT 2: MEN'S COLLECTION -->
                        <div class="pt-2 border-t border-[#eae4d8]/40">
                            <div class="flex items-center justify-between group">
                                <button onclick="selectCategoryNode('men', 'all', 'all', this)" class="tree-link-node text-left py-1 px-2 flex-1 hover:text-[#8b7355] font-semibold text-[#1c1917]" data-tier="parent-men">
                                    <span>▸ Men's Collection</span>
                                </button>
                                <button onclick="toggleSubTree('tree-men', this)" class="px-2 text-base text-[#8b7355] focus:outline-none">− </button>
                            </div>

                            <div id="tree-men" class="tree-line-sub pl-3 space-y-1 pt-1 overflow-hidden transition-all duration-300">
                                <div>
                                    <div class="flex items-center justify-between">
                                        <button onclick="selectCategoryNode('men', 'knitwear', 'all', this)" class="tree-link-node text-left py-0.5 px-2 flex-1 hover:text-[#8b7355] text-[11px] text-[#786451]" data-tier="sub-men-knitwear">
                                            <span>↳ Knitwear Hub</span>
                                        </button>
                                        <button onclick="toggleSubTree('tree-men-knit', this)" class="px-1 text-xs text-[#a08a75]">▼</button>
                                    </div>
                                    <div id="tree-men-knit" class="tree-line-sub-sub pl-4 space-y-0.5 pt-0.5">
                                        <button onclick="selectCategoryNode('men', 'knitwear', 'sweaters', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-men-knitwear-sweaters">
                                            <span>• Cashmere Sweaters</span>
                                        </button>
                                        <button onclick="selectCategoryNode('men', 'knitwear', 'basics', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-men-knitwear-basics">
                                            <span>• Core Crewnecks</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="pt-1">
                                    <div class="flex items-center justify-between">
                                        <button onclick="selectCategoryNode('men', 'tailoring', 'all', this)" class="tree-link-node text-left py-0.5 px-2 flex-1 hover:text-[#8b7355] text-[11px] text-[#786451]" data-tier="sub-men-tailoring">
                                            <span>↳ Master Tailoring</span>
                                        </button>
                                        <button onclick="toggleSubTree('tree-men-tail', this)" class="px-1 text-xs text-[#a08a75]">▼</button>
                                    </div>
                                    <div id="tree-men-tail" class="tree-line-sub-sub pl-4 space-y-0.5 pt-0.5">
                                        <button onclick="selectCategoryNode('men', 'tailoring', 'blazers', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-men-tailoring-blazers">
                                            <span>• Loom Blazers</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="pt-1">
                                    <div class="flex items-center justify-between">
                                        <button onclick="selectCategoryNode('men', 'outerwear', 'all', this)" class="tree-link-node text-left py-0.5 px-2 flex-1 hover:text-[#8b7355] text-[11px] text-[#786451]" data-tier="sub-men-outerwear">
                                            <span>↳ Technical Coats</span>
                                        </button>
                                        <button onclick="toggleSubTree('tree-men-out', this)" class="px-1 text-xs text-[#a08a75]">▼</button>
                                    </div>
                                    <div id="tree-men-out" class="tree-line-sub-sub pl-4 space-y-0.5 pt-0.5">
                                        <button onclick="selectCategoryNode('men', 'outerwear', 'coats', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-men-outerwear-coats">
                                            <span>• Trench Coats</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- PARENT 3: ESSENTIALS -->
                        <div class="pt-2 border-t border-[#eae4d8]/40">
                            <div class="flex items-center justify-between group">
                                <button onclick="selectCategoryNode('essentials', 'all', 'all', this)" class="tree-link-node text-left py-1 px-2 flex-1 hover:text-[#8b7355] font-semibold text-[#1c1917]" data-tier="parent-essentials">
                                    <span>▸ Capsule Essentials</span>
                                </button>
                                <button onclick="toggleSubTree('tree-essentials', this)" class="px-2 text-base text-[#8b7355] focus:outline-none">− </button>
                            </div>

                            <div id="tree-essentials" class="tree-line-sub pl-3 space-y-1 pt-1 overflow-hidden transition-all duration-300">
                                <div>
                                    <div class="flex items-center justify-between">
                                        <button onclick="selectCategoryNode('essentials', 'loungewear', 'all', this)" class="tree-link-node text-left py-0.5 px-2 flex-1 hover:text-[#8b7355] text-[11px] text-[#786451]" data-tier="sub-essentials-loungewear">
                                            <span>↳ Loungewear Studio</span>
                                        </button>
                                        <button onclick="toggleSubTree('tree-ess-lounge', this)" class="px-1 text-xs text-[#a08a75]">▼</button>
                                    </div>
                                    <div id="tree-ess-lounge" class="tree-line-sub-sub pl-4 space-y-0.5 pt-0.5">
                                        <button onclick="selectCategoryNode('essentials', 'loungewear', 'hoodies', this)" class="tree-link-node w-full text-left py-0.5 px-2 hover:text-[#8b7355] text-[11px] text-[#a08a75]" data-tier="subsub-essentials-loungewear-hoodies">
                                            <span>• Lounge Hoodies</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- 2. Price Filter -->
                <div class="space-y-3 pb-4 border-b border-[#eae4d8]/60">
                    <div class="flex items-center justify-between">
                        <label class="font-brand text-xs uppercase tracking-wider text-[#1c1917] font-bold block">Max Price</label>
                        <span class="text-xs font-brand font-bold text-[#9a3412]" id="price-display">$500</span>
                    </div>

                    <!-- Faux Distribution Bars -->
                    <div class="flex items-end justify-between h-8 px-2 pt-2 gap-1 border-b border-[#eae4d8]/40">
                        <div class="w-full bg-[#f5efe6] h-[20%] rounded-t-xs"></div>
                        <div class="w-full bg-[#eae4d8] h-[45%] rounded-t-xs"></div>
                        <div class="w-full bg-[#8b7355]/40 h-[80%] rounded-t-xs"></div>
                        <div class="w-full bg-[#8b7355] h-[100%] rounded-t-xs"></div>
                        <div class="w-full bg-[#8b7355]/60 h-[70%] rounded-t-xs"></div>
                        <div class="w-full bg-[#eae4d8] h-[30%] rounded-t-xs"></div>
                        <div class="w-full bg-[#f5efe6] h-[15%] rounded-t-xs"></div>
                    </div>

                    <input type="range" id="price-range" min="100" max="500" step="10" value="500" oninput="updatePriceLabel(this.value)" onchange="applyFilters()" class="w-full accent-[#1c1917] cursor-pointer mt-1">
                    <div class="flex justify-between text-[9px] font-brand text-[#a08a75]">
                        <span>$100 Min</span>
                        <span>$500 Max</span>
                    </div>
                </div>

                <!-- 3. Size Scale Selectors -->
                <div class="space-y-3 pb-4 border-b border-[#eae4d8]/60">
                    <div class="flex items-center justify-between">
                        <label class="font-brand text-xs uppercase tracking-wider text-[#1c1917] font-bold block">Size</label>
                        <span class="text-[9px] text-[#a08a75]">Select Multiple</span>
                    </div>

                    <div class="flex flex-wrap gap-1.5 font-brand text-xs">
                        <button onclick="toggleSizeFilter('xs', this)" class="w-9 h-9 border border-[#eae4d8] bg-[#fafafa] text-[#786451] filter-size-btn transition-all hover:border-[#1c1917]" data-size="xs">XS</button>
                        <button onclick="toggleSizeFilter('s', this)" class="w-9 h-9 border border-[#eae4d8] bg-[#fafafa] text-[#786451] filter-size-btn transition-all hover:border-[#1c1917]" data-size="s">S</button>
                        <button onclick="toggleSizeFilter('m', this)" class="w-9 h-9 border border-[#eae4d8] bg-[#fafafa] text-[#786451] filter-size-btn transition-all hover:border-[#1c1917]" data-size="m">M</button>
                        <button onclick="toggleSizeFilter('l', this)" class="w-9 h-9 border border-[#eae4d8] bg-[#fafafa] text-[#786451] filter-size-btn transition-all hover:border-[#1c1917]" data-size="l">L</button>
                        <button onclick="toggleSizeFilter('xl', this)" class="w-9 h-9 border border-[#eae4d8] bg-[#fafafa] text-[#786451] filter-size-btn transition-all hover:border-[#1c1917]" data-size="xl">XL</button>
                    </div>
                </div>

                <!-- 4. Visual Swatches -->
                <div class="space-y-3">
                    <label class="font-brand text-xs uppercase tracking-wider text-[#1c1917] font-bold block">Color</label>
                    
                    <div class="grid grid-cols-6 gap-2 pt-1">
                        <label class="cursor-pointer text-center group block" title="All Colors">
                            <input type="radio" name="filter_color" value="all" checked onchange="applyFilters()" class="sr-only color-radio-input">
                            <span class="w-6 h-6 mx-auto rounded-full bg-white border border-[#eae4d8] flex items-center justify-center text-[8px] font-brand font-bold text-[#1c1917] group-hover:scale-110 transition-transform color-swatch-ring">All</span>
                        </label>
                        
                        <label class="cursor-pointer text-center group block" title="Rich Camel / Sand">
                            <input type="radio" name="filter_color" value="camel" onchange="applyFilters()" class="sr-only color-radio-input">
                            <span class="w-6 h-6 mx-auto rounded-full bg-[#c19a6b] block border border-black/10 group-hover:scale-110 transition-transform color-swatch-ring"></span>
                        </label>

                        <label class="cursor-pointer text-center group block" title="Oatmeal Pearl">
                            <input type="radio" name="filter_color" value="pearl" onchange="applyFilters()" class="sr-only color-radio-input">
                            <span class="w-6 h-6 mx-auto rounded-full bg-[#e3dac9] block border border-black/10 group-hover:scale-110 transition-transform color-swatch-ring"></span>
                        </label>

                        <label class="cursor-pointer text-center group block" title="Deep Charcoal">
                            <input type="radio" name="filter_color" value="charcoal" onchange="applyFilters()" class="sr-only color-radio-input">
                            <span class="w-6 h-6 mx-auto rounded-full bg-[#2f2f2f] block border border-black/10 group-hover:scale-110 transition-transform color-swatch-ring"></span>
                        </label>

                        <label class="cursor-pointer text-center group block" title="Warm Sage">
                            <input type="radio" name="filter_color" value="sage" onchange="applyFilters()" class="sr-only color-radio-input">
                            <span class="w-6 h-6 mx-auto rounded-full bg-[#8f9779] block border border-black/10 group-hover:scale-110 transition-transform color-swatch-ring"></span>
                        </label>

                        <label class="cursor-pointer text-center group block" title="Deep Navy">
                            <input type="radio" name="filter_color" value="blue" onchange="applyFilters()" class="sr-only color-radio-input">
                            <span class="w-6 h-6 mx-auto rounded-full bg-[#1b2f4a] block border border-black/10 group-hover:scale-110 transition-transform color-swatch-ring"></span>
                        </label>
                    </div>
                    <div id="selected-color-label" class="text-[10px] text-[#786451] text-center pt-1 tracking-wider italic">Selected: All Colors</div>
                </div>

            </aside>

            <!-- Right Hand Dynamic Core Products Display Space (9 Cols) -->
            <div class="lg:col-span-9">
                
                <!-- Zero State Warning Node -->
                <div id="no-results" class="hidden text-center py-20 bg-white border border-[#eae4d8] p-8 space-y-4 shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-[#f5efe6] flex items-center justify-center mx-auto text-[#8b7355]">
                        <svg class="w-8 h-8 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="font-brand font-normal text-xl text-[#1c1917]">No Products Found</h3>
                    <p class="text-xs text-[#786451] max-w-md mx-auto leading-relaxed">
                        No items match your selected filters. Try removing some filters or resetting to see all products.
                    </p>
                    <button onclick="resetFilters()" class="mt-2 inline-block py-2.5 px-6 bg-[#1c1917] text-white font-brand text-xs uppercase tracking-widest hover:bg-[#8b7355] transition-colors">
                        Reset All Filters
                    </button>
                </div>

                <!-- Product Catalog Array Container -->
                <div id="catalog-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($catalog as $key => $item)
                    <div class="catalog-item group block relative flex flex-col bg-white border border-[#eae4d8]/60 p-2.5 shadow-sm hover:shadow-[0_15px_40px_rgba(139,115,85,0.12)] transition-all duration-500 animate-grid-render" 
                         data-key="{{ $key }}"
                         data-parent="{{ $item['parent_cat'] }}"
                         data-sub="{{ $item['sub_cat'] }}"
                         data-subsub="{{ $item['sub_sub_cat'] }}"
                         data-price="{{ $item['price'] }}"
                         data-color="{{ $item['color'] }}"
                         data-sizes="{{ implode(',', $item['size']) }}"
                         data-title="{{ strtolower($item['title']) }}">
                        
                        <!-- Portal Anchor Wrap -->
                        <a href="{{ route('product.detail', $key) }}" class="block relative aspect-[3/4] bg-[#f5efe6] overflow-hidden mb-3">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                            
                            <!-- Custom Stamp badge -->
                            <span class="absolute top-2.5 left-2.5 bg-white/95 backdrop-blur-sm px-2 py-1 font-brand text-[9px] font-bold uppercase tracking-widest text-[#8b7355] border border-[#eae4d8]">
                                {{ $item['badge'] }}
                            </span>

                            <!-- On-hover Quick Sizing Tag Ribbon -->
                            <div class="absolute inset-x-0 top-0 pt-2 pb-1 bg-gradient-to-b from-[#1c1917]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex justify-center gap-1 pointer-events-none">
                                @foreach($item['size'] as $sz)
                                    <span class="text-[8px] bg-white text-[#1c1917] px-1.5 py-0.5 font-brand font-bold uppercase">{{ $sz }}</span>
                                @endforeach
                            </div>

                            <!-- Internal Action Prompt Overlay -->
                            <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all flex gap-1">
                                <span class="w-full py-2 bg-[#1c1917]/90 text-white text-[9px] font-brand uppercase tracking-widest font-bold block text-center backdrop-blur-xs">
                                    View Product
                                </span>
                            </div>
                        </a>

                        <!-- Bookmarking Actions -->
                        <button onclick="event.preventDefault(); event.stopPropagation(); window.location.href='{{ url('wishlist/'.($catalog_db[$key] ?? 1).'/toggle') }}'" class="absolute top-5 right-5 p-2 bg-white/95 backdrop-blur-sm text-[#1c1917] hover:text-[#9a3412] shadow-sm rounded-full motion-soft focus:outline-none z-10" aria-label="Add to Wishlist" title="Save to Wishlist">
                            <svg class="w-3.5 h-3.5 {{ in_array($catalog_db[$key] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                            <svg class="w-3.5 h-3.5 {{ in_array($catalog_db[$key] ?? 0, $wishlist_status) ? 'fill-[#9a3412] text-[#9a3412]' : 'stroke-current' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>

                        <div class="px-2 pb-1 flex flex-col justify-between flex-1">
                            <div>
                                <!-- Hierarchy Trail trace -->
                                <div class="flex items-center text-[#8b7355] gap-0.5 mb-1">
                                    <span class="text-[9px] text-[#a08a75] uppercase tracking-wider font-semibold">
                                        {{ $item['parent_cat'] }} • {{ $item['sub_cat'] }}
                                    </span>
                                </div>
                                <a href="{{ route('product.detail', $key) }}" class="block">
                                    <h3 class="text-xs font-semibold text-[#1c1917] hover:text-[#9a3412] motion-soft transition-colors leading-snug">{{ $item['title'] }}</h3>
                                </a>
                            </div>

                            <!-- Cost Output Strip -->
                            <div class="pt-3 border-t border-[#eae4d8]/40 mt-3 flex items-center justify-between">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="font-brand font-bold text-xs text-[#9a3412]">${{ number_format($item['price'], 2) }}</span>
                                    <span class="text-[10px] text-[#786451] line-through">{{ $item['old_price'] }}</span>
                                </div>
                                
                                <!-- Real Instant Synchronization Bag Hook -->
                                <button onclick="executeDirectCartAddition('{{ $key }}', '{{ addslashes($item['title']) }}', {{ $item['price'] }}, '{{ $item['image'] }}', '{{ strtoupper($item['size'][0]) }}', '{{ addslashes($item['color_name']) }}')" class="text-[10px] font-brand uppercase tracking-wider font-bold text-[#8b7355] hover:text-[#1c1917] flex items-center gap-1 focus:outline-none py-1">
                                    <span>+ Add to Bag</span>
                                </button>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>

            </div>

        </div>

    </section>

    <!-- Bottom Presentation Footer Segment -->
    <footer class="bg-white border-t border-[#eae4d8]/80 mt-20 py-12">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 text-center space-y-4 flex flex-col items-center">
            @if(($settings['footer_logo_type'] ?? 'text') === 'image' && !empty($settings['footer_logo_image']))
                <img src="{{ asset('storage/' . $settings['footer_logo_image']) }}" alt="{{ $settings['footer_logo_text'] ?? 'GURUNANAK' }}" class="h-8 w-auto object-contain">
            @else
                <span class="font-brand font-bold text-lg tracking-[0.2em] text-[#1c1917] block">
                    {{ $settings['footer_logo_text'] ?? 'GURUNANAK' }}
                </span>
            @endif
            <p class="text-xs text-[#786451] max-w-sm mx-auto font-light leading-relaxed">
                Carefully crafted apparel made with natural cottons, linens, and wools.
            </p>
            @if(!empty($settings['footer_qr_code']))
                <div class="pt-1 flex flex-col items-center">
                    <span class="text-[9px] uppercase tracking-widest text-[#786451] block mb-1 font-bold">Scan to Connect</span>
                    <div class="w-16 h-16 bg-white p-1 border border-[#eae4d8] rounded-lg shadow-xs">
                        <img src="{{ asset('storage/' . $settings['footer_qr_code']) }}" alt="Contact QR Code" class="w-full h-full object-contain">
                    </div>
                </div>
            @endif
            @include('partials.sales-channels', ['centered' => true])
            <div class="pt-4 text-[11px] text-[#a08a75] border-t border-[#eae4d8]/40 flex flex-wrap justify-center gap-6">
                <span>© {{ date('Y') }} Gurunanak Cloth House. All rights reserved.</span>
                <a href="#" class="hover:text-[#1c1917]">Privacy Policy</a>
                <a href="#" class="hover:text-[#1c1917]">Terms of Service</a>
            </div>
        </div>
    </footer>

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

    <!-- Master Frontend Real-Time Validation & Photo Suggestion Engine -->
    <script>
        // Export runtime matrix objects directly to Javascript layer securely
        const masterCatalogJS = @json($catalog);

        // Core filter parameters
        let activeFilterTree = { parent: 'all', sub: 'all', subsub: 'all' };
        let activeKeywordSearch = '';
        let selectedSizes = [];
        
        const colorLabelsMap = {
            'all': 'All Palettes',
            'camel': 'Rich Camel / Sand',
            'pearl': 'Oatmeal Pearl',
            'charcoal': 'Deep Charcoal',
            'sage': 'Warm Sage',
            'blue': 'Deep Navy'
        };

        // Real-Time Photo Autocomplete / Prediction Dropdown trigger
        function triggerPhotoAutocomplete(query, containerId) {
            const container = document.getElementById(containerId);
            const queryClean = query.toLowerCase().trim();
            
            // Sync current query parameter
            activeKeywordSearch = queryClean;

            // If empty, hide predictive overlay and filter live grid immediately
            if (queryClean.length === 0) {
                container.classList.add('hidden');
                applyFilters();
                return;
            }

            // Loop through masterCatalogJS runtime indexes to compile inline matches
            let resultsHTML = '';
            let matchesFound = 0;

            for (const key in masterCatalogJS) {
                const item = masterCatalogJS[key];
                const matchString = (item.title + ' ' + item.parent_cat + ' ' + item.sub_cat + ' ' + item.sub_sub_cat + ' ' + item.color_name).toLowerCase();
                
                if (matchString.includes(queryClean)) {
                    matchesFound++;
                    
                    const titleText = item.title;
                    
                    resultsHTML += `
                        <a href="{{ route('product.detail', '') }}/${key}" class="flex items-center gap-3 p-2.5 hover:bg-[#f5efe6]/70 transition-colors block text-left group">
                            <img src="${item.image}" alt="${item.title}" class="w-10 h-11 object-cover object-top shrink-0 border border-[#eae4d8]">
                            <div class="min-w-0 flex-1">
                                <div class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] truncate transition-colors">
                                    ${titleText}
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
                    <div class="p-4 text-center text-xs text-[#a08a75] italic">
                        No products found matching "${query}".
                    </div>
                `;
                container.classList.remove('hidden');
            }

            applyFilters();
        }

        document.addEventListener('click', (e) => {
            const wrapperDesk = document.getElementById('desktop-search-wrapper');
            const wrapperMob = document.getElementById('mobile-search-wrapper');
            
            if (wrapperDesk && !wrapperDesk.contains(e.target)) {
                const dropD = document.getElementById('desktop-suggestions');
                if (dropD) dropD.classList.add('hidden');
            }
            if (wrapperMob && !wrapperMob.contains(e.target)) {
                const dropM = document.getElementById('mobile-suggestions');
                if (dropM) dropM.classList.add('hidden');
            }
        });

        function toggleSubTree(id, btn) {
            const el = document.getElementById(id);
            if (el.style.display === 'none' || el.classList.contains('hidden')) {
                el.style.display = 'block'; el.classList.remove('hidden');
                btn.innerText = (btn.innerText.includes('▼') || btn.innerText.includes('▲')) ? '▲' : '+ ';
            } else {
                el.style.display = 'none'; el.classList.add('hidden');
                btn.innerText = (btn.innerText.includes('▼') || btn.innerText.includes('▲')) ? '▼' : '− ';
            }
        }

        function selectCategoryNode(parent, sub, subsub, element) {
            activeFilterTree.parent = parent;
            activeFilterTree.sub = sub;
            activeFilterTree.subsub = subsub;

            document.querySelectorAll('.tree-link-node').forEach(node => {
                node.classList.remove('tree-link-active');
            });
            element.classList.add('tree-link-active');

            applyFilters();
        }

        function updatePriceLabel(val) {
            document.getElementById('price-display').innerText = '$' + val;
        }

        function toggleSizeFilter(size, btn) {
            const index = selectedSizes.indexOf(size);
            if (index > -1) {
                selectedSizes.splice(index, 1);
                btn.classList.remove('border-[#1c1917]', 'bg-[#1c1917]', 'text-white');
                btn.classList.add('border-[#eae4d8]', 'bg-[#fafafa]', 'text-[#786451]');
            } else {
                selectedSizes.push(size);
                btn.classList.remove('border-[#eae4d8]', 'bg-[#fafafa]', 'text-[#786451]');
                btn.classList.add('border-[#1c1917]', 'bg-[#1c1917]', 'text-white');
            }
            applyFilters();
        }

        function removeActiveBound(type, val) {
            if (type === 'tree') {
                const rootBtn = document.querySelector('.tree-link-node[data-tier="all"]');
                if (rootBtn) selectCategoryNode('all', 'all', 'all', rootBtn);
                else {
                    activeFilterTree = { parent: 'all', sub: 'all', subsub: 'all' };
                    applyFilters();
                }
            } else if (type === 'search') {
                activeKeywordSearch = '';
                const topInput = document.getElementById('top-quick-search');
                const mobInput = document.getElementById('mobile-quick-search');
                if (topInput) topInput.value = '';
                if (mobInput) mobInput.value = '';
                applyFilters();
            } else if (type === 'color') {
                document.querySelector('input[name="filter_color"][value="all"]').checked = true;
                applyFilters();
            } else if (type === 'price') {
                document.getElementById('price-range').value = 500;
                updatePriceLabel(500);
                applyFilters();
            } else if (type === 'size') {
                const idx = selectedSizes.indexOf(val);
                if (idx > -1) selectedSizes.splice(idx, 1);
                const btn = document.querySelector(`.filter-size-btn[data-size="${val}"]`);
                if (btn) {
                    btn.classList.remove('border-[#1c1917]', 'bg-[#1c1917]', 'text-white');
                    btn.classList.add('border-[#eae4d8]', 'bg-[#fafafa]', 'text-[#786451]');
                }
                applyFilters();
            }
        }

        function applyFilters() {
            const color = document.querySelector('input[name="filter_color"]:checked').value;
            const maxPrice = parseFloat(document.getElementById('price-range').value);
            const sortBy = document.getElementById('sort-select').value;
            
            document.querySelectorAll('.color-radio-input').forEach(inp => {
                const ringNode = inp.parentElement;
                if (inp.checked) ringNode.classList.add('ring-2', 'ring-offset-2', 'ring-[#8b7355]');
                else ringNode.classList.remove('ring-2', 'ring-offset-2', 'ring-[#8b7355]');
            });
            document.getElementById('selected-color-label').innerText = 'Selected Tone: ' + colorLabelsMap[color];

            const items = Array.from(document.querySelectorAll('.catalog-item'));
            let visibleCount = 0;

            items.forEach(item => {
                const itemParent = item.dataset.parent;
                const itemSub = item.dataset.sub;
                const itemSubSub = item.dataset.subsub;
                const itemColor = item.dataset.color;
                const itemPrice = parseFloat(item.dataset.price);
                const itemTitle = item.dataset.title;
                const itemSizes = item.dataset.sizes.split(',');

                let matchTree = true;
                if (activeFilterTree.parent !== 'all') {
                    if (itemParent !== activeFilterTree.parent) matchTree = false;
                    else if (activeFilterTree.sub !== 'all') {
                        if (itemSub !== activeFilterTree.sub) matchTree = false;
                        else if (activeFilterTree.subsub !== 'all') {
                            if (itemSubSub !== activeFilterTree.subsub) matchTree = false;
                        }
                    }
                }

                let matchSearch = true;
                if (activeKeywordSearch !== '') {
                    matchSearch = itemTitle.includes(activeKeywordSearch);
                }

                const matchColor = (color === 'all' || itemColor === color);
                const matchPrice = (itemPrice <= maxPrice);
                
                let matchSize = true;
                if (selectedSizes.length > 0) {
                    matchSize = selectedSizes.some(sz => itemSizes.includes(sz));
                }

                if (matchTree && matchSearch && matchColor && matchPrice && matchSize) {
                    item.style.display = 'flex';
                    item.classList.remove('animate-grid-render');
                    void item.offsetWidth;
                    item.classList.add('animate-grid-render');
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            document.getElementById('visible-count').innerText = visibleCount;
            const noResults = document.getElementById('no-results');
            if (visibleCount === 0) noResults.classList.remove('hidden');
            else noResults.classList.add('hidden');

            renderActiveChipsRibbon(color, maxPrice);
            sortGrid(sortBy);
        }

        function renderActiveChipsRibbon(color, maxPrice) {
            const container = document.getElementById('active-filters-container');
            const area = document.getElementById('chips-area');
            area.innerHTML = '';
            let hasBounds = false;

            if (activeFilterTree.parent !== 'all') {
                hasBounds = true;
                let pathLabel = activeFilterTree.parent;
                if (activeFilterTree.sub !== 'all') {
                    pathLabel += ' ▸ ' + activeFilterTree.sub;
                    if (activeFilterTree.subsub !== 'all') {
                        pathLabel += ' ▸ ' + activeFilterTree.subsub;
                    }
                }
                area.innerHTML += `
                    <span class="inline-flex items-center gap-1.5 bg-white text-[#1c1917] px-2.5 py-1 border border-[#8b7355] shadow-xs">
                        <span class="text-[#8b7355]">Category:</span> <strong class="font-bold uppercase tracking-wider text-[10px]">${pathLabel}</strong>
                        <button onclick="removeActiveBound('tree', null)" class="hover:text-[#9a3412] font-bold ml-1">✕</button>
                    </span>
                `;
            }

            if (activeKeywordSearch !== '') {
                hasBounds = true;
                area.innerHTML += `
                    <span class="inline-flex items-center gap-1.5 bg-[#f5efe6] text-[#1c1917] px-2.5 py-1 border border-[#eae4d8]">
                        <span class="text-[#8b7355]">Search:</span> <strong class="font-medium">"${activeKeywordSearch}"</strong>
                        <button onclick="removeActiveBound('search', null)" class="hover:text-[#9a3412] font-bold ml-1">✕</button>
                    </span>
                `;
            }

            if (color !== 'all') {
                hasBounds = true;
                area.innerHTML += `
                    <span class="inline-flex items-center gap-1.5 bg-[#f5efe6] text-[#1c1917] px-2.5 py-1 border border-[#eae4d8]">
                        <span class="text-[#8b7355]">Color:</span> <strong class="font-medium">${colorLabelsMap[color]}</strong>
                        <button onclick="removeActiveBound('color', null)" class="hover:text-[#9a3412] font-bold ml-1">✕</button>
                    </span>
                `;
            }

            if (maxPrice < 500) {
                hasBounds = true;
                area.innerHTML += `
                    <span class="inline-flex items-center gap-1.5 bg-[#f5efe6] text-[#1c1917] px-2.5 py-1 border border-[#eae4d8]">
                        <span class="text-[#8b7355]">Price:</span> <strong class="font-medium">Up to $${maxPrice}</strong>
                        <button onclick="removeActiveBound('price', null)" class="hover:text-[#9a3412] font-bold ml-1">✕</button>
                    </span>
                `;
            }

            selectedSizes.forEach(sz => {
                hasBounds = true;
                area.innerHTML += `
                    <span class="inline-flex items-center gap-1.5 bg-[#f5efe6] text-[#1c1917] px-2.5 py-1 border border-[#eae4d8]">
                        <span class="text-[#8b7355]">Size:</span> <strong class="font-medium uppercase">${sz}</strong>
                        <button onclick="removeActiveBound('size', '${sz}')" class="hover:text-[#9a3412] font-bold ml-1">✕</button>
                    </span>
                `;
            });

            if (hasBounds) {
                container.classList.remove('hidden'); container.classList.add('flex');
            } else {
                container.classList.remove('flex'); container.classList.add('hidden');
            }
        }

        function sortGrid(type) {
            const grid = document.getElementById('catalog-grid');
            const items = Array.from(grid.querySelectorAll('.catalog-item'));

            items.sort((a, b) => {
                if (type === 'low-high') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                else if (type === 'high-low') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                else if (type === 'name') return a.dataset.title.localeCompare(b.dataset.title);
                return 0;
            });

            items.forEach(item => grid.appendChild(item));
        }

        function resetFilters() {
            const rootBtn = document.querySelector('.tree-link-node[data-tier="all"]');
            if (rootBtn) selectCategoryNode('all', 'all', 'all', rootBtn);
            else activeFilterTree = { parent: 'all', sub: 'all', subsub: 'all' };

            activeKeywordSearch = '';
            const tInp = document.getElementById('top-quick-search');
            const mInp = document.getElementById('mobile-quick-search');
            if (tInp) tInp.value = '';
            if (mInp) mInp.value = '';

            document.querySelector('input[name="filter_color"][value="all"]').checked = true;
            
            const pRange = document.getElementById('price-range');
            pRange.value = 500;
            updatePriceLabel(500);
            
            selectedSizes = [];
            document.querySelectorAll('.filter-size-btn').forEach(btn => {
                btn.classList.remove('border-[#1c1917]', 'bg-[#1c1917]', 'text-white');
                btn.classList.add('border-[#eae4d8]', 'bg-[#fafafa]', 'text-[#786451]');
            });

            document.getElementById('sort-select').value = 'default';

            const dropD = document.getElementById('desktop-suggestions');
            const dropM = document.getElementById('mobile-suggestions');
            if (dropD) dropD.classList.add('hidden');
            if (dropM) dropM.classList.add('hidden');

            applyFilters();
        }

        function toggleMobileFilter() {
            const pnl = document.getElementById('filter-panel');
            if (pnl.classList.contains('hidden')) {
                pnl.classList.remove('hidden', 'lg:block');
                pnl.classList.add('block', 'fixed', 'inset-0', 'z-50', 'bg-white', 'overflow-y-auto', 'max-h-screen');
                if (!document.getElementById('mobile-close-btn')) {
                    const cb = document.createElement('button');
                    cb.id = 'mobile-close-btn';
                    cb.innerText = '✕ Apply Filters & Close';
                    cb.className = 'w-full py-3.5 bg-[#1c1917] text-white font-brand text-xs uppercase tracking-widest font-bold mb-4 sticky top-0 z-20 shadow-md';
                    cb.onclick = () => {
                        pnl.classList.add('hidden', 'lg:block');
                        pnl.classList.remove('block', 'fixed', 'inset-0', 'z-50', 'bg-white', 'overflow-y-auto', 'max-h-screen');
                    };
                    pnl.insertBefore(cb, pnl.firstChild);
                }
            } else {
                pnl.classList.add('hidden', 'lg:block');
                pnl.classList.remove('block', 'fixed', 'inset-0', 'z-50', 'bg-white', 'overflow-y-auto', 'max-h-screen');
            }
        }

        // ==========================================
        // REAL-TIME CLIENT CART ENGINE HOOKS
        // ==========================================
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

        function getBagTotalQty() {
            const bag = getClientBag();
            return bag.reduce((sum, item) => sum + parseInt(item.qty), 0);
        }

        function executeDirectCartAddition(id, title, price, img, fallbackSize = 'M', fallbackColor = 'Atelier Selection') {
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
            const drawerBadge = document.getElementById('drawer-qty-badge');
            const subtotalNode = document.getElementById('drawer-subtotal');
            const totalNode = document.getElementById('drawer-total');

            const totalQty = bag.reduce((sum, item) => sum + parseInt(item.qty), 0);
            const totalPrice = bag.reduce((sum, item) => sum + (parseFloat(item.price) * parseInt(item.qty)), 0);

            if(counterPill) counterPill.innerText = totalQty;
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

        window.onload = () => {
            applyFilters();
            renderShoppingBagState();
        };
    </script>
</body>
</html>
