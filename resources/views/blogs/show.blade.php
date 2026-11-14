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
        
        /* Editorial Drop-Cap for expensive magazine layout */
        .article-content > p:first-of-type::first-letter {
            font-family: 'Playfair Display', serif;
            float: left;
            font-size: 4.8rem;
            line-height: 4rem;
            padding-top: 4px;
            padding-right: 12px;
            padding-left: 3px;
            font-weight: 500;
            color: #8b7355;
        }

        /* Clean parsed HTML style mappings for rich-text Jodit payloads */
        .article-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: #1c1917;
            margin-top: 2rem;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        .article-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 600;
            color: #1c1917;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }
        .article-content p {
            font-size: 1rem;
            line-height: 1.85;
            color: #292524;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }
        .article-content blockquote {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.2rem;
            border-left: 2px solid #8b7355;
            padding-left: 1.5rem;
            margin: 2rem 0;
            color: #786451;
            line-height: 1.7;
        }
        .article-content ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.8;
            color: #292524;
        }
        .article-content ol {
            list-style-type: decimal;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.8;
            color: #292524;
        }
        .article-content li {
            margin-bottom: 0.5rem;
            font-weight: 300;
        }
        .article-content strong {
            font-weight: 600;
            color: #1c1917;
        }
        .article-content img {
            border-radius: 1rem;
            margin: 2.5rem auto;
            max-width: 100%;
            box-shadow: 0 10px 30px rgba(139,115,85,0.06);
            border: 1px border-[#eae4d8]/40;
        }
        .article-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            font-size: 0.9rem;
        }
        .article-content th {
            background-color: #f5efe6/40;
            border-bottom: 2px solid #eae4d8;
            padding: 0.75rem;
            font-weight: 600;
            text-align: left;
        }
        .article-content td {
            border-bottom: 1px solid #eae4d8/60;
            padding: 0.75rem;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#f5efe6] selection:text-[#8b7355] overflow-x-hidden text-[#1c1917] bg-[#fcfbf9]">

    @include('partials.header')

    <!-- 3. Main Reading Section -->
    <article class="py-12 sm:py-20 md:py-24">
        <div class="max-w-[1300px] mx-auto px-6">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2.5 font-brand text-[9px] uppercase tracking-widest text-[#786451]/80 mb-8 select-none">
                <a href="{{ url('/') }}" class="hover:text-[#8b7355] transition-colors">Home</a>
                <span class="text-[#eae4d8] text-[12px]">&bull;</span>
                <a href="{{ route('blogs.index') }}" class="hover:text-[#8b7355] transition-colors">Journal</a>
                @if($post->category)
                    <span class="text-[#eae4d8] text-[12px]">&bull;</span>
                    <a href="{{ route('blogs.index', ['category' => $post->category->slug]) }}" class="hover:text-[#8b7355] transition-colors">{{ $post->category->name }}</a>
                @endif
            </div>

            <!-- Main Editorial Layout: Grid layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center mb-16 sm:mb-24">
                
                <!-- Editorial Info Block (Left 5 columns) -->
                <div class="lg:col-span-5 space-y-6">
                    @if($post->category)
                        <span class="px-3.5 py-1 text-[9px] uppercase tracking-[0.2em] font-brand font-bold bg-[#f5efe6] text-[#8b7355] border border-[#eae4d8] rounded-full inline-block">
                            {{ $post->category->name }}
                        </span>
                    @endif
                    
                    <h1 class="font-serif-editor font-normal text-3xl sm:text-4xl md:text-5xl lg:text-5xl text-[#1c1917] tracking-tight leading-[1.15]">
                        {{ $post->title }}
                    </h1>
                    
                    <div class="w-16 h-[1.5px] bg-[#8b7355]"></div>
                    
                    <div class="flex items-center gap-4 text-[10px] font-brand uppercase tracking-widest text-[#786451]/95 font-medium select-none">
                        <span>Published: {{ $post->created_at->format('M d, Y') }}</span>
                        <span class="text-[#eae4d8] text-[14px]">&bull;</span>
                        <span>BY GURUNANAK</span>
                    </div>

                    @if($post->short_summary)
                        <p class="text-xs sm:text-sm text-[#786451] font-light leading-relaxed border-l-2 border-[#eae4d8] pl-4 italic">
                            {{ $post->short_summary }}
                        </p>
                    @endif
                </div>

                <!-- Immersive Header Image (Right 7 columns) -->
                <div class="lg:col-span-7">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-[#eae4d8]/40 group aspect-[16/10] bg-[#f5efe6]/20">
                        <picture class="block w-full h-full">
                            <!-- Mobile Square Image -->
                            @if($post->mobile_image)
                                <source media="(max-width: 640px)" srcset="{{ asset('storage/' . $post->mobile_image) }}">
                            @endif
                            <!-- Desktop Landscape Image -->
                            <img src="{{ asset('storage/' . ($post->desktop_image ?: $post->mobile_image)) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.03]">
                        </picture>
                    </div>
                </div>

            </div>

            <!-- Reading Body Container -->
            <div class="max-w-[760px] mx-auto">
                
                <!-- Article HTML parsed content -->
                <div class="article-content font-serif-editor">
                    {!! $post->content !!}
                </div>

                <!-- Footer back button -->
                <div class="mt-16 pt-8 border-t border-[#eae4d8]/60 flex items-center justify-between flex-col sm:flex-row gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-[#786451]/60 font-light">Share this article:</span>
                        <div class="flex items-center gap-2 text-[10px] font-brand font-bold text-[#1c1917] select-none">
                            <a href="https://twitter.com/share?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="px-3 py-1 border border-[#eae4d8] rounded-full hover:bg-[#f5efe6]/40 transition-colors">X</a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="px-3 py-1 border border-[#eae4d8] rounded-full hover:bg-[#f5efe6]/40 transition-colors">FB</a>
                            <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&media={{ urlencode($post->desktop_image ? asset('storage/' . $post->desktop_image) : '') }}&description={{ urlencode($post->title) }}" target="_blank" class="px-3 py-1 border border-[#eae4d8] rounded-full hover:bg-[#f5efe6]/40 transition-colors">PIN</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('blogs.index') }}" class="inline-flex items-center gap-2 font-brand text-[9px] uppercase tracking-widest font-bold px-6 py-2.5 rounded bg-[#292524] text-white hover:bg-[#8b7355] transition-colors shadow-lg">
                        <svg class="w-3 h-3 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        Return to Journal
                    </a>
                </div>

            </div>

            <!-- Related Articles (At the bottom) -->
            @if($relatedPosts->count() > 0)
                <div class="mt-24 pt-16 border-t border-[#eae4d8]">
                    <div class="text-center max-w-lg mx-auto mb-12">
                        <span class="font-brand text-[8px] uppercase tracking-[0.3em] text-[#8b7355] font-semibold block mb-2">COMPLIMENTARY READS</span>
                        <h3 class="font-serif-editor font-normal text-2xl text-[#1c1917]">Related Stories</h3>
                        <div class="w-8 h-0.5 bg-[#8b7355] mx-auto mt-4"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedPosts as $rel)
                            <article class="group flex flex-col justify-between h-full bg-white rounded-2xl overflow-hidden shadow-[0_10px_40px_rgba(139,115,85,0.02)] border border-[#eae4d8]/40 hover:shadow-[0_20px_50px_rgba(139,115,85,0.06)] transition-all duration-500">
                                <a href="{{ route('blogs.show', $rel->slug) }}" class="block aspect-[16/10] overflow-hidden relative border-b border-[#eae4d8]/30 shrink-0 bg-[#f5efe6]/20">
                                    <picture class="block w-full h-full">
                                        @if($rel->mobile_image)
                                            <source media="(max-width: 640px)" srcset="{{ asset('storage/' . $rel->mobile_image) }}">
                                        @endif
                                        <img src="{{ asset('storage/' . ($rel->desktop_image ?: $rel->mobile_image)) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    </picture>
                                </a>

                                <div class="p-6 flex flex-col justify-between flex-1 space-y-4">
                                    <div class="space-y-2">
                                        <span class="text-[8px] text-[#786451]/75 font-brand uppercase tracking-widest font-medium">
                                            {{ $rel->created_at->format('M d, Y') }}
                                        </span>
                                        <h4 class="font-serif-editor font-normal text-base text-[#1c1917] group-hover:text-[#8b7355] transition-colors leading-snug line-clamp-2">
                                            <a href="{{ route('blogs.show', $rel->slug) }}">{{ $rel->title }}</a>
                                        </h4>
                                    </div>
                                    <a href="{{ route('blogs.show', $rel->slug) }}" class="inline-flex items-center gap-1.5 font-brand text-[8px] uppercase tracking-widest font-bold text-[#1c1917] hover:text-[#8b7355] transition-colors pt-2">
                                        Explore Read
                                        <svg class="w-2.5 h-2.5 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </article>

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
