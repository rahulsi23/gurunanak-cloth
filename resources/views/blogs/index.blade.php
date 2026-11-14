@php
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
    <title>{{ $pageSeo->meta_title }}</title>
    <meta name="description" content="{{ $pageSeo->meta_description }}">
    @if(!empty($pageSeo->meta_keywords))
        <meta name="keywords" content="{{ $pageSeo->meta_keywords }}">
    @endif
    <meta property="og:title" content="{{ $pageSeo->og_title }}">
    <meta property="og:description" content="{{ $pageSeo->og_description }}">
    @if(!empty($pageSeo->og_image))
        <meta property="og:image" content="{{ $pageSeo->og_image }}">
    @endif

    <!-- Premium Inter & Montserrat Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600;700;850&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
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
        .font-serif-editor {
            font-family: 'Playfair Display', serif;
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

    <!-- 3. Main Blogs Directory Content -->
    <main class="py-16 md:py-24">
        <div class="max-w-[1300px] mx-auto px-6">
            
            <!-- Headline block with editorial styling -->
            <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
                <span class="font-brand text-[10px] uppercase tracking-[0.3em] text-[#8b7355] font-semibold block mb-4">OUR JOURNAL</span>
                <h1 class="font-serif-editor font-normal text-4xl sm:text-5xl md:text-6xl text-[#1c1917] tracking-tight leading-[1.1] mb-6">
                    Articles & Journal
                </h1>
                <div class="w-12 h-0.5 bg-[#8b7355] mx-auto mb-8"></div>
                <p class="text-xs sm:text-sm text-[#786451] font-light leading-relaxed max-w-xl mx-auto">
                    Guides on fabrics, garment care, tailoring tips, and everyday clothing.
                </p>
            </div>

            <!-- Categories Tabs -->
            <div class="flex items-center justify-center flex-wrap gap-2.5 mb-12 sm:mb-16 border-b border-[#eae4d8]/60 pb-8">
                <a href="{{ route('blogs.index') }}" class="px-5 py-2 rounded-full text-xs font-brand font-medium tracking-wider transition-all {{ !$activeCategory ? 'bg-[#292524] text-white shadow-lg' : 'bg-transparent text-[#786451] hover:bg-[#f5efe6]/40 border border-[#eae4d8]' }}">
                    All Stories
                </a>
                @foreach($categories as $cat)
                    @if($cat->posts_count > 0)
                        <a href="{{ route('blogs.index', ['category' => $cat->slug]) }}" class="px-5 py-2 rounded-full text-xs font-brand font-medium tracking-wider transition-all {{ ($activeCategory && $activeCategory->slug === $cat->slug) ? 'bg-[#292524] text-white shadow-lg' : 'bg-transparent text-[#786451] hover:bg-[#f5efe6]/40 border border-[#eae4d8]' }}">
                            {{ $cat->name }} ({{ $cat->posts_count }})
                        </a>
                    @endif
                @endforeach
            </div>

            <!-- Articles Grid -->
            @if($posts->isEmpty())
                <div class="py-24 text-center max-w-md mx-auto space-y-4">
                    <svg class="w-10 h-10 text-[#eae4d8] mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v7a2 2 0 01-2 2H9a2 2 0 01-2-2v-1"/></svg>
                    <p class="font-brand font-bold text-xs uppercase tracking-wider text-[#1c1917]">No Journal Posts Available</p>
                    <p class="text-xs text-[#786451] font-light leading-relaxed">We are currently drafting editorial columns. Please join us back shortly to explore tailoring insights.</p>
                    <a href="{{ url('/') }}" class="px-6 py-2.5 rounded bg-[#292524] text-white text-[10px] font-brand uppercase tracking-widest font-bold inline-block hover:bg-[#8b7355] transition-colors">
                        Return to Storefront
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 md:gap-8 lg:gap-10">
                    @foreach($posts as $post)
                        <article class="group flex flex-col justify-between h-full bg-white rounded-3xl overflow-hidden shadow-[0_10px_40px_rgba(139,115,85,0.04)] border border-[#eae4d8]/40 hover:shadow-[0_20px_50px_rgba(139,115,85,0.08)] transition-all duration-500">
                            
                            <!-- Image Container -->
                            <a href="{{ route('blogs.show', $post->slug) }}" class="block aspect-[16/10] sm:aspect-[16/10] overflow-hidden relative border-b border-[#eae4d8]/30 shrink-0">
                                <picture class="block w-full h-full">
                                    <!-- Loads Mobile image on small viewports -->
                                    @if($post->mobile_image)
                                        <source media="(max-width: 640px)" srcset="{{ asset('storage/' . $post->mobile_image) }}">
                                    @endif
                                    <!-- Default Desktop image -->
                                    <img src="{{ asset('storage/' . ($post->desktop_image ?: $post->mobile_image)) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </picture>
                                @if($post->category)
                                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-md text-[#8b7355] text-[8px] uppercase tracking-widest font-bold px-3 py-1 rounded-full border border-[#eae4d8]/60 shadow-sm">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                            </a>

                            <!-- Text Content Container -->
                            <div class="p-6 sm:p-8 flex flex-col justify-between flex-1 space-y-6">
                                <div class="space-y-3">
                                    <!-- Published Date -->
                                    <span class="text-[9px] text-[#786451]/75 font-brand uppercase tracking-widest font-medium">
                                        {{ $post->created_at->format('F d, Y') }}
                                    </span>
                                    <!-- Title -->
                                    <h3 class="font-serif-editor font-normal text-xl text-[#1c1917] group-hover:text-[#8b7355] transition-colors leading-snug">
                                        <a href="{{ route('blogs.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                    <!-- Short Summary -->
                                    <p class="text-xs text-[#786451] leading-relaxed font-light line-clamp-3">
                                        {{ $post->short_summary ?: strip_tags(substr($post->content, 0, 150)) }}
                                    </p>
                                </div>

                                <!-- Read More Action -->
                                <div class="pt-4 border-t border-[#eae4d8]/40 flex items-center justify-between">
                                    <a href="{{ route('blogs.show', $post->slug) }}" class="inline-flex items-center gap-2 font-brand text-[9px] uppercase tracking-widest font-bold text-[#1c1917] hover:text-[#8b7355] transition-colors">
                                        Read Article
                                        <svg class="w-3 h-3 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                </div>
                            </div>

                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-16 pt-8 border-t border-[#eae4d8]/40">
                    {{ $posts->links() }}
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
