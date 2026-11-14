@extends('layouts.admin')

@section('title', 'Visual Branding Studio')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Visual Branding</span>
            <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Logo & Asset Management</h1>
            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                Configure your store branding. Upload premium graphics, toggle text/image brand headers, and secure watermarks.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs text-emerald-400 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.branding.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Card 1: Main Header Logo -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Store Header Logo</h3>
                    <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">Branding</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">Logo Style Option</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center p-3 rounded-lg border border-slate-800 bg-slate-950/60 hover:bg-slate-800/20 cursor-pointer text-xs font-semibold gap-2">
                            <input type="radio" name="logo_type" value="text" {{ ($settings['logo_type'] ?? 'text') === 'text' ? 'checked' : '' }} class="text-violet-600 focus:ring-0">
                            <span>Text Logo</span>
                        </label>
                        <label class="flex items-center justify-center p-3 rounded-lg border border-slate-800 bg-slate-950/60 hover:bg-slate-800/20 cursor-pointer text-xs font-semibold gap-2">
                            <input type="radio" name="logo_type" value="image" {{ ($settings['logo_type'] ?? 'text') === 'image' ? 'checked' : '' }} class="text-violet-600 focus:ring-0">
                            <span>Graphic Image</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Brand Main Title Text</label>
                        <input type="text" name="logo_text" value="{{ old('logo_text', $settings['logo_text'] ?? 'GURUNANAK') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500 font-brand font-bold tracking-[0.2em] uppercase">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Sub-label Subtitle Text</label>
                        <input type="text" name="logo_subtitle" value="{{ old('logo_subtitle', $settings['logo_subtitle'] ?? 'CLOTH HOUSE') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500 tracking-[0.3em] uppercase text-violet-400">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">Graphic Image Upload</label>
                    <div class="flex items-center gap-4 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-14 h-14 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0">
                            @if(!empty($settings['logo_image']))
                                <img src="{{ asset('storage/' . $settings['logo_image']) }}" class="w-full h-full object-contain p-1">
                            @else
                                <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="logo_image" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Recommended dimension: Transparent PNG (240x80px)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Footer Logo & Settings -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Footer Logo</h3>
                    <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">Footer</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">Footer Style Option</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center p-3 rounded-lg border border-slate-800 bg-slate-950/60 hover:bg-slate-800/20 cursor-pointer text-xs font-semibold gap-2">
                            <input type="radio" name="footer_logo_type" value="text" {{ ($settings['footer_logo_type'] ?? 'text') === 'text' ? 'checked' : '' }} class="text-violet-600 focus:ring-0">
                            <span>Text Logo</span>
                        </label>
                        <label class="flex items-center justify-center p-3 rounded-lg border border-slate-800 bg-slate-950/60 hover:bg-slate-800/20 cursor-pointer text-xs font-semibold gap-2">
                            <input type="radio" name="footer_logo_type" value="image" {{ ($settings['footer_logo_type'] ?? 'text') === 'image' ? 'checked' : '' }} class="text-violet-600 focus:ring-0">
                            <span>Graphic Image</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Footer Brand Text</label>
                    <input type="text" name="footer_logo_text" value="{{ old('footer_logo_text', $settings['footer_logo_text'] ?? 'GURUNANAK') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500 font-brand font-bold tracking-[0.2em] uppercase">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">Footer Graphic Image</label>
                    <div class="flex items-center gap-4 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-14 h-14 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0">
                            @if(!empty($settings['footer_logo_image']))
                                <img src="{{ asset('storage/' . $settings['footer_logo_image']) }}" class="w-full h-full object-contain p-1">
                            @else
                                <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="footer_logo_image" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Logo shown at the bottom footer.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Favicon Icon -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Browser Favicon</h3>
                    <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">Browser Tab</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">Favicon File</label>
                    <div class="flex items-center gap-4 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-12 h-12 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0">
                            @if(!empty($settings['favicon']))
                                <img src="{{ asset('storage/' . $settings['favicon']) }}" class="w-8 h-8 object-contain">
                            @else
                                <span class="text-xs text-slate-500 font-bold">Icon</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="favicon" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Upload .ico, .png, or .webp (32x32px) browser icon.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Global OG Share Image -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Default Open Graph Image</h3>
                    <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">WhatsApp / Social</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">OG Share Image File</label>
                    <div class="flex items-center gap-4 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-20 h-12 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0">
                            @if(!empty($settings['og_image']))
                                <img src="{{ asset('storage/' . $settings['og_image']) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="og_image" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Recommended size: 1200x630px for high-fidelity rendering.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 5: Image Watermark -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Product Image Watermark</h3>
                    <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">Security</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">Watermark Overlay graphic</label>
                    <div class="flex items-center gap-4 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-14 h-14 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0">
                            @if(!empty($settings['watermark']))
                                <img src="{{ asset('storage/' . $settings['watermark']) }}" class="w-full h-full object-contain p-1 bg-slate-950">
                            @else
                                <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="watermark" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Upload a light/semi-transparent PNG brand mark.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 6: Default Shop/Category Banner -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Default Shop Catalog Banner</h3>
                    <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">Banner</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">Banner Graphic File</label>
                    <div class="flex items-center gap-4 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-20 h-12 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0">
                            @if(!empty($settings['default_shop_banner']))
                                <img src="{{ asset('storage/' . $settings['default_shop_banner']) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="default_shop_banner" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Recommended size: 1920x600px luxury storefront banner.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 7: Footer QR Code -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4 md:col-span-2">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Footer Contact QR Code</h3>
                    <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">Quick Connect</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">QR Code Image</label>
                    <div class="flex items-center gap-4 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-14 h-14 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0">
                            @if(!empty($settings['footer_qr_code']))
                                <img src="{{ asset('storage/' . $settings['footer_qr_code']) }}" class="w-full h-full object-contain p-1">
                            @else
                                <svg class="w-6 h-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="footer_qr_code" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Upload a WhatsApp, Facebook, or custom store address QR Code.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 8: Social Profiles -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4 md:col-span-2">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Social Profiles</h3>
                    <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">Connect your social pages</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Facebook URL</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-500 font-bold text-xs">#</span>
                            <input type="text" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '#') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-8 pr-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Instagram URL</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-500 font-bold text-xs">#</span>
                            <input type="text" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '#') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-8 pr-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Twitter URL</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-500 font-bold text-xs">#</span>
                            <input type="text" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '#') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-8 pr-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">LinkedIn URL</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-500 font-bold text-xs">#</span>
                            <input type="text" name="linkedin_url" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '#') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-8 pr-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">YouTube URL</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-500 font-bold text-xs">#</span>
                            <input type="text" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '#') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-8 pr-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Pinterest URL</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-500 font-bold text-xs">#</span>
                            <input type="text" name="pinterest_url" value="{{ old('pinterest_url', $settings['pinterest_url'] ?? '#') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-8 pr-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-400 mb-1">TikTok URL</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-slate-500 font-bold text-xs">#</span>
                            <input type="text" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '#') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-8 pr-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-violet-600 hover:bg-violet-500 text-white font-semibold text-xs transition-all shadow-lg shadow-violet-600/20">
                Save Branding Configuration
            </button>
        </div>
    </form>
</div>
@endsection
