@php
    $menus = \App\Models\NavigationMenu::where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->get();
    $settings = \App\Models\StoreSetting::pluck('value', 'key')->toArray();
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | {{ $settings['site_name'] ?? 'Gurunanak Cloth House' }}</title>
    
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
    </style>
</head>
<body class="antialiased selection:bg-[#f5efe6] selection:text-[#8b7355]">

    @include('partials.header')

    <!-- Visual Presentation Heading Banner -->
    <div class="bg-gradient-to-b from-[#fdfbf7] to-[#fcfbf9] border-b border-[#eae4d8]/60 py-10">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col items-center justify-center text-center gap-4">
            <h1 class="font-brand text-3xl sm:text-4xl text-[#1c1917] font-normal tracking-tight">My Wishlist</h1>
            <p class="text-[11px] text-[#a08a75] font-brand tracking-widest uppercase">Saved Items</p>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="py-12 min-h-[50vh]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            @if($wishlists->isEmpty())
                <div class="text-center py-20 bg-white border border-[#eae4d8]/60">
                    <svg class="w-10 h-10 mx-auto text-[#d6cebf] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <h4 class="font-brand text-sm tracking-widest uppercase text-[#44403c] mb-2">Your Wishlist is Empty</h4>
                    <p class="text-xs text-[#a08a75] mb-6 max-w-sm mx-auto">Browse our products and click the heart icon on items you want to save.</p>
                    <a href="{{ route('shop.index') }}" class="px-6 py-2.5 border border-[#1c1917] text-[#1c1917] hover:bg-[#1c1917] hover:text-white text-[10px] font-brand uppercase tracking-widest font-semibold transition-colors duration-300 inline-block">Start Shopping</a>
                </div>
            @else
                <!-- Refined Grid Layout: 5 columns on large screens for elegant sizing -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 gap-y-10">
                    @foreach($wishlists as $item)
                        @php $product = $item->product; @endphp
                        @if($product)
                            <div class="group relative flex flex-col transition-all duration-500">
                                
                                <a href="{{ route('product.detail', $product->slug) }}" class="block relative aspect-[3/4] overflow-hidden bg-[#f5efe6] mb-4">
                                    <img src="{{ $product->image_path ? (str_starts_with($product->image_path, 'http') ? $product->image_path : url($product->image_path)) : '' }}" alt="{{ $product->title ?? $product->name }}" class="w-full h-full object-cover object-top group-hover:scale-105 motion-soft duration-700">
                                    
                                    <!-- Remove Button - Elegant corner placement -->
                                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-2 right-2 z-10">
                                        @csrf
                                        <button type="submit" class="w-6 h-6 flex items-center justify-center bg-white/90 backdrop-blur-sm hover:text-[#9a3412] text-[#786451] rounded-full shadow-sm transition-colors border border-[#eae4d8]/40" title="Remove from wishlist">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                    
                                    <!-- Quick Action Overlay -->
                                    <div class="absolute inset-x-2 bottom-2 translate-y-12 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 motion-soft transition-all">
                                        <span class="w-full py-2 bg-[#1c1917]/90 text-white text-[9px] font-brand uppercase tracking-widest font-bold block text-center backdrop-blur-xs">
                                            View Details
                                        </span>
                                    </div>
                                </a>
                                
                                <div class="px-1 flex flex-col justify-between flex-1 text-center">
                                    <a href="{{ route('product.detail', $product->slug) }}" class="block">
                                        <h3 class="text-[11px] font-semibold text-[#1c1917] group-hover:text-[#9a3412] motion-soft transition-colors leading-snug">{{ $product->title ?? $product->name }}</h3>
                                    </a>
                                    <span class="font-brand font-bold text-xs text-[#9a3412] mt-1.5 block">${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Simplified Footer -->
    <footer class="bg-[#1c1917] text-[#fdfbf7] pt-12 pb-6 border-t border-[#292524]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 text-center flex flex-col items-center">
            <span class="font-brand font-extrabold text-sm tracking-[0.25em] text-white leading-none">
                {{ $settings['logo_text'] ?? 'GURUNANAK' }}
            </span>
            <p class="text-[#a08a75] text-[10px] uppercase tracking-widest mt-4">Quality fabrics and honest tailoring since 1990.</p>
            <div class="mt-8 border-t border-[#292524] pt-6 w-full max-w-md">
                <p class="text-[#786451] text-[9px] uppercase tracking-widest">&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Gurunanak Cloth House' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
