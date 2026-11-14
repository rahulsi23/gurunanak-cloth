<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Inventory - Admin Console</title>
    <!-- Premium Outfit & Plus Jakarta Sans Typography matching primary Console -->
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
<body class="h-full flex flex-col bg-slate-950 text-slate-100 overflow-x-hidden">

    <!-- Top Admin Navbar (Hostinger Console Style) -->
    <header class="h-16 border-b border-slate-800 bg-slate-900/90 backdrop-blur-xl px-4 md:px-8 flex items-center justify-between shrink-0 sticky top-0 z-40">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 via-violet-700 to-indigo-800 flex items-center justify-center shadow-md shadow-violet-600/30 font-brand font-bold text-lg text-white tracking-tighter">
                    GC
                </div>
                <div class="hidden sm:block">
                    <span class="font-brand font-bold text-base tracking-tight text-white block leading-none">gurunanak<span class="text-violet-400">panel</span></span>
                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Products Administration</span>
                </div>
            </div>
        </div>

        <!-- Right System Fast Links -->
        <div class="flex items-center gap-4 text-xs font-medium">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">← Dashboard Overview</a>
            <span class="text-slate-800">|</span>
            <a href="{{ url('/') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition-all border border-slate-700">Live Store</a>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto p-5 md:p-8 space-y-6">
        
        <!-- Header Controls Strip -->
        <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative overflow-hidden">
            <div>
                <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Catalog Module</span>
                <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Products Inventory</h1>
                <p class="text-xs text-slate-400 mt-1 max-w-xl leading-relaxed">
                    View and manage all items listed on your website. You can easily add new pieces, update pricing, define SEO fields, or remove unneeded stock.
                </p>
            </div>

            <div class="shrink-0">
                <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-700 text-white text-xs font-semibold transition-all inline-flex items-center gap-2 shadow-md shadow-violet-600/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span>Add New Product</span>
                </a>
            </div>
        </div>

        <!-- Success Notifications -->
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs text-emerald-400 font-medium flex items-center gap-3">
                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Navigation Strip -->
        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400">
            <span class="font-semibold text-slate-500 mr-1">Filter Line:</span>
            <a href="{{ route('admin.products.index') }}" class="px-3 py-1.5 rounded-lg border {{ !request('lookbook') ? 'bg-violet-600/10 border-violet-500 text-violet-300 font-bold' : 'bg-slate-900 border-slate-800 text-slate-400 hover:border-slate-700' }} transition-all">
                All Collections
            </a>
            @foreach($lookbooks as $lb)
                <a href="{{ route('admin.products.index', ['lookbook' => $lb]) }}" class="px-3 py-1.5 rounded-lg border {{ request('lookbook') === $lb ? 'bg-violet-600/10 border-violet-500 text-violet-300 font-bold' : 'bg-slate-900 border-slate-800 text-slate-400 hover:border-slate-700' }} transition-all capitalize">
                    {{ $lb }}
                </a>
            @endforeach
        </div>

        <!-- Main Items Inventory Table -->
        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 bg-slate-950/50 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3 px-4">Product Image</th>
                            <th class="py-3 px-4">Product Details</th>
                            <th class="py-3 px-4">Collection / Lookbook</th>
                            <th class="py-3 px-4">Price</th>
                            <th class="py-3 px-4">Sizes Available</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-xs text-slate-300">
                        @forelse($products as $prod)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="py-3 px-4 w-20">
                                    <div class="w-12 h-16 rounded-lg bg-slate-950 border border-slate-800 overflow-hidden relative shadow-xs">
                                        <img src="{{ $prod->image_path }}" alt="{{ $prod->title }}" class="w-full h-full object-cover object-top">
                                        <span class="absolute bottom-0 right-0 bg-violet-600 text-white text-[7px] font-brand font-bold px-1 rounded-tl">WEBP</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 max-w-xs">
                                    <span class="text-[9px] font-semibold text-violet-400 uppercase tracking-wide block mb-0.5">{{ $prod->subtitle ?: 'Standard Item' }}</span>
                                    <strong class="font-semibold text-white block truncate text-sm">{{ $prod->title }}</strong>
                                    <span class="text-[10px] text-slate-500 block font-mono mt-0.5">{{ $prod->slug }}</span>
                                    @if($prod->meta_title)
                                        <span class="text-[9px] text-emerald-400 font-medium block mt-1">✓ SEO Configured</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded bg-slate-950 border border-slate-800 text-slate-300 text-[10px] font-medium capitalize inline-block">
                                        {{ $prod->lookbook }} / {{ $prod->category_slug }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-brand font-semibold text-white text-sm">
                                    ${{ number_format($prod->price, 2) }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if(is_array($prod->sizes))
                                            @foreach($prod->sizes as $sz)
                                                <span class="px-1.5 py-0.5 rounded bg-slate-950 border border-slate-800 text-slate-300 text-[10px] font-medium">{{ $sz }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.products.edit', $product = $prod->id) }}" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition-colors text-[11px] font-medium border border-slate-700">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product = $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-colors text-[11px] font-medium border border-rose-500/20">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-500 text-xs">
                                    No products found listed under this section. Click the "Add New Product" button above to list your first items.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination Floor -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/40 text-xs">
                {{ $products->links() }}
            </div>
        </div>

    </main>

    <!-- Bottom Admin Console Footer -->
    <footer class="mt-auto py-4 px-6 border-t border-slate-800 bg-slate-950 text-center text-xs text-slate-600">
        <p>© {{ date('Y') }} Gurunanak Console. Built securely with next-generation WebP auto-compression controls.</p>
    </footer>

</body>
</html>
