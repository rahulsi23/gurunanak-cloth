@if(($content['layout_mode'] ?? 'image') === 'video' && !empty($content['video']))
    <!-- 1. Ultra Luxury Cinematic Background Video Hero Section -->
    <style>
        @keyframes revealUp {
            0% {
                opacity: 0;
                transform: translateY(35px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .reveal-up-1 {
            opacity: 0;
            animation: revealUp 1.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.15s;
        }
        .reveal-up-2 {
            opacity: 0;
            animation: revealUp 1.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.35s;
        }
        .reveal-up-3 {
            opacity: 0;
            animation: revealUp 1.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.55s;
        }

        /* 1. Liquid Gold Light Sweep on Buttons */
        @keyframes goldSweep {
            0% { left: -100%; }
            100% { left: 200%; }
        }
        .btn-gold-sweep {
            position: relative;
            overflow: hidden !important;
        }
        .btn-gold-sweep::before {
            content: '';
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(234, 228, 216, 0.35), transparent);
            transform: skewX(-25deg);
            animation: goldSweep 4.5s ease-in-out infinite;
        }

        /* 2. Bespoke Zari Shimmer on Headings */
        @keyframes zariShimmer {
            0%, 100% {
                text-shadow: 0 0 4px rgba(255,255,255,0.1);
            }
            50% {
                text-shadow: 0 0 15px rgba(234, 228, 216, 0.45), 0 0 3px rgba(234, 228, 216, 0.3);
            }
        }
        .zari-shimmer-text {
            animation: zariShimmer 6s ease-in-out infinite;
        }

        /* 4. Floating Scroll Down Indicator */
        @keyframes scrollFloat {
            0%, 100% { transform: translateY(0); opacity: 0.4; }
            50% { transform: translateY(8px); opacity: 0.95; }
        }
        .scroll-down-float {
            animation: scrollFloat 2.5s ease-in-out infinite;
        }
    </style>

    <section id="hero" class="relative overflow-hidden w-full h-[78vh] min-h-[580px] sm:min-h-[680px] flex items-center justify-center border-b border-[#eae4d8]/60 bg-slate-950 select-none">
        
        <!-- Background Loop Video (Muted & Loop) -->
        <video id="hero-bg-video" src="{{ $content['video'] }}" autoplay loop muted playsinline preload="auto" class="absolute inset-0 w-full h-full object-cover z-0 pointer-events-none opacity-70"></video>

        <!-- Dark Premium Overlay Layer to enhance readability -->
        <div class="absolute inset-0 bg-[#1c1917]/45 backdrop-blur-[1px] z-10 pointer-events-none"></div>

        <!-- Ambient Warm Lighting Layer (Dynamic Glow) -->
        <div class="absolute top-1/4 left-1/4 w-[400px] h-[400px] bg-[#8b7355]/10 rounded-full blur-3xl pointer-events-none z-10"></div>

        <!-- Front Content Container with Cinema Glassmorphic Framing Card -->
        <div class="relative z-20 max-w-4xl mx-auto px-6 text-center">
            
            <div class="max-w-3xl mx-auto px-6 py-8 sm:py-12 sm:px-12 bg-[#1c1917]/25 backdrop-blur-[2px] border border-white/5 shadow-2xl rounded-none space-y-6 sm:space-y-8">
                @if($content['badge'] ?? null)
                    <span class="reveal-up-1 text-[9px] sm:text-[11px] uppercase tracking-[0.3em] font-semibold text-[#eae4d8] bg-white/10 w-max px-4 py-1.5 border border-white/20 shadow-lg rounded-none mx-auto block mb-2 backdrop-blur-md">
                        {{ $content['badge'] }}
                    </span>
                @endif

                @php
                    $titleRaw = $content['title'] ?? 'Natural Fabrics. <br><span class="font-bold">Honest Tailoring.</span>';
                    
                    if (strpos($titleRaw, '<') !== false) {
                        $parsedTitle = $titleRaw;
                    } else {
                        $titleText = trim($titleRaw);
                        $parts = [];
                        if (strpos($titleText, '|') !== false) {
                            $parts = explode('|', $titleText);
                        } elseif (strpos($titleText, "\n") !== false) {
                            $parts = explode("\n", $titleText);
                        } else {
                            $words = explode(' ', $titleText);
                            if (count($words) > 1) {
                                $lastWord = array_pop($words);
                                $firstPart = implode(' ', $words);
                                $parts = [$firstPart, $lastWord];
                            } else {
                                $parts = [$titleText, ''];
                            }
                        }
                        $line1 = trim($parts[0] ?? '');
                        $line2 = trim($parts[1] ?? '');
                        if (!empty($line2)) {
                            $parsedTitle = $line1 . ' <br><span class="font-bold text-[#eae4d8]">' . $line2 . '</span>';
                        } else {
                            $parsedTitle = $line1;
                        }
                    }
                    
                    // Keep title highly legible on dark video layer by neutralizing dark text-transparent gradients
                    $parsedTitle = str_replace('text-transparent', 'text-white', $parsedTitle);
                    $parsedTitle = str_replace('from-[#1c1917]', '', $parsedTitle);
                    $parsedTitle = str_replace('bg-clip-text', '', $parsedTitle);
                    $parsedTitle = str_replace('via-[#431407]', '', $parsedTitle);
                    $parsedTitle = str_replace('to-[#8b7355]', '', $parsedTitle);
                @endphp

                <div class="reveal-up-1">
                    <h1 class="zari-shimmer-text font-brand text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl text-white font-light tracking-tight leading-[1.1] drop-shadow-md">
                        {!! $parsedTitle !!}
                    </h1>
                </div>

                <div class="reveal-up-2">
                    <p class="text-xs sm:text-sm md:text-base text-[#eae4d8]/90 font-light max-w-xl mx-auto leading-relaxed drop-shadow-sm">
                        {{ $content['subtitle'] ?? '' }}
                    </p>
                </div>

                <!-- Premium CTA Buttons -->
                <div class="reveal-up-3 space-y-6 sm:space-y-8">
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                        @if($content['button1_text'] ?? null)
                            <a href="{{ url($content['button1_url'] ?? '/') }}" class="btn-gold-sweep w-full sm:w-auto text-center py-4 px-10 bg-white text-[#1c1917] font-brand text-xs uppercase tracking-[0.2em] font-bold hover:bg-[#8b7355] hover:text-white hover:shadow-[0_0_35px_rgba(255,255,255,0.3)] motion-soft transition-all duration-300">
                                {{ $content['button1_text'] }}
                            </a>
                        @endif
                        @if($content['button2_text'] ?? null)
                            <a href="{{ url($content['button2_url'] ?? '/') }}" class="btn-gold-sweep w-full sm:w-auto text-center py-4 px-10 border border-white/60 bg-white/10 backdrop-blur-md text-white font-brand text-xs uppercase tracking-[0.2em] font-medium hover:bg-white hover:text-[#1c1917] transition-all duration-300">
                                {{ $content['button2_text'] }}
                            </a>
                        @endif
                    </div>

                    <!-- Subtle premium feature markers at the bottom center -->
                    <div class="pt-2 flex items-center justify-center gap-6 sm:gap-10 text-[9px] sm:text-[11px] uppercase tracking-widest text-[#eae4d8]/80 font-brand">
                        <div>
                            <strong class="font-bold block text-white text-xs sm:text-sm mb-0.5">100%</strong>
                            <span>Natural Fabrics</span>
                        </div>
                        <div class="h-6 w-[1px] bg-white/20"></div>
                        <div>
                            <strong class="font-bold block text-white text-xs sm:text-sm mb-0.5">35+ Years</strong>
                            <span>Family Heritage</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Minimalist Glass Play/Pause Controller -->
        <button onclick="toggleHeroVideoPlay()" id="hero-video-toggle-btn" class="absolute bottom-6 left-6 bg-black/45 backdrop-blur-md p-3 text-[#eae4d8] border border-white/10 shadow-xl z-20 hover:bg-white hover:text-[#1c1917] hover:scale-110 transition-all rounded-full flex items-center justify-center" title="Pause Background Cinematic">
            <svg id="hero-video-toggle-icon" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
            </svg>
        </button>

        <script>
            function toggleHeroVideoPlay() {
                const video = document.getElementById('hero-bg-video');
                const btn = document.getElementById('hero-video-toggle-btn');
                const icon = document.getElementById('hero-video-toggle-icon');
                
                if (!video) return;
                
                if (video.paused) {
                    video.play();
                    btn.setAttribute('title', 'Pause Background Cinematic');
                    icon.innerHTML = '<path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>'; // Pause SVG icon
                } else {
                    video.pause();
                    btn.setAttribute('title', 'Play Background Cinematic');
                    icon.innerHTML = '<path d="M8 5v14l11-7z"/>'; // Play SVG icon
                }
            }
        </script>

        <!-- Floating Editorial Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-2 pointer-events-none select-none">
            <span class="font-brand text-[8px] sm:text-[9px] uppercase tracking-[0.35em] text-[#eae4d8]/75">Discover</span>
            <div class="scroll-down-float w-[1px] h-9 bg-gradient-to-b from-[#eae4d8]/90 via-[#8b7355]/40 to-transparent"></div>
        </div>

        <!-- Bespoke Golden Threads Border (Liquid Gold Accent) -->
        <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-[#8b7355]/50 to-transparent z-20 animate-pulse"></div>

        @if($content['look_label'] ?? null)
            <span class="absolute bottom-6 right-6 bg-black/45 backdrop-blur-md py-1.5 px-3.5 text-[9px] font-brand font-bold uppercase tracking-widest text-[#eae4d8] border border-white/10 shadow-lg z-20">
                {{ $content['look_label'] }}
            </span>
        @endif

    </section>
@else
    <!-- 2. Original Zara-Style Clean Split Grid Layout (Fallback) -->
    <section id="hero" class="relative overflow-hidden bg-gradient-to-b from-[#fdfbf7] via-[#faf8f5] to-white py-12 md:py-16 border-b border-[#eae4d8]/60">
        <!-- Ambient Warm Lighting Layer -->
        <div class="absolute top-0 left-1/3 w-[500px] h-[500px] bg-[#8b7355]/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-[#f5efe6] rounded-full blur-2xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 sm:px-8 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center relative z-10">
            
            <!-- Headline & Content Area -->
            <div class="lg:col-span-5 space-y-6 text-left order-2 lg:order-1">
                @if($content['badge'] ?? null)
                <span class="text-xs uppercase tracking-[0.25em] font-semibold text-[#9a3412] block bg-[#f5efe6] w-max px-3 py-1 border border-[#eae4d8]/80 shadow-sm rounded-none">
                    {{ $content['badge'] }}
                </span>
                @endif
                
                @php
                    $titleRaw = $content['title'] ?? 'Natural Fabrics. <br><span class="font-bold">Honest Tailoring.</span>';
                    
                    if (strpos($titleRaw, '<') !== false) {
                        $parsedTitle = $titleRaw;
                    } else {
                        $titleText = trim($titleRaw);
                        $parts = [];
                        
                        if (strpos($titleText, '|') !== false) {
                            $parts = explode('|', $titleText);
                        } elseif (strpos($titleText, "\n") !== false) {
                            $parts = explode("\n", $titleText);
                        } else {
                            $words = explode(' ', $titleText);
                            if (count($words) > 1) {
                                $lastWord = array_pop($words);
                                $firstPart = implode(' ', $words);
                                $parts = [$firstPart, $lastWord];
                            } else {
                                $parts = [$titleText, ''];
                            }
                        }
                        
                        $line1 = trim($parts[0] ?? '');
                        $line2 = trim($parts[1] ?? '');
                        
                        if (!empty($line2)) {
                            $parsedTitle = $line1 . ' <br><span class="font-bold bg-gradient-to-r from-[#1c1917] via-[#431407] to-[#8b7355] bg-clip-text text-transparent">' . $line2 . '</span>';
                        } else {
                            $parsedTitle = $line1;
                        }
                    }
                @endphp
                <h1 class="font-brand text-4xl sm:text-5xl lg:text-6xl text-[#1c1917] font-normal tracking-tight leading-[1.15]">
                    {!! $parsedTitle !!}
                </h1>
                
                <p class="text-sm text-[#475569] font-normal max-w-md leading-relaxed">
                    {{ $content['subtitle'] ?? '' }}
                </p>

                <!-- Premium CTA Buttons -->
                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    @if($content['button1_text'] ?? null)
                    <a href="{{ url($content['button1_url'] ?? '/') }}" class="text-center py-3.5 px-8 bg-[#0f172a] text-white font-brand text-xs uppercase tracking-[0.15em] font-medium hover:bg-[#8b7355] hover:shadow-[0_0_30px_rgba(139,115,85,0.45)] motion-soft transition-all duration-300">
                        {{ $content['button1_text'] }}
                    </a>
                    @endif
                    @if($content['button2_text'] ?? null)
                    <a href="{{ url($content['button2_url'] ?? '/') }}" class="text-center py-3.5 px-8 bg-white/90 backdrop-blur-sm border border-[#eae4d8] text-[#1c1917] font-brand text-xs uppercase tracking-[0.15em] font-medium hover:bg-[#f5efe6] hover:shadow-[0_0_25px_rgba(139,115,85,0.15)] motion-soft transition-all duration-300">
                        {{ $content['button2_text'] }}
                    </a>
                    @endif
                </div>

                <div class="pt-8 border-t border-[#eae4d8] flex items-center gap-8 text-[11px] text-[#8b7355]">
                    <div>
                        <strong class="font-brand font-bold block text-[#1c1917]">100%</strong>
                        <span>Natural Fibers</span>
                    </div>
                    <div>
                        <strong class="font-brand font-bold block text-[#1c1917]">Honest</strong>
                        <span>Custom Tailoring</span>
                    </div>
                </div>
            </div>

            <!-- Realistic Premium Fashion Banner Photo -->
            <div class="lg:col-span-7 order-1 lg:order-2">
                <div class="h-[320px] sm:h-[400px] lg:h-[480px] w-full rounded-none overflow-hidden bg-[#f5efe6] relative shadow-[0_20px_50px_rgba(139,115,85,0.15)] border border-[#eae4d8] transition-all duration-700 hover:shadow-[0_30px_70px_rgba(139,115,85,0.25)]">
                    <img src="{{ $content['image'] ?? '' }}" alt="Hero Presentation" fetchpriority="high" class="w-full h-full object-cover object-top hover:scale-[1.03] motion-soft duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a]/10 via-transparent to-transparent pointer-events-none"></div>
                    @if($content['look_label'] ?? null)
                    <span class="absolute bottom-4 right-4 bg-white/95 backdrop-blur-md py-1.5 px-3 text-[10px] font-brand font-bold uppercase tracking-widest text-[#9a3412] shadow-sm border border-[#eae4d8]">
                        {{ $content['look_label'] }}
                    </span>
                    @endif
                </div>
            </div>

        </div>
    </section>
@endif
