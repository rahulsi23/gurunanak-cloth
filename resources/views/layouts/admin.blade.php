<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'hPanel Enterprise') - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-brand { font-family: 'Outfit', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
    @yield('head')
</head>
<body class="h-full flex flex-col bg-slate-950 overflow-x-hidden">

    <header class="h-16 border-b border-slate-800 bg-slate-900/90 backdrop-blur-xl px-4 md:px-8 flex items-center justify-between shrink-0 sticky top-0 z-40">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 via-violet-700 to-indigo-800 flex items-center justify-center shadow-md shadow-violet-600/30 font-brand font-bold text-lg text-white tracking-tighter">
                    GC
                </div>
                <div class="hidden sm:block">
                    <span class="font-brand font-bold text-base tracking-tight text-white block leading-none">gurunanak<span class="text-violet-400">panel</span></span>
                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Premium E-Commerce Console</span>
                </div>
            </a>
        </div>

        <div class="flex items-center gap-3 md:gap-4">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-slate-400 hover:text-white uppercase tracking-widest font-bold">Logout</button>
            </form>
            <div class="h-8 w-8 rounded-full bg-violet-600 flex items-center justify-center text-xs font-bold">
                {{ auth()->check() ? substr(auth()->user()->name, 0, 1) : 'A' }}
            </div>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside class="w-64 border-r border-slate-800 bg-slate-900/50 hidden md:flex flex-col shrink-0 overflow-y-auto">
            <nav class="flex-1 p-4 pb-12 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20 shadow-[0_0_20px_rgba(124,58,237,0.1)]' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>
                
                <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Storefront Management</div>
                
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.products.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Products Catalog</span>
                </a>

                <a href="{{ route('admin.homepage.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.homepage.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    <span>Home Page Designer</span>
                </a>

                <a href="{{ route('admin.navigation.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.navigation.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20 shadow-[0_0_20px_rgba(124,58,237,0.05)]' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    <span>Store Navigation</span>
                </a>

                <a href="{{ route('admin.footer-navigation.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.footer-navigation.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20 shadow-[0_0_20px_rgba(124,58,237,0.05)]' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    <span>Footer Menu</span>
                </a>

                <a href="{{ route('admin.footer-pages.about') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.footer-pages.about') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20 shadow-[0_0_20px_rgba(124,58,237,0.05)]' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>About Page Builder</span>
                </a>

                <a href="{{ route('admin.footer-pages.contact') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.footer-pages.contact') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20 shadow-[0_0_20px_rgba(124,58,237,0.05)]' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Contact Page Builder</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>Orders Control</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.reviews.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>Customer Feedback</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Marketing & Utils</div>
                
                <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.coupons.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01M21 7h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 007.586 7H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2z"/></svg>
                    <span>Promotional Codes</span>
                </a>

                <a href="{{ route('admin.blog-categories.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.blog-categories.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>Blog Categories</span>
                </a>

                <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.blogs.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v7a2 2 0 01-2 2H9a2 2 0 01-2-2v-1"/></svg>
                    <span>Journal Articles</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Global Settings</div>
                
                <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.settings.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>General Settings</span>
                </a>

                <a href="{{ route('admin.branding.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.branding.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Visual Branding</span>
                </a>

                <a href="{{ route('admin.sales-channels.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.sales-channels.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <span>Sales Channels</span>
                </a>


                <a href="{{ route('admin.seo.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium {{ request()->routeIs('admin.seo.*') ? 'bg-violet-600/10 text-violet-400 border border-violet-600/20' : 'text-slate-400 hover:bg-slate-800/60 transition-all' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                    <span>SEO Settings</span>
                </a>

                <form action="{{ route('admin.seo.generate-sitemap') }}" method="POST" class="px-4 mt-8 mb-2">
                    @csrf
                    <button type="submit" onclick="this.innerHTML='Generating...'; this.classList.add('opacity-70');" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600/10 hover:bg-emerald-600 border border-emerald-600/30 hover:border-emerald-500 text-emerald-400 hover:text-white rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all shadow-[0_0_15px_rgba(16,185,129,0.05)] hover:shadow-[0_0_25px_rgba(16,185,129,0.3)] group">
                        <svg class="w-3.5 h-3.5 group-hover:rotate-180 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Generate Sitemap</span>
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="max-w-6xl mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @yield('scripts')
</body>
</html>
