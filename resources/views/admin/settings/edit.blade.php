<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Settings - Admin Console</title>
    <!-- Premium Outfit & Plus Jakarta Sans Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-brand { font-family: 'Outfit', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</head>
<body class="h-full flex bg-slate-950 text-slate-100 overflow-hidden">

    <!-- Sidebar Layout exactly matching primary admin dashboard structure -->
    <aside class="w-64 border-r border-slate-800 bg-slate-900 flex flex-col shrink-0 h-full overflow-y-auto">
        <!-- Sidebar Brand Strip -->
        <div class="h-16 border-b border-slate-800 flex items-center px-6 gap-3 shrink-0">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-violet-600 to-indigo-800 flex items-center justify-center font-brand font-bold text-white text-base tracking-tighter shadow-md shadow-violet-600/20">
                GC
            </div>
            <span class="font-brand font-bold text-sm tracking-tight text-white block">gurunanak<span class="text-violet-400">console</span></span>
        </div>

        <div class="p-4 flex-1 space-y-6">
            <div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 block mb-2">Core Platform</span>
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Overview Console</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <span>Storefront Products</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>Customer Orders</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            <span>Customer Reviews</span>
                        </div>
                    </a>
                </nav>
            </div>
            
            <div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 block mb-2">Configurations</span>
                <nav class="space-y-1">
                    <a href="{{ route('admin.coupons.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                            <span>Promo Coupons</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.payment.edit') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <span>Payment Gateways</span>
                        </div>
                        <span class="text-[10px] text-rose-400 font-bold">API</span>
                    </a>
                </nav>
            </div>

            <div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 block mb-2">Global Settings</span>
                <nav class="space-y-1">
                    <a href="{{ route('admin.settings.edit') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg bg-violet-600 text-white text-xs font-semibold shadow-md shadow-violet-600/20">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>General Settings</span>
                        </div>
                        <span class="px-1.5 py-0.5 rounded text-[9px] bg-violet-700 font-bold">Active</span>
                    </a>

                    <a href="{{ route('admin.branding.edit') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Visual Branding</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.seo.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                            <span>SEO Settings</span>
                        </div>
                    </a>
                    <form action="{{ route('admin.seo.generate-sitemap') }}" method="POST" class="px-4 mt-8 mb-2">
                        @csrf
                        <button type="submit" onclick="this.innerHTML='Generating...'; this.classList.add('opacity-70');" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600/10 hover:bg-emerald-600 border border-emerald-600/30 hover:border-emerald-500 text-emerald-400 hover:text-white rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all shadow-[0_0_15px_rgba(16,185,129,0.05)] hover:shadow-[0_0_25px_rgba(16,185,129,0.3)] group">
                            <svg class="w-3.5 h-3.5 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Generate Sitemap</span>
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </aside>

    <!-- Main Workspace Layout -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        
        <!-- Header Strip -->
        <header class="h-16 border-b border-slate-800 bg-slate-900/40 backdrop-blur px-6 flex items-center justify-between shrink-0 sticky top-0 z-40">
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-slate-400">Settings Desk:</span>
                <span class="text-xs text-slate-300 font-brand font-medium">Configure Frontend Content Overrides</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-medium">
                <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">Dashboard</a>
                <span class="text-slate-800">|</span>
                <a href="{{ url('/') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition-all border border-slate-700">Live Storefront</a>
            </div>
        </header>

        <main class="flex-1 p-5 md:p-8 space-y-6 max-w-4xl w-full mx-auto">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                <div>
                    <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Live Announcement</span>
                    <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Announcement Bar Settings</h1>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                        Configure the live sliding marquee text shown at the very top of the storefront. Changes here are immediately updated and cached for maximum page speed.
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs text-emerald-400 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl">
                    <h3 class="font-brand font-semibold text-white mb-4 border-b border-slate-800 pb-2">Top Announcement Bar</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-2">Marquee Banner Text (HTML Supported)</label>
                            <input type="text" name="announcement_text" value="{{ old('announcement_text', $settings['announcement_text'] ?? '✨ FREE WORLDWIDE SHIPPING ON ORDERS OVER $250 &bull; SUMMER SALE: GET EXTRA 20% OFF AT CHECKOUT &bull; COMPLIMENTARY PREMIUM STUDIO PACKAGING &bull;') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 placeholder-slate-600 font-mono text-[11px]" placeholder="e.g. ✨ FREE WORLDWIDE SHIPPING...">
                            <p class="text-[10px] text-slate-500 mt-1.5">This text repeats across the top of the storefront. You can use &amp;bull; for dots.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl space-y-6">
                    <div class="border-b border-slate-800 pb-2">
                        <h3 class="font-brand font-semibold text-white text-base">SMTP Configuration</h3>
                        <p class="text-[10px] text-slate-500 mt-0.5">Server settings for system emails.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Sender Name</label>
                            <input type="text" id="mail_from_name" name="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? '') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-200 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 placeholder-slate-700" placeholder="e.g. Hair Fibers">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">SMTP Host</label>
                            <input type="text" id="mail_host" name="mail_host" value="{{ old('mail_host', $settings['mail_host'] ?? '') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-200 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 placeholder-slate-700" placeholder="e.g. smtp.gmail.com">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Port</label>
                            <select id="mail_port" name="mail_port" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500">
                                <option value="587" {{ (old('mail_port', $settings['mail_port'] ?? '') == '587') ? 'selected' : '' }}>587 (TLS)</option>
                                <option value="465" {{ (old('mail_port', $settings['mail_port'] ?? '') == '465') ? 'selected' : '' }}>465 (SSL)</option>
                                <option value="25" {{ (old('mail_port', $settings['mail_port'] ?? '') == '25') ? 'selected' : '' }}>25 (None)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">User Name</label>
                            <input type="text" id="mail_username" name="mail_username" value="{{ old('mail_username', $settings['mail_username'] ?? '') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-200 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 placeholder-slate-700" placeholder="e.g. rp524917@gmail.com">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Password</label>
                            <input type="password" id="mail_password" name="mail_password" value="{{ old('mail_password', $settings['mail_password'] ?? '') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-200 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 placeholder-slate-700" placeholder="••••••••••••">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Encryption</label>
                            <select id="mail_encryption" name="mail_encryption" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500">
                                <option value="TLS" {{ (old('mail_encryption', $settings['mail_encryption'] ?? '') == 'TLS') ? 'selected' : '' }}>TLS</option>
                                <option value="SSL" {{ (old('mail_encryption', $settings['mail_encryption'] ?? '') == 'SSL') ? 'selected' : '' }}>SSL</option>
                                <option value="None" {{ (old('mail_encryption', $settings['mail_encryption'] ?? '') == 'None') ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>

                    <!-- Verify SMTP Sub-Section -->
                    <div class="border border-dashed border-slate-800 rounded-xl p-6 bg-slate-950/40 space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Verify SMTP</span>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-end gap-4">
                            <div class="flex-1 w-full">
                                <label class="block text-[9px] font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Recipient</label>
                                <input type="email" id="test_recipient" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-violet-500 placeholder-slate-700" placeholder="e.g. verify@example.com">
                            </div>
                            <button type="button" id="btn_send_test" onclick="sendSmtpTest()" class="w-full sm:w-auto px-5 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs transition-colors flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/10 shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <span>Send Test</span>
                            </button>
                        </div>

                        <!-- Real-time Test Output Logs -->
                        <div id="test_result_box" class="hidden p-4 rounded-lg text-xs leading-relaxed font-mono"></div>
                    </div>
                <!-- WhatsApp Floating Widget Card -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-xl space-y-6">
                    <div class="border-b border-slate-800 pb-2 flex items-center justify-between">
                        <div>
                            <h3 class="font-brand font-semibold text-white text-base">WhatsApp Support Widget</h3>
                            <p class="text-[10px] text-slate-500 mt-0.5">Control the floating customer support WhatsApp chat bubble on your storefront.</p>
                        </div>
                        
                        <!-- Toggle Switch -->
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="whatsapp_enabled" value="1" {{ (old('whatsapp_enabled', $settings['whatsapp_enabled'] ?? '') == '1') ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-950 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-400 peer-checked:after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                            <span class="ml-2.5 text-xs text-slate-450">Enable Widget</span>
                        </label>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">WhatsApp Phone Number (with Country Code)</label>
                            <input type="text" name="whatsapp_phone" value="{{ old('whatsapp_phone', $settings['whatsapp_phone'] ?? '') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-200 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 placeholder-slate-700 font-mono" placeholder="e.g. 919876543210">
                            <p class="text-[9px] text-slate-500 mt-1">Include country code without '+' or spaces. For India, prefix with 91.</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Initial Greeting Message</label>
                            <input type="text" name="whatsapp_message" value="{{ old('whatsapp_message', $settings['whatsapp_message'] ?? 'Hi! I am interested in your bespoke collections. Can you please assist me?') }}" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-200 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 placeholder-slate-700" placeholder="Hello! I need support...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Widget Theme Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="whatsapp_color" oninput="document.getElementById('whatsapp_color_text').value = this.value" value="{{ old('whatsapp_color', $settings['whatsapp_color'] ?? '#25D366') }}" class="w-12 h-10 bg-slate-950 border border-slate-800 rounded-lg p-1 cursor-pointer">
                                <input type="text" id="whatsapp_color_text" readonly value="{{ old('whatsapp_color', $settings['whatsapp_color'] ?? '#25D366') }}" class="flex-1 bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-500 font-mono">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Enable Pulse/Glow Animation</label>
                            <select name="whatsapp_pulse" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-350 focus:outline-none focus:border-violet-500">
                                <option value="1" {{ (old('whatsapp_pulse', $settings['whatsapp_pulse'] ?? '1') == '1') ? 'selected' : '' }}>Yes (Pulsing Glow Rings)</option>
                                <option value="0" {{ (old('whatsapp_pulse', $settings['whatsapp_pulse'] ?? '1') == '0') ? 'selected' : '' }}>No (Static Icon)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-violet-600 hover:bg-violet-500 text-white font-semibold text-xs transition-colors shadow-lg shadow-violet-600/20">
                        Save Configuration & Flush Cache
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        async function sendSmtpTest() {
            const btn = document.getElementById('btn_send_test');
            const resultBox = document.getElementById('test_result_box');
            const recipient = document.getElementById('test_recipient').value.trim();

            if (!recipient) {
                alert('Please enter a recipient email address to send the test!');
                return;
            }

            // Show loading status
            btn.disabled = true;
            btn.innerHTML = `<svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending...`;
            
            resultBox.classList.remove('hidden', 'bg-emerald-500/10', 'border-emerald-500/20', 'text-emerald-400', 'bg-red-500/10', 'border-red-500/20', 'text-red-400');
            resultBox.classList.add('bg-slate-900', 'border', 'border-slate-800', 'text-slate-400');
            resultBox.innerHTML = 'Connecting to SMTP server and validating credentials...';

            try {
                const response = await fetch('{{ route("admin.settings.test-smtp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        mail_from_name: document.getElementById('mail_from_name').value,
                        mail_host: document.getElementById('mail_host').value,
                        mail_port: document.getElementById('mail_port').value,
                        mail_username: document.getElementById('mail_username').value,
                        mail_password: document.getElementById('mail_password').value,
                        mail_encryption: document.getElementById('mail_encryption').value,
                        recipient: recipient
                    })
                });

                const data = await response.json();

                if (data.success) {
                    resultBox.className = 'p-4 rounded-lg text-xs leading-relaxed font-mono bg-emerald-500/10 border border-emerald-500/20 text-emerald-400';
                    resultBox.innerHTML = `✅ ${data.message}`;
                } else {
                    resultBox.className = 'p-4 rounded-lg text-xs leading-relaxed font-mono bg-red-500/10 border border-red-500/20 text-red-400';
                    resultBox.innerHTML = `❌ Verification Failed:\n\n${data.message}`;
                }
            } catch (error) {
                resultBox.className = 'p-4 rounded-lg text-xs leading-relaxed font-mono bg-red-500/10 border border-red-500/20 text-red-400';
                resultBox.innerHTML = `❌ Error: Connection aborted or timeout. Details: ${error.message}`;
            } finally {
                btn.disabled = false;
                btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg> <span>Send Test</span>`;
            }
        }
    </script>

</body>
</html>
