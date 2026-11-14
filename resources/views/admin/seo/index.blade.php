<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO Settings - Admin Console</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-brand { font-family: 'Outfit', sans-serif; }
        .motion-soft { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>
</head>
<body class="h-full flex flex-col bg-slate-950 text-slate-100">

    <!-- Sticky Main Header -->
    <header class="h-16 border-b border-slate-800 bg-slate-900/90 backdrop-blur-xl px-4 md:px-8 flex items-center justify-between shrink-0 sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 via-violet-700 to-indigo-800 flex items-center justify-center font-brand font-bold text-lg text-white tracking-tighter">
                GC
            </div>
            <div>
                <span class="font-brand font-bold text-base tracking-tight text-white block leading-none">gurunanak<span class="text-violet-400">panel</span></span>
                <span class="text-[10px] text-slate-400 font-medium block mt-0.5">SEO & Discovery Console</span>
            </div>
        </div>
        <div class="flex items-center gap-4 text-xs font-medium">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">Dashboard</a>
            <span class="text-slate-800">|</span>
            <a href="{{ route('admin.settings.edit') }}" class="text-slate-400 hover:text-white transition-colors">General Settings</a>
        </div>
    </header>

    <!-- Main Workspace Container -->
    <div class="flex-1 flex overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside class="w-64 border-r border-slate-800 bg-slate-900/50 hidden md:flex flex-col shrink-0">
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800/60 hover:text-slate-100 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>
                
                <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Storefront Management</div>
                
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800/60 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <span>Products Catalog</span>
                </a>

                <a href="{{ route('admin.homepage.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800/60 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    <span>Home Page Designer</span>
                </a>

                <a href="{{ route('admin.navigation.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800/60 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    <span>Store Navigation</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800/60 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>Orders Control</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800/60 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>Customer Feedback</span>
                </a>

                <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Global Settings</div>

                <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800/60 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>General Settings</span>
                </a>

                <a href="{{ route('admin.seo.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-xs font-medium bg-violet-600/10 text-violet-400 border border-violet-600/20 shadow-[0_0_20px_rgba(124,58,237,0.1)]">
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

        <!-- Main Body Scroll Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8">
            <div class="max-w-6xl mx-auto space-y-6">

                @if(session('success'))
                    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-xs flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Overview Card -->
                <div class="pb-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Global Configs</span>
                        <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Search Engine Optimization (SEO)</h1>
                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                            Configure customized meta tags and Open Graph parameters per-page to drive search rankings and social media click-throughs.
                        </p>
                    </div>
                </div>

                <!-- Three Stat Cards for Health Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-500 block">SEO Target Pages</span>
                            <span class="font-brand text-lg font-bold text-white block mt-0.5">{{ $seos->count() }} Pages Active</span>
                        </div>
                    </div>
                    
                    <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-violet-500/10 border border-violet-500/20 flex items-center justify-center text-violet-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-500 block">Caching System</span>
                            <span class="font-brand text-lg font-bold text-white block mt-0.5">L2 Fast Cache On</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-500 block">Search indexing</span>
                            <span class="font-brand text-lg font-bold text-white block mt-0.5">Sitemap Sync Active</span>
                        </div>
                    </div>
                </div>

                <!-- Page SEO List Table -->
                <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                        <h3 class="font-brand font-bold text-sm text-white">Pages SEO Configurations</h3>
                        <span class="text-[10px] bg-violet-500/10 text-violet-400 border border-violet-500/20 px-2 py-0.5 rounded font-bold uppercase">Dynamic Feed</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-950/60 border-b border-slate-800 text-slate-400 font-medium">
                                    <th class="p-4">Page Information</th>
                                    <th class="p-4">Page Key</th>
                                    <th class="p-4">SEO Title Status</th>
                                    <th class="p-4">SEO Description Status</th>
                                    <th class="p-4 text-center">OG Image</th>
                                    <th class="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60 text-slate-300">
                                @foreach($seos as $seo)
                                <tr class="hover:bg-slate-800/35 transition-colors">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-950 flex items-center justify-center text-slate-400 border border-slate-800">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-white block">{{ $seo->page_name }}</span>
                                                <span class="text-[10px] text-slate-500 block mt-0.5">Updated {{ $seo->updated_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="p-4 font-mono text-[10px] text-violet-400">
                                        /{{ $seo->page_key === 'home' ? '' : ($seo->page_key === 'shop' ? 'shop' : 'collection/' . $seo->page_key) }}
                                    </td>

                                    <td class="p-4">
                                        @php
                                            $titleLen = strlen($seo->meta_title);
                                        @endphp
                                        @if($titleLen == 0)
                                            <span class="px-2 py-0.5 rounded bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[9px] font-bold">MISSING</span>
                                        @elseif($titleLen < 30)
                                            <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-bold">TOO SHORT ({{ $titleLen }} Chars)</span>
                                        @elseif($titleLen > 70)
                                            <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-bold">TOO LONG ({{ $titleLen }} Chars)</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[9px] font-bold">HEALTHY ({{ $titleLen }} Chars)</span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @php
                                            $descLen = strlen($seo->meta_description);
                                        @endphp
                                        @if($descLen == 0)
                                            <span class="px-2 py-0.5 rounded bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[9px] font-bold">MISSING</span>
                                        @elseif($descLen < 100)
                                            <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-bold">TOO SHORT ({{ $descLen }} Chars)</span>
                                        @elseif($descLen > 180)
                                            <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-bold">TOO LONG ({{ $descLen }} Chars)</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[9px] font-bold">HEALTHY ({{ $descLen }} Chars)</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($seo->og_image)
                                            <div class="w-8 h-8 rounded bg-slate-950 border border-slate-800 overflow-hidden mx-auto shadow-xs">
                                                <img src="{{ $seo->og_image }}" alt="OG Preview" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <span class="text-slate-600">—</span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-right">
                                        <a href="{{ route('admin.seo.edit', $seo->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition-all font-semibold inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            <span>Customize Meta</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Small Footer -->
    <footer class="py-4 px-6 border-t border-slate-800 bg-slate-950 text-center text-xs text-slate-600">
        <p>© {{ date('Y') }} Gurunanak Console. Cache flushing mechanism globally active.</p>
    </footer>

</body>
</html>
