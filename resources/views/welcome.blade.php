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

// Fetch global settings instantly from cache for 100/100 PageSpeed
$settings = \Illuminate\Support\Facades\Cache::rememberForever('store_settings', function () {
    return \App\Models\StoreSetting::all()->pluck('value', 'key')->toArray();
});
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(isset($pageSeo))
        <title>{{ $pageSeo->meta_title ?? 'GURUNANAK - Everyday Indian & Contemporary Wear' }}</title>
        <meta name="description" content="{{ $pageSeo->meta_description ?? 'Shop everyday cottons, wool coats, seasonal collections, and comfortable Indian wear from Gurunanak Cloth House.' }}">
        @if(!empty($pageSeo->meta_keywords))
            <meta name="keywords" content="{{ $pageSeo->meta_keywords }}">
        @endif
        <meta property="og:title" content="{{ $pageSeo->og_title ?? $pageSeo->meta_title }}">
        <meta property="og:description" content="{{ $pageSeo->og_description ?? $pageSeo->meta_description }}">
        @if(!empty($pageSeo->og_image))
            <meta property="og:image" content="{{ $pageSeo->og_image }}">
        @endif
    @else
        <title>GURUNANAK - Everyday Indian & Contemporary Wear</title>
        <meta name="description" content="Shop everyday cottons, wool coats, seasonal collections, and comfortable Indian wear from Gurunanak Cloth House.">
    @endif
    <!-- Premium Inter & Montserrat Typography -->
    <link rel="preload" as="image" href="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1400&q=80" fetchpriority="high">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Immediate runtime static CSS compiler rendering via stable Play CDN -->
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
    </style>
</head>
<body class="antialiased selection:bg-[#f5efe6] selection:text-[#8b7355] overflow-x-hidden text-[#1c1917] bg-[#fcfbf9]">

    @include('partials.header')

    <!-- Dynamic Sections Matrix -->
    @foreach($sections as $section)
        @include('sections.' . $section->section_type, ['content' => $section->content])
    @endforeach

    <!-- 11. Newsletter Section -->
    <section id="newsletter" class="py-12 sm:py-16 bg-[#fdfbf7] border-b border-[#eae4d8]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 space-y-4">
            <span class="text-[11px] font-brand uppercase tracking-[0.25em] text-[#8b7355] font-semibold block">
                Stay Updated
            </span>
            <h2 class="font-brand text-2xl sm:text-3xl text-[#292524] font-normal tracking-tight">
                Join Our Newsletter
            </h2>
            <p class="text-xs text-[#786451] font-normal leading-relaxed">
                Sign up to hear about new seasonal arrivals, occasional store discounts, and fabric updates.
            </p>
            
            <!-- Minimal input field -->
            <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to our updates!');" class="pt-2 flex flex-col sm:flex-row gap-3">
                <input type="email" required placeholder="yourname@email.com" class="bg-white border border-[#eae4d8] py-3.5 px-5 text-xs text-[#292524] placeholder-[#a08a75] focus:outline-none focus:border-[#8b7355] flex-1 shadow-sm">
                <button type="submit" class="py-3.5 px-8 bg-[#292524] hover:bg-[#8b7355] text-white font-brand text-xs uppercase tracking-widest font-medium motion-soft shadow-sm shrink-0">
                    Subscribe
                </button>
            </form>
            <span class="text-[10px] text-[#a08a75] block pt-1">We respect your privacy. You can unsubscribe anytime.</span>
        </div>
    </section>

    <!-- 12. Footer -->
    <footer id="footer" class="bg-white pt-12 pb-10 border-t border-[#f3f4f6]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            
            <!-- Multiple Columns -->
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
                    <p class="text-xs text-[#786451] font-normal max-w-sm leading-relaxed">
                        Gurunanak Cloth House makes comfortable everyday clothing using natural cottons, linens, and durable wool blends.
                    </p>
                    @if(!empty($settings['footer_qr_code']))
                        <div class="pt-1">
                            <span class="text-[9px] uppercase tracking-widest text-[#786451] block mb-1 font-bold">Scan to Connect</span>
                            <div class="w-16 h-16 bg-white p-1 border border-[#eae4d8] rounded-lg shadow-xs">
                                <img src="{{ asset('storage/' . $settings['footer_qr_code']) }}" alt="Contact QR Code" class="w-full h-full object-contain">
                            </div>
                        </div>
                    @endif
                    <!-- Social icons text strips -->
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

                <!-- Col 4: Support & Admin Tunnel -->
                <div class="space-y-3">
                    <h5 class="font-brand text-xs uppercase tracking-widest font-semibold text-[#1c1917]">Customer Support</h5>
                    <div class="text-xs text-[#475569] space-y-2">
                        <p>Email Us:<br><strong class="text-[#1c1917] font-semibold">support@gurunanak.com</strong></p>
                        <p>Hours:<br>Mon - Fri, 09:00 - 17:00</p>
                        <!-- Admin Access Link securely placed -->
                        <div class="pt-1">
                            <a href="{{ route('admin.login') }}" class="text-[10px] text-[#9a3412] font-brand uppercase tracking-wider font-semibold hover:underline block">
                                🔒 Admin Access
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Sub Footer & Payment Icons text simulation -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-[11px] text-[#475569]">
                <p>© {{ date('Y') }} Gurunanak Cloth House. Quality clothing made for everyday comfort.</p>
                
                <!-- Payment Providers Simulation strip -->
                <div class="flex items-center gap-3 text-[10px] font-brand uppercase tracking-widest text-[#1c1917] font-medium">
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Visa</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Mastercard</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">Amex</span>
                    <span class="px-2 py-0.5 border border-[#eae4d8] bg-[#f5efe6]/40">ApplePay</span>
                </div>
            </div>

        </div>
    </footer>

    <!-- Customer Help Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <div class="relative group">
            <button onclick="alert('Hello! How can we help you find the right size or outfit today?')" class="relative flex items-center gap-2.5 bg-[#1c1917] text-white px-5 py-3.5 rounded-full shadow-2xl border border-[#eae4d8]/40 hover:bg-[#292524] transition-all duration-300">
                <span class="relative flex h-2 w-2">
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#eae4d8]"></span>
                </span>
                <span class="font-brand text-[10px] font-bold uppercase tracking-[0.2em]">Questions? Chat with Us</span>
                <svg class="w-3.5 h-3.5 text-[#f5efe6]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </button>
        </div>
    </div>

</body>
</html>
