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
    <title>{{ $settings['contact_meta_title'] ?? 'Contact Us | Gurunanak Cloth House' }}</title>
    <meta name="description" content="{{ $settings['contact_meta_description'] ?? 'Contact Gurunanak Cloth House. Reach out by phone, email, or visit our retail store on Mall Road in Amritsar.' }}">
    @if(!empty($settings['contact_meta_keywords']))
        <meta name="keywords" content="{{ $settings['contact_meta_keywords'] }}">
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

    <!-- 3. Contact Presentation Layout -->
    <main class="py-16 md:py-24">
        <div class="max-w-[1200px] mx-auto px-6">
            
            <!-- Headline block -->
            <div class="text-center max-w-3xl mx-auto mb-16 md:mb-24">
                <span class="font-brand text-[10px] uppercase tracking-[0.3em] text-[#8b7355] font-semibold block mb-4">GET IN TOUCH</span>
                <h1 class="font-brand font-black text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#1c1917] tracking-tight leading-[1.1] mb-6">
                    {!! nl2br(e($settings['contact_heading'] ?? 'Contact Us')) !!}
                </h1>
                <div class="w-12 h-0.5 bg-[#8b7355] mx-auto mb-8"></div>
                <p class="text-sm md:text-base text-[#786451] font-light leading-relaxed max-w-2xl mx-auto">
                    {{ $settings['contact_content'] ?? 'Have questions about sizing, fabrics, or an existing order? Call, email, or stop by our store.' }}
                </p>
            </div>

            <!-- Main Layout: Contact Coordinates & Form cards -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left 5 cols: Direct Contact Portals -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <!-- Card 1: Telephone support -->
                    <div class="bg-white border border-[#eae4d8]/80 hover:border-[#8b7355]/40 p-8 rounded-3xl shadow-md transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#f5efe6] flex items-center justify-center text-[#8b7355] shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="space-y-1">
                                <span class="font-brand text-[9px] uppercase tracking-widest text-[#8b7355] font-bold block">PHONE</span>
                                <h4 class="font-brand font-bold text-base text-[#1c1917] tracking-tight">Call Us</h4>
                                <p class="text-xs text-[#786451] leading-relaxed">Mon to Sat from 10:00 to 20:00.</p>
                                <a href="tel:{{ $settings['contact_phone'] ?? '+919876543210' }}" class="inline-block text-xs font-semibold text-[#1c1917] group-hover:text-[#8b7355] transition-colors pt-2">{{ $settings['contact_phone'] ?? '+91 98765 43210' }}</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Email support -->
                    <div class="bg-white border border-[#eae4d8]/80 hover:border-[#8b7355]/40 p-8 rounded-3xl shadow-md transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#f5efe6] flex items-center justify-center text-[#8b7355] shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="space-y-1">
                                <span class="font-brand text-[9px] uppercase tracking-widest text-[#8b7355] font-bold block">EMAIL</span>
                                <h4 class="font-brand font-bold text-base text-[#1c1917] tracking-tight">Email Us</h4>
                                <p class="text-xs text-[#786451] leading-relaxed">We usually respond within one business day.</p>
                                <a href="mailto:{{ $settings['contact_email'] ?? 'studio@gurunanak.com' }}" class="inline-block text-xs font-semibold text-[#1c1917] group-hover:text-[#8b7355] transition-colors pt-2">{{ $settings['contact_email'] ?? 'studio@gurunanak.com' }}</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Location -->
                    <div class="bg-white border border-[#eae4d8]/80 hover:border-[#8b7355]/40 p-8 rounded-3xl shadow-md transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#f5efe6] flex items-center justify-center text-[#8b7355] shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="space-y-1">
                                <span class="font-brand text-[9px] uppercase tracking-widest text-[#8b7355] font-bold block">LOCATION</span>
                                <h4 class="font-brand font-bold text-base text-[#1c1917] tracking-tight">Visit Our Store</h4>
                                <p class="text-xs text-[#786451] leading-relaxed font-light">{{ $settings['contact_address'] ?? 'Mall Road, Amritsar, Punjab, India' }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right 7 cols: Interactive Dynamic Form & Image Banner -->
                <div class="lg:col-span-7 space-y-8">
                    
                    @if(!empty($settings['contact_image']))
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-[#eae4d8]/40 h-64 sm:h-80 group">
                            <img src="{{ asset('storage/' . $settings['contact_image']) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-[#1c1917]/10"></div>
                        </div>
                    @else
                        <!-- Google Maps Map frame placeholder -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-[#eae4d8]/60 h-64 sm:h-80 bg-[#f5efe6]/40 flex items-center justify-center p-8 text-center">
                            <div class="space-y-2 max-w-sm">
                                <span class="font-brand text-[10px] uppercase tracking-widest text-[#8b7355] font-bold block">OUR STORE</span>
                                <p class="text-xs text-[#786451] font-light">Visit our retail shop on Mall Road, Amritsar. Open daily 10:00 - 20:00.</p>
                                <a href="https://maps.google.com/?q={{ urlencode($settings['contact_address'] ?? 'Amritsar Mall Road India') }}" target="_blank" class="inline-block px-4 py-2 border border-[#8b7355] hover:bg-[#8b7355] hover:text-white rounded-full text-[10px] font-brand uppercase tracking-wider font-bold transition-all mt-4 text-[#8b7355]">Open in Google Maps</a>
                            </div>
                        </div>
                    @endif

                    <!-- Inquiry Form -->
                    <div class="bg-white border border-[#eae4d8]/80 p-8 sm:p-10 rounded-3xl shadow-xl space-y-6">
                        <div class="border-b border-[#eae4d8]/60 pb-4">
                            <h3 class="font-brand font-bold text-lg text-[#1c1917] tracking-tight">Send a Message</h3>
                            <p class="text-[10px] text-[#786451] font-light">Leave your details and we will get back to you shortly.</p>
                        </div>
                        
                        <form onsubmit="event.preventDefault(); alert('Thank you for reaching out! We will reply to your email shortly.')" class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="text" placeholder="Your Name" required class="w-full bg-[#fcfbf9] border border-[#eae4d8] rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-[#8b7355] transition-all">
                                <input type="email" placeholder="Email Address" required class="w-full bg-[#fcfbf9] border border-[#eae4d8] rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-[#8b7355] transition-all">
                            </div>
                            <input type="text" placeholder="Subject (e.g. Sizing question, Order status)" required class="w-full bg-[#fcfbf9] border border-[#eae4d8] rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-[#8b7355] transition-all">
                            <textarea placeholder="Write your message here..." required rows="4" class="w-full bg-[#fcfbf9] border border-[#eae4d8] rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-[#8b7355] transition-all leading-relaxed"></textarea>
                            <button type="submit" class="w-full py-3 bg-[#1c1917] hover:bg-[#292524] text-white rounded-xl text-xs font-brand uppercase tracking-widest font-bold shadow-lg shadow-black/10 transition-all duration-300">Send Message</button>
                        </form>
                    </div>

                </div>

            </div>

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
