@if(isset($footerMenus) && $footerMenus->count() > 0)
    @foreach($footerMenus as $column)
        <!-- Dynamic Footer Column: {{ $column->label }} -->
        <div class="space-y-3">
            <h5 class="font-brand text-xs uppercase tracking-widest font-semibold text-[#292524]">{{ $column->label }}</h5>
            <nav class="flex flex-col space-y-2 text-xs text-[#786451]">
                @foreach($column->children as $link)
                    <a href="{{ url($link->url) }}" class="hover:text-[#8b7355] motion-soft">{{ $link->label }}</a>
                @endforeach
            </nav>
        </div>
    @endforeach
@else
    <!-- Fallback Col 2: Quick Links -->
    <div class="space-y-3">
        <h5 class="font-brand text-xs uppercase tracking-widest font-semibold text-[#292524]">Quick Links</h5>
        <nav class="flex flex-col space-y-2 text-xs text-[#786451]">
            <a href="{{ url('/') }}" class="hover:text-[#8b7355] motion-soft">Shop All</a>
            <a href="{{ url('/#about') }}" class="hover:text-[#8b7355] motion-soft">Our Story</a>
            <a href="{{ url('/#reviews') }}" class="hover:text-[#8b7355] motion-soft">Reviews</a>
            <a href="{{ url('/blogs') }}" class="hover:text-[#8b7355] motion-soft">Blog</a>
            <a href="#" class="hover:text-[#8b7355] motion-soft">Track Order</a>
        </nav>
    </div>

    <!-- Fallback Col 3: Collections -->
    <div class="space-y-3">
        <h5 class="font-brand text-xs uppercase tracking-widest font-semibold text-[#292524]">Collections</h5>
        <nav class="flex flex-col space-y-2 text-xs text-[#786451]">
            <a href="{{ route('collection.men') }}" class="hover:text-[#8b7355] motion-soft">Men's Collection</a>
            <a href="{{ route('collection.women') }}" class="hover:text-[#8b7355] motion-soft">Women's Collection</a>
            <a href="{{ url('/#new-arrivals') }}" class="hover:text-[#8b7355] motion-soft">New Arrivals</a>
            <a href="{{ url('/#best-sellers') }}" class="hover:text-[#8b7355] motion-soft">Best Sellers</a>
        </nav>
    </div>
@endif

@if(isset($settings['whatsapp_enabled']) && $settings['whatsapp_enabled'] == '1' && !empty($settings['whatsapp_phone']))
    <!-- Floating WhatsApp support widget -->
    @php
        $wpPhone = preg_replace('/[^0-9]/', '', $settings['whatsapp_phone']);
        $wpMessage = urlencode($settings['whatsapp_message'] ?? 'Hello! I need support regarding my order.');
        $wpColor = $settings['whatsapp_color'] ?? '#25D366';
        $wpPulse = ($settings['whatsapp_pulse'] ?? '1') == '1';
    @endphp

    <div class="fixed bottom-6 right-6 z-[9999] no-print">
        <a href="https://wa.me/{{ $wpPhone }}?text={{ $wpMessage }}" target="_blank" rel="noopener noreferrer" class="relative group flex items-center justify-center w-14 h-14 rounded-full shadow-2xl transition-all duration-300 hover:scale-110 active:scale-95" style="background-color: {{ $wpColor }};">
            
            @if($wpPulse)
                <!-- Pulsing Glow rings -->
                <span class="absolute inset-0 rounded-full animate-ping opacity-75" style="border: 2px solid {{ $wpColor }};"></span>
                <span class="absolute inset-0 rounded-full animate-pulse opacity-40" style="background-color: {{ $wpColor }};"></span>
            @endif

            <!-- WhatsApp Icon -->
            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.625 1.451 5.48-.002 9.936-4.394 9.94-9.782.002-2.61-1.013-5.064-2.858-6.911a9.882 9.882 0 00-6.96-2.768C5.932 2.14 1.474 6.534 1.47 11.924c-.001 1.547.411 3.055 1.196 4.39l-.994 3.63 3.784-.962c1.3.708 2.679 1.134 4.191 1.134zM17.447 14.39c-.324-.162-1.917-.946-2.21-1.053-.293-.108-.507-.162-.72.162-.213.324-.826 1.054-1.013 1.27-.187.215-.373.242-.697.079a8.775 8.775 0 01-2.589-1.597 9.68 9.68 0 01-1.792-2.23c-.187-.324-.02-.5-.182-.661-.147-.146-.324-.378-.485-.567-.162-.189-.215-.324-.322-.54-.108-.217-.054-.405-.027-.567.12-.178.265-.359.406-.533.14-.174.24-.22.36-.06.12.16.81.99.88 1.08.07.09.11.2.04.31-.07.11-.79.91-.79.91s-.08.09-.01.21c.07.12.31.51.66.82.45.4 1.15.82 1.63.99.36.13.56.09.7-.07.14-.16.6-.7.76-.94.16-.24.31-.2.53-.12.22.08 1.4.66 1.64.78.24.12.4.18.45.28.06.1.06.57-.16 1.01-.22.44-1.32.86-1.83.88-.51.02-2.93-.93-4.3-2.15z"/>
            </svg>

            <!-- Tooltip text on hover -->
            <span class="absolute right-16 scale-0 transition-all duration-300 origin-right group-hover:scale-100 bg-slate-900 text-white text-[10px] font-semibold tracking-wider uppercase px-3 py-1.5 rounded-lg border border-slate-800 whitespace-nowrap shadow-xl">
                Chat with Us
            </span>
        </a>
    </div>

    <!-- Inject CSS styles for animation keyframes -->
    <style>
        @keyframes ping {
            75%, 100% {
                transform: scale(2);
                opacity: 0;
            }
        }
        .animate-ping {
            animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        @keyframes pulse {
            50% {
                opacity: .25;
            }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
@endif
