<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews Management - Admin Studio</title>
    <!-- Premium Outfit & Plus Jakarta Sans Typography matching primary Hostinger Console -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-brand { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .animate-scaleIn {
            animation: scaleIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="h-full flex bg-slate-950 text-slate-100 overflow-hidden" x-data="{ 
    showReplyModal: false, 
    replyId: '', 
    replyText: '', 
    openReply(id, text) {
        this.replyId = id;
        this.replyText = text;
        this.showReplyModal = true;
    }
}">

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
                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg bg-violet-600 text-white text-xs font-semibold shadow-md shadow-violet-600/20">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            <span>⭐ Customer Reviews</span>
                        </div>
                        <span class="px-1.5 py-0.5 rounded text-[9px] bg-violet-700 font-bold">Active</span>
                    </a>
                </nav>
            </div>
            
            <div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 block mb-2 mt-4">Configurations</span>
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
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 block mb-2 mt-4">Global Settings</span>
                <nav class="space-y-1">
                    <a href="{{ route('admin.settings.edit') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 text-xs font-medium transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>General Settings</span>
                        </div>
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
                <span class="text-xs font-semibold text-slate-400">Moderation Desk:</span>
                <span class="text-xs text-slate-300 font-brand font-medium">Verify Star Metrics & Uploaded Assets</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-medium">
                <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">Dashboard</a>
                <span class="text-slate-800">|</span>
                <a href="{{ url('/') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition-all border border-slate-700">Live Storefront</a>
            </div>
        </header>

        <main class="flex-1 p-5 md:p-8 space-y-6 max-w-7xl mx-auto w-full">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                <div>
                    <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Storefront Authority Trust</span>
                    <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Customer Product Reviews</h1>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                        Approve, inspect, or remove user-submitted feedback below. Ratings map straight into JSON-LD Google Rich Snippets blocks dynamically.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500">Total Count:</span>
                    <span class="px-2.5 py-1 rounded bg-slate-900 border border-slate-800 text-xs font-bold text-violet-400">{{ $reviews->total() }}</span>
                </div>
            </div>

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs text-emerald-400 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main Reviews Database LEDGER Grid -->
            <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-900 shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-800 bg-slate-950 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-4">Date / Source</th>
                                <th class="py-3 px-4">Product Link</th>
                                <th class="py-3 px-4">Customer Reviewer</th>
                                <th class="py-3 px-4">Star Matrix</th>
                                <th class="py-3 px-4">Feedback Content & Image</th>
                                <th class="py-3 px-4 text-center">Visibility State</th>
                                <th class="py-3 px-4 text-right">Action Commands</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-xs text-slate-300">
                            @forelse($reviews as $rev)
                                <tr class="hover:bg-slate-950/40 transition-colors">
                                    <td class="py-3 px-4 whitespace-nowrap text-slate-500 font-mono text-[11px]">
                                        {{ $rev->created_at->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-4 max-w-xs">
                                        @if($rev->product)
                                            <a href="{{ route('product.detail', $rev->product->slug) }}" target="_blank" class="text-white hover:text-violet-400 font-semibold block truncate transition-colors">
                                                {{ $rev->product->title }}
                                            </a>
                                            <span class="text-[10px] text-slate-500 block">ID: {{ $rev->product->id }} • ${{ number_format($rev->product->price, 2) }}</span>
                                        @else
                                            <span class="text-rose-400 italic">Unlinked / Deleted Product</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <strong class="text-slate-200 block">{{ $rev->customer_name }}</strong>
                                        <span class="text-[10px] text-slate-500 block">Verified Client Stream</span>
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap font-bold text-amber-400 tracking-widest text-sm">
                                        {!! str_repeat('★', $rev->rating) !!}{!! str_repeat('<span class="text-slate-700">★</span>', 5 - $rev->rating) !!}
                                    </td>
                                    <td class="py-3 px-4 max-w-md">
                                        <p class="text-slate-300 leading-relaxed whitespace-pre-wrap italic break-words">{{ $rev->comment ?? 'No text input provided. Plain star review record.' }}</p>
                                        
                                        @if(!empty($rev->admin_reply))
                                            <div class="mt-2.5 p-3 bg-violet-950/20 border border-violet-850/30 rounded-xl relative max-w-sm">
                                                <span class="text-[9px] font-bold text-violet-400 uppercase tracking-widest block mb-1">Your Response:</span>
                                                <p class="text-[11px] text-slate-350 leading-relaxed italic break-words whitespace-pre-wrap">{{ $rev->admin_reply }}</p>
                                            </div>
                                        @endif

                                        @if(!empty($rev->image_path))
                                            <div class="mt-2.5 inline-block">
                                                <a href="{{ $rev->image_path }}" target="_blank" class="block rounded border border-slate-700 overflow-hidden relative group">
                                                    <img src="{{ $rev->image_path }}" alt="Submitted Avatar Asset" class="h-12 w-auto object-cover max-w-[120px]">
                                                    <span class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-[9px] text-white font-bold">Inspect Zoom</span>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center whitespace-nowrap">
                                        <form action="{{ route('admin.reviews.toggle', $rev) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold border transition-colors inline-block {{ 
                                                $rev->is_approved ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20' : 'bg-amber-500/10 border-amber-500/20 text-amber-400 hover:bg-amber-500/20' 
                                            }}" title="Click to toggle status">
                                                {{ $rev->is_approved ? '✓ Approved' : '⚠️ Hidden' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3 px-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <button @click="openReply('{{ $rev->id }}', '{{ addslashes($rev->admin_reply ?? '') }}')" class="px-2.5 py-1 rounded bg-violet-600/10 text-violet-400 hover:bg-violet-600 hover:text-white transition-all text-xs font-semibold">
                                                {{ $rev->admin_reply ? 'Edit Response' : 'Reply' }}
                                            </button>

                                            <form action="{{ route('admin.reviews.destroy', $rev) }}" method="POST" onsubmit="return confirm('Garbage Collection Notice: This physically unlinks associated asset files permanently. Continue?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 rounded bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white transition-all text-xs font-semibold">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-500 text-xs space-y-2">
                                        <p>No customer reviews logged yet.</p>
                                        <p class="text-[11px] text-slate-600">Submissions from storefront detail view maps automatically straight into this audit matrix.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Floor -->
                <div class="p-4 border-t border-slate-800 bg-slate-950">
                    {{ $reviews->links() }}
                </div>
            </div>

        </main>
    </div>

    <!-- REPLY MODAL -->
    <div x-show="showReplyModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-cloak style="display: none;">
        <div @click.away="showReplyModal = false" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl animate-scaleIn">
            <div class="px-5 py-4 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-brand font-bold text-white text-sm uppercase tracking-wider">Write Review Response</h3>
                <button @click="showReplyModal = false" class="text-slate-400 hover:text-white font-bold text-xs uppercase tracking-wide">✕ Close</button>
            </div>
            
            <form :action="'{{ route('admin.reviews.index') }}/' + replyId + '/reply'" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-2">YOUR RESPONSE</label>
                    <textarea name="admin_reply" x-model="replyText" rows="5" placeholder="Dear customer, thank you so much for your feedback! We are thrilled you loved the premium quality..." class="w-full bg-slate-950 border border-slate-800 rounded-lg p-3 text-xs text-slate-200 focus:outline-none focus:border-violet-500 placeholder-slate-700 leading-relaxed"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-slate-800">
                    <button type="button" @click="showReplyModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-white transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-violet-650 hover:bg-violet-600 text-white rounded-lg text-xs font-bold shadow-md transition-colors">Save Response</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
