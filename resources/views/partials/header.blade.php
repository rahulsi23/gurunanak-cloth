<!-- 1. Top Announcement Bar (Smooth Infinite Marquee Loop) -->
<div id="announcement-bar" class="bg-[#f5efe6] py-2.5 overflow-hidden border-b border-[#eae4d8] select-none whitespace-nowrap flex items-center">
    <div class="inline-flex animate-marquee items-center font-brand text-[10px] sm:text-[11px] uppercase tracking-[0.2em] text-[#786451] font-medium">
        <div class="flex items-center shrink-0">
            <span class="mx-6">{!! $settings['announcement_text'] ?? '✨ FREE SHIPPING ON ORDERS OVER $150 &bull; SUMMER SALE: EXTRA 20% OFF AT CHECKOUT &bull; QUALITY PACKAGING ON ALL ORDERS &bull;' !!}</span>
        </div>
        <div class="flex items-center shrink-0">
            <span class="mx-6">{!! $settings['announcement_text'] ?? '✨ FREE SHIPPING ON ORDERS OVER $150 &bull; SUMMER SALE: EXTRA 20% OFF AT CHECKOUT &bull; QUALITY PACKAGING ON ALL ORDERS &bull;' !!}</span>
        </div>
    </div>
</div>

<header id="main-header" class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-[#eae4d8]/60 shadow-[0_4px_30px_rgba(139,115,85,0.08)] transition-all duration-500">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 h-20 flex items-center justify-between gap-2.5">
        
        <!-- Luxury Fashion Logo -->
        <a href="{{ url('/') }}" class="shrink-0 flex items-center justify-center select-none group">
            @if(($settings['logo_type'] ?? 'text') === 'image' && !empty($settings['logo_image']))
                <img src="{{ asset('storage/' . $settings['logo_image']) }}" alt="{{ $settings['logo_text'] ?? 'GURUNANAK' }}" class="h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            @else
                <div class="flex flex-col justify-center">
                    <span class="font-brand font-extrabold text-base sm:text-lg tracking-[0.25em] text-[#1c1917] leading-none group-hover:text-[#8b7355] transition-colors duration-300">
                        {{ $settings['logo_text'] ?? 'GURUNANAK' }}
                    </span>
                    <span class="font-sans font-medium text-[8px] sm:text-[9px] tracking-[0.45em] uppercase text-[#8b7355] block mt-1">
                        {{ $settings['logo_subtitle'] ?? 'CLOTH HOUSE' }}
                    </span>
                </div>
            @endif
        </a>

        <!-- Navigation Links -->
        <nav class="hidden xl:flex items-center gap-2.5 2xl:gap-4.5 font-brand text-[11px] 2xl:text-[13px] uppercase tracking-[0.05em] 2xl:tracking-[0.08em] text-[#292524] font-semibold shrink">
            @foreach($menus as $menu)
                <div class="relative group py-2">
                    <a href="{{ url($menu->url) }}" class="{{ request()->is(trim($menu->url, '/')) ? 'text-[#8b7355] border-b border-[#8b7355]' : 'hover:text-[#8b7355]' }} pb-0.5 whitespace-nowrap motion-soft transition-colors flex items-center gap-1">
                        {{ $menu->label }}
                        @if($menu->children->count() > 0)
                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        @endif
                    </a>
                    
                    @if($menu->children->count() > 0)
                        <div class="absolute top-full left-0 w-48 bg-white border border-[#eae4d8] shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[60]">
                            @foreach($menu->children as $child)
                                <a href="{{ url($child->url) }}" class="block px-4 py-2 text-[10px] text-[#44403c] hover:text-[#8b7355] hover:bg-[#f5efe6]/30 transition-colors">
                                    {{ $child->label }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>

        <!-- Right Icons Area -->
        <div class="flex items-center gap-1.5 sm:gap-2 2xl:gap-3 text-[#44403c] relative shrink-0" id="header-search-container">
            
            <!-- Predictive inline keyword trigger input -->
            <div class="relative flex items-center">
                <input type="text" 
                       id="header-predictive-input" 
                       oninput="triggerCheckoutPhotoAutocomplete(this.value)"
                       onfocus="triggerCheckoutPhotoAutocomplete(this.value)"
                       placeholder="Search..." 
                       class="w-20 sm:w-36 xl:w-20 2xl:w-40 bg-[#fdfbf7] border border-[#eae4d8] py-1.5 pl-2.5 pr-6 text-[10px] 2xl:text-[11px] focus:outline-none focus:border-[#8b7355] transition-all rounded-none placeholder:text-[#a08a75]">
                
                <svg class="w-3.5 h-3.5 absolute right-2 text-[#a08a75] pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                
                <!-- Real-Time Thumbnails Dropdown Matrix -->
                <div id="predictive-search-dropdown" class="absolute right-0 top-full mt-2 w-72 sm:w-80 bg-white border border-[#8b7355]/40 shadow-2xl z-50 hidden max-h-96 overflow-y-auto divide-y divide-[#eae4d8]/60 text-left">
                </div>
            </div>

            <!-- Wishlist Icon -->
            <a href="{{ route('wishlist.index') }}" class="p-1 hover:text-[#8b7355] motion-soft transition-colors shrink-0 relative" aria-label="Wishlist" title="Wishlist">
                <svg class="w-4 h-4 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                @auth
                    @php $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count(); @endphp
                    @if($wishlistCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-[#9a3412] text-white flex items-center justify-center text-[8px] font-bold rounded-full shadow-xs">{{ $wishlistCount }}</span>
                    @endif
                @endauth
            </a>

            <!-- Shopping Bag button -->
            <a href="{{ route('shop.index') }}" class="p-1 hover:text-[#8b7355] motion-soft transition-colors relative flex items-center gap-1.5 shrink-0" aria-label="Shopping Bag" title="Shopping Bag">
                <svg class="w-4 h-4 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span id="bag-header-pill" class="text-[10px] font-brand font-medium bg-[#8b7355] text-white px-1.5 py-0.5 rounded-full shadow-xs min-w-[16px] text-center">0</span>
            </a>

            <!-- User Profile / Auth Icon -->
            <a href="{{ route('dashboard') }}" class="p-1 hover:text-[#8b7355] motion-soft transition-colors shrink-0 relative flex items-center justify-center" aria-label="Account" title="My Account">
                <svg class="w-4 h-4 stroke-[1.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                @auth
                    <span class="absolute top-0 right-0 w-1.5 h-1.5 bg-[#8b7355] rounded-full"></span>
                @endauth
            </a>

        </div>
    </div>
</header>

<!-- Mobile Secondary Menu Strip (Visible only on mobile screens) -->
<div class="block xl:hidden bg-[#fafafa] border-b border-[#eae4d8] overflow-x-auto no-scrollbar py-2.5 px-4 shadow-[inset_0_-2px_10px_rgba(139,115,85,0.03)]">
    <nav class="flex items-center justify-start gap-6 font-brand text-[10px] uppercase tracking-widest text-[#786451] min-w-max">
        @foreach($menus as $menu)
            <div class="flex flex-col gap-1">
                <a href="{{ url($menu->url) }}" class="{{ request()->is(trim($menu->url, '/')) ? 'text-[#8b7355] font-semibold border-b border-[#8b7355]' : 'hover:text-[#8b7355]' }} pb-0.5 whitespace-nowrap">{{ $menu->label }}</a>
                @if($menu->children->count() > 0)
                    <div class="flex gap-3 text-[8px] text-[#a08a75] font-normal">
                        @foreach($menu->children as $child)
                            <a href="{{ url($child->url) }}" class="hover:text-[#8b7355]">{{ $child->label }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </nav>
</div>

<!-- Autocomplete & Sync Bag Scripts -->
<script>
    const globalCatalogJS = @json($catalog ?? []);
    const CART_STORAGE_KEY = 'gurunanak_bespoke_bag';

    function triggerCheckoutPhotoAutocomplete(query) {
        const container = document.getElementById('predictive-search-dropdown');
        const queryClean = query.toLowerCase().trim();

        if (queryClean.length === 0) {
            container.classList.add('hidden');
            return;
        }

        fetch("{{ route('api.search.suggestions') }}?q=" + encodeURIComponent(queryClean))
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    let resultsHTML = '';
                    data.forEach(item => {
                        resultsHTML += `
                            <a href="{{ route('product.detail', '') }}/${item.slug}" class="flex items-center gap-3 p-2.5 hover:bg-[#f5efe6]/70 transition-colors block text-left group">
                                <img src="${item.image}" alt="${item.title}" class="w-10 h-11 object-cover object-top shrink-0 border border-[#eae4d8]">
                                <div class="min-w-0 flex-1">
                                    <div class="text-xs font-semibold text-[#1c1917] group-hover:text-[#9a3412] truncate transition-colors">
                                        ${item.title}
                                    </div>
                                    <div class="text-[10px] text-[#8b7355] font-brand font-bold mt-0.5 flex items-center gap-1.5">
                                        <span>$${parseFloat(item.price).toFixed(2)}</span>
                                        <span class="text-[#eae4d8]">|</span>
                                        <span class="uppercase tracking-wider text-[9px] text-[#a08a75] font-medium">${item.lookbook || 'Collection'} • ${item.category || 'Apparel'}</span>
                                    </div>
                                </div>
                                <span class="text-[10px] text-[#8b7355] font-bold opacity-0 group-hover:opacity-100 transition-opacity shrink-0 pr-1">▸ View</span>
                            </a>
                        `;
                    });
                    container.innerHTML = resultsHTML;
                    container.classList.remove('hidden');
                } else {
                    renderLocalFallbackSearch(queryClean, container);
                }
            })
            .catch(err => {
                renderLocalFallbackSearch(queryClean, container);
            });
    }

    function renderLocalFallbackSearch(queryClean, container) {
        let resultsHTML = '';
        let matchesFound = 0;

        for (const key in globalCatalogJS) {
            const item = globalCatalogJS[key];
            const matchString = (item.title + ' ' + (item.parent_cat || '') + ' ' + (item.sub_cat || '')).toLowerCase();
            
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
                                <span class="uppercase tracking-wider text-[9px] text-[#a08a75] font-medium">${item.parent_cat || 'Collection'} • ${item.sub_cat || 'Apparel'}</span>
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
                    No products found matching "${queryClean}".
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

    function syncHeaderBagCounter() {
        try {
            const raw = localStorage.getItem(CART_STORAGE_KEY);
            const items = raw ? JSON.parse(raw) : [];
            const totalQty = items.reduce((sum, item) => sum + parseInt(item.qty), 0);
            const pill = document.getElementById('bag-header-pill');
            if(pill) pill.innerText = totalQty;
        } catch(e){}
    }

    window.addEventListener('DOMContentLoaded', () => {
        syncHeaderBagCounter();
    });
    syncHeaderBagCounter();
</script>
