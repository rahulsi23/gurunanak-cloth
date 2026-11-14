<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders & Requests - Admin Console</title>
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
                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Customer Orders Hub</span>
                </div>
            </div>
        </div>

        <!-- Right System Fast Links -->
        <div class="flex items-center gap-4 text-xs font-medium">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">← Dashboard Overview</a>
            <span class="text-slate-800">|</span>
            <a href="{{ route('admin.products.index') }}" class="text-slate-400 hover:text-white transition-colors">Products Inventory</a>
            <span class="text-slate-800">|</span>
            <a href="{{ url('/') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition-all border border-slate-700">Live Store</a>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto p-5 md:p-8 space-y-6">
        
        <!-- Header Controls Strip -->
        <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative overflow-hidden">
            <div>
                <span class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold block mb-1">Sales Ledger Module</span>
                <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Customer Orders & Requests</h1>
                <p class="text-xs text-slate-400 mt-1 max-w-xl leading-relaxed">
                    Yahan aapko un sabhi customers ki details dikhengi jinhone website se kapde order kiye hain. Aap unka phone number, delivery ka address dekh sakte hain aur parcel dispatch hone par status update kar sakte hain.
                </p>
            </div>

            <div class="shrink-0 flex items-center gap-2">
                <span class="text-xs text-slate-500 font-mono">Total Encrypted Blocks: <strong class="text-white">{{ $orders->count() }}</strong></span>
            </div>
        </div>

        <!-- Success Notifications -->
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs text-emerald-400 font-medium flex items-center gap-3">
                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Main Orders Table -->
        <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 bg-slate-950/50 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3 px-4">Order ID / Date</th>
                            <th class="py-3 px-4">Customer Details</th>
                            <th class="py-3 px-4">Items Summary</th>
                            <th class="py-3 px-4">Total Amount</th>
                            <th class="py-3 px-4">Dispatch Status</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-xs text-slate-300">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="py-3 px-4 font-mono">
                                    <strong class="text-white block">{{ $order->order_number }}</strong>
                                    <span class="text-[10px] text-slate-500">{{ $order->created_at->format('d M, Y h:i A') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <strong class="text-white block">{{ $order->customer_name }}</strong>
                                    <span class="text-[10px] text-slate-400 block">{{ $order->customer_phone }}</span>
                                    <span class="text-[10px] text-slate-500 block truncate max-w-xs">{{ $order->customer_email }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="space-y-1">
                                        @if(is_array($order->items))
                                            @foreach($order->items as $item)
                                                <div class="flex items-center gap-1.5 text-[11px]">
                                                    <span class="w-4 h-4 rounded bg-slate-950 flex items-center justify-center font-bold text-[9px] text-violet-400 border border-slate-800 shrink-0">{{ $item['qty'] ?? 1 }}</span>
                                                    <span class="text-slate-300 font-medium truncate max-w-[150px]">{{ $item['title'] ?? 'Garment' }}</span>
                                                    <span class="text-slate-500">({{ $item['size'] ?? 'M' }})</span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-brand font-semibold text-emerald-400 text-sm">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="py-3 px-4">
                                    <!-- Dynamic Quick Status Updater Form -->
                                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="bg-slate-950 border border-slate-800 rounded px-2 py-1 text-[11px] text-slate-300 focus:outline-none focus:border-violet-500 cursor-pointer">
                                            <option value="New Order" {{ $order->status === 'New Order' ? 'selected' : '' }}>🔴 New Order</option>
                                            <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>🟡 Processing</option>
                                            <option value="Dispatched" {{ $order->status === 'Dispatched' ? 'selected' : '' }}>🔵 Dispatched</option>
                                            <option value="Delivered" {{ $order->status === 'Delivered' ? 'selected' : '' }}>🟢 Delivered</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition-colors text-[11px] font-medium border border-slate-700 inline-block">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-slate-500 text-xs space-y-2">
                                    <p class="font-brand text-sm text-slate-400">No Orders Received Yet</p>
                                    <p class="max-w-md mx-auto">Storefront se jaise hi koi customer apna checkout process submit karega, uski record file theek yahan synchronize ho jayegi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Bottom Admin Console Footer -->
    <footer class="mt-auto py-4 px-6 border-t border-slate-800 bg-slate-950 text-center text-xs text-slate-600">
        <p>© {{ date('Y') }} Gurunanak Console. Built securely with next-generation automated checkout handshaking streams.</p>
    </footer>

</body>
</html>
