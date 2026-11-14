@php
// Fetch global settings instantly from cache for 100/100 PageSpeed
$settings = \Illuminate\Support\Facades\Cache::rememberForever('store_settings', function () {
    return \App\Models\StoreSetting::all()->pluck('value', 'key')->toArray();
});

// Boot active menus for header
$menus = \App\Models\NavigationMenu::where('is_active', true)->where('menu_type', 'header')->whereNull('parent_id')->with('children')->orderBy('sort_order')->get();
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic SEO Optimization tags -->
    <title>{{ $settings['about_meta_title'] ?? 'About Us | Gurunanak Cloth House' }}</title>
    <meta name="description" content="{{ $settings['about_meta_description'] ?? 'Learn about Gurunanak Cloth House, our history since 1990, and our dedication to natural fabrics, honest tailoring, and comfortable clothing.' }}">
    @if(!empty($settings['about_meta_keywords']))
        <meta name="keywords" content="{{ $settings['about_meta_keywords'] }}">
    @endif

    <!-- Premium Inter & Montserrat Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600;700;850&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS stable play CDN compiler -->
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
        .font-brand {
            font-family: 'Montserrat', sans-serif;
        }
        .motion-soft {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes smoothMarquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: smoothMarquee 28s linear infinite;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#f5efe6] selection:text-[#8b7355] overflow-x-hidden text-[#1c1917] bg-[#fcfbf9]">

    @include('partials.header')

    <!-- 3. Main Dynamic About Page Content Section -->
    <main class="py-16 md:py-24">
        <div class="max-w-[1200px] mx-auto px-6">
            
            <!-- Headline block with luxury ambient styling -->
            <div class="text-center max-w-3xl mx-auto mb-16 md:mb-24">
                <span class="font-brand text-[10px] uppercase tracking-[0.3em] text-[#8b7355] font-semibold block mb-4">OUR STORY</span>
                <h1 class="font-brand font-black text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#1c1917] tracking-tight leading-[1.1] mb-6">
                    {!! nl2br(e($settings['about_heading'] ?? 'Our Story & Heritage')) !!}
                </h1>
                <div class="w-12 h-0.5 bg-[#8b7355] mx-auto mb-8"></div>
                <p class="text-sm md:text-base text-[#786451] font-light leading-relaxed max-w-2xl mx-auto">
                    {{ $settings['about_content'] ?? 'Founded in 1990, Gurunanak Cloth House has spent over three decades crafting comfortable clothing from natural fabrics, with careful attention to cut and finish.' }}
                </p>
            </div>

            <!-- Overlapping Editorial Grid (Hero block) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center mb-20 md:mb-32">
                <div class="lg:col-span-7">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-[#eae4d8]/40 group aspect-[4/3] sm:aspect-[16/10]">
                        @if(!empty($settings['about_image']))
                            <img src="{{ asset('storage/' . $settings['about_image']) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1400&q=80" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1c1917]/20 to-transparent"></div>
                    </div>
                </div>
                <div class="lg:col-span-5 lg:-ml-12 z-10">
                    <div class="bg-white/80 backdrop-blur-xl border border-[#eae4d8]/60 rounded-3xl p-8 sm:p-10 shadow-xl space-y-6">
                        <span class="font-brand text-[9px] uppercase tracking-[0.25em] text-[#8b7355] font-bold block">OUR PHILOSOPHY</span>
                        <h3 class="font-brand font-bold text-xl sm:text-2xl text-[#1c1917] tracking-tight leading-tight">
                            Honest Tailoring & Everyday Comfort
                        </h3>
                        <p class="text-xs text-[#786451] leading-relaxed font-light">
                            We focus on clean, comfortable clothing made to last. Instead of chasing fast trends, we pick sturdy cottons, breathable linens, and soft wools that fit comfortably and hold up through daily wear.
                        </p>
                        <div class="pt-2 flex items-center gap-4">
                            <div class="flex flex-col">
                                <span class="font-brand font-extrabold text-xl text-[#1c1917]">35+</span>
                                <span class="text-[8px] text-[#8b7355] uppercase tracking-wider font-bold">Years of Experience</span>
                            </div>
                            <div class="w-px h-8 bg-[#eae4d8]"></div>
                            <div class="flex flex-col">
                                <span class="font-brand font-extrabold text-xl text-[#1c1917]">100%</span>
                                <span class="text-[8px] text-[#8b7355] uppercase tracking-wider font-bold">Natural Fabrics</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Heritage & Craftsmanship (Secondary block) -->
            @if(!empty($settings['about_story_block_title']) || !empty($settings['about_story_block_content']))
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6 order-2 lg:order-1">
                        <span class="font-brand text-[10px] uppercase tracking-[0.3em] text-[#8b7355] font-semibold block">THE WORKSHOP</span>
                        <h2 class="font-brand font-extrabold text-2xl sm:text-3xl text-[#1c1917] tracking-tight leading-snug">
                            {{ $settings['about_story_block_title'] ?? 'Careful Stitching & Materials' }}
                        </h2>
                        <div class="w-8 h-0.5 bg-[#8b7355]"></div>
                        <p class="text-xs sm:text-sm text-[#786451] leading-relaxed font-light">
                            {{ $settings['about_story_block_content'] ?? 'We inspect every roll of fabric before cutting. Our tailors take time with seam allowances, hem finishes, and clean lines so each piece looks neat and wears comfortably for years.' }}
                        </p>
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 font-brand text-[10px] uppercase tracking-widest font-bold text-[#1c1917] hover:text-[#8b7355] transition-colors pt-2">
                            Browse Our Products
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                    <div class="order-1 lg:order-2">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-[#eae4d8]/40 aspect-[4/3] group">
                            @if(!empty($settings['about_story_block_image']))
                                <img src="{{ asset('storage/' . $settings['about_story_block_image']) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=1400&q=80" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1c1917]/20 to-transparent"></div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>

    <!-- 4. Public Footer -->
    <footer class="bg-white border-t border-[#eae4d8] pt-16 pb-8 mt-20 select-none">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                
                <!-- Col 1: Brand Info -->
                <div class="space-y-4 max-w-sm">
                    <span class="font-brand font-black text-sm tracking-[0.25em] text-[#1c1917] block">
                        {{ $settings['logo_text'] ?? 'GURUNANAK' }}
                    </span>
                    <p class="text-xs text-[#786451] leading-relaxed">
                        Quality fabrics, honest tailoring, and comfortable everyday clothing since 1990.
                    </p>
                    @include('partials.sales-channels')
                </div>
                
                <!-- Col 2 & 3: Footer Dynamic Columns -->
                @include('partials.footer-links')

                <!-- Col 4: Support & Admin Tunnel -->
                <div class="space-y-3">
                    <h5 class="font-brand text-xs uppercase tracking-widest font-semibold text-[#1c1917]">Customer Support</h5>
                    <div class="text-xs text-[#786451] space-y-2">
                        <p>Email Us:<br><strong class="text-[#1c1917] font-semibold">{{ $settings['contact_email'] ?? 'support@gurunanak.com' }}</strong></p>
                        <p>Call Us:<br><strong class="text-[#1c1917] font-semibold">{{ $settings['contact_phone'] ?? '+91 98765 43210' }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Bottom Sub Footer -->
            <div class="pt-8 border-t border-[#eae4d8]/40 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-[11px] text-[#786451]">
                <p>© {{ date('Y') }} {{ $settings['logo_text'] ?? 'GURUNANAK' }} Cloth House. All rights reserved.</p>
                <div class="flex items-center gap-3 text-[10px] font-brand uppercase tracking-widest text-[#1c1917] font-medium">
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Visa</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Mastercard</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Amex</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">ApplePay</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
