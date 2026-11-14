<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice Details - Admin Console</title>
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

    <!-- Top Admin Navbar -->
    <header class="h-16 border-b border-slate-800 bg-slate-900/90 backdrop-blur-xl px-4 md:px-8 flex items-center justify-between shrink-0 sticky top-0 z-40">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 via-violet-700 to-indigo-800 flex items-center justify-center shadow-md shadow-violet-600/30 font-brand font-bold text-lg text-white tracking-tighter">
                    GC
                </div>
                <div class="hidden sm:block">
                    <span class="font-brand font-bold text-base tracking-tight text-white block leading-none">gurunanak<span class="text-violet-400">panel</span></span>
                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Order Invoice Overview</span>
                </div>
            </div>
        </div>

        <!-- Right Fast Links -->
        <div class="flex items-center gap-4 text-xs font-medium">
            <a href="{{ route('admin.orders.index') }}" class="text-slate-400 hover:text-white transition-colors">← Back to Orders List</a>
            <span class="text-slate-800">|</span>
            <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">Dashboard</a>
            <span class="text-slate-800">|</span>
            <a href="{{ url('/') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition-all border border-slate-700">Live Store</a>
        </div>
    </header>

    <main class="flex-1 max-w-5xl w-full mx-auto p-5 md:p-8 space-y-6">
        
        <!-- Action Back Strip -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-xs text-slate-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Wapas Orders List Par Jayein</span>
            </a>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-violet-650 hover:bg-violet-600 text-white text-xs font-bold transition-all inline-flex items-center gap-1.5 shadow-lg shadow-violet-900/30">
                    <svg class="w-3.5 h-3.5 text-slate-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Download PDF Invoice</span>
                </a>
                
                <button onclick="window.print()" class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-medium transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Print Order Slip</span>
                </button>
            </div>
        </div>

        <!-- Main Invoice Envelope Shell -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
            
            <!-- Invoice Header Box -->
            <div class="p-6 sm:p-8 border-b border-slate-800 bg-slate-950/40 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] uppercase tracking-widest text-violet-400 font-bold block mb-1">Encrypted Transaction Details</span>
                    <h1 class="font-brand text-2xl font-bold text-white tracking-tight">{{ $order->order_number }}</h1>
                    <span class="text-xs text-slate-500 block mt-0.5">Order Time: {{ $order->created_at->format('l, d F Y h:i A') }}</span>
                </div>
                
                <div class="text-left sm:text-right">
                    <span class="text-[10px] uppercase tracking-wider text-slate-500 block mb-1">Dispatch Protocol Status</span>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ 
                        $order->status === 'Delivered' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : (
                        $order->status === 'Dispatched' ? 'bg-blue-500/10 border-blue-500/20 text-blue-400' : (
                        $order->status === 'Processing' ? 'bg-amber-500/10 border-amber-500/20 text-amber-400' : 'bg-rose-500/10 border-rose-500/20 text-rose-400'
                        )) 
                    }}">
                        {{ $order->status }}
                    </span>
                </div>
            </div>

            <!-- Customer Destination Grid -->
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-slate-800 bg-slate-900/50">
                
                <!-- Box A: Contact Info -->
                <div class="space-y-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Customer Contact Nodes</span>
                    <div class="p-4 rounded-xl bg-slate-950 border border-slate-800/80 space-y-2 text-xs">
                        <div>
                            <span class="text-slate-500 block text-[10px]">Full Signature Name:</span>
                            <strong class="text-white text-sm block mt-0.5">{{ $order->customer_name }}</strong>
                        </div>
                        <div class="pt-1">
                            <span class="text-slate-500 block text-[10px]">Calling Mobile Number:</span>
                            <strong class="text-slate-200 block font-mono mt-0.5">{{ $order->customer_phone }}</strong>
                        </div>
                        <div class="pt-1">
                            <span class="text-slate-500 block text-[10px]">Secure Email Account:</span>
                            <span class="text-slate-400 block">{{ $order->customer_email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Box B: Shipping Residence -->
                <div class="space-y-3">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Delivery Location (Kahan Bhejna Hai)</span>
                    <div class="p-4 rounded-xl bg-slate-950 border border-slate-800/80 h-[calc(100%-20px)] flex flex-col justify-between text-xs">
                        <div>
                            <span class="text-slate-500 block text-[10px]">Complete Destination Address:</span>
                            <p class="text-slate-200 mt-1 leading-relaxed whitespace-pre-wrap">{{ $order->shipping_address }}</p>
                        </div>
                        <span class="text-[10px] text-violet-400 block pt-2 mt-2 border-t border-slate-800/60 font-medium">
                            ✓ Courier clearance instructions verified
                        </span>
                    </div>
                </div>

            </div>

            <!-- Purchased Garments Summary Table -->
            <div class="p-6 sm:p-8 space-y-4">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Ordered Garments Breakdown</span>
                
                <div class="border border-slate-800 rounded-xl overflow-hidden bg-slate-950/60">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-800 bg-slate-950 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-4">Item Snapshot</th>
                                <th class="py-3 px-4">Garment Title</th>
                                <th class="py-3 px-4">Size Selected</th>
                                <th class="py-3 px-4 text-center">Quantity</th>
                                <th class="py-3 px-4 text-right">Composite Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-xs text-slate-300">
                            @if(is_array($order->items) && count($order->items) > 0)
                                @foreach($order->items as $item)
                                    <tr class="hover:bg-slate-900/50 transition-colors">
                                        <td class="py-3 px-4 w-16">
                                            <div class="w-10 h-12 rounded bg-slate-900 border border-slate-800 overflow-hidden relative">
                                                <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=600&q=80' }}" class="w-full h-full object-cover object-top">
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <strong class="text-white block">{{ $item['title'] ?? 'Garment Silhouette' }}</strong>
                                            <span class="text-[10px] text-slate-500 block">SKU Code: {{ $item['id'] ?? 'N/A' }}</span>
                                        </td>
                                        <td class="py-3 px-4 font-mono font-bold text-violet-400">
                                            {{ $item['size'] ?? 'M' }}
                                        </td>
                                        <td class="py-3 px-4 text-center font-bold text-white">
                                            {{ $item['qty'] ?? 1 }}
                                        </td>
                                        <td class="py-3 px-4 text-right font-brand font-semibold text-white">
                                            ${{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-500 italic text-xs">
                                        Manual or legacy order payload. Details parsed directly into grand total matrix.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Totals Handoff Floor -->
                    <div class="p-4 border-t border-slate-800 bg-slate-950 text-right space-y-1">
                        <div class="text-xs text-slate-500">
                            <span>Composite Freight Reserve:</span>
                            <span class="text-slate-400 ml-2">Complimentary</span>
                        </div>
                        <div class="text-xs text-slate-500">
                            <span>Excise Processing Taxes:</span>
                            <span class="text-slate-400 ml-2">Absorbed Internally</span>
                        </div>
                        <div class="text-sm font-bold text-white pt-2 border-t border-slate-800/80">
                            <span>Ultimate Clearing Total:</span>
                            <span class="font-brand text-base text-emerald-400 ml-3">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Meta status controls -->
            <div class="p-6 border-t border-slate-800 bg-slate-950/40 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-400">
                    <span>Order Dispatch Protocol:</span>
                    <strong class="text-white">Active SSL Handoff</strong>
                </div>

                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <span class="text-xs text-slate-500">Change State:</span>
                    <select name="status" class="bg-slate-900 border border-slate-800 rounded px-3 py-1.5 text-xs text-slate-200 focus:outline-none focus:border-violet-500 cursor-pointer">
                        <option value="New Order" {{ $order->status === 'New Order' ? 'selected' : '' }}>🔴 New Order</option>
                        <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>🟡 Processing</option>
                        <option value="Dispatched" {{ $order->status === 'Dispatched' ? 'selected' : '' }}>🔵 Dispatched</option>
                        <option value="Delivered" {{ $order->status === 'Delivered' ? 'selected' : '' }}>🟢 Delivered</option>
                    </select>
                    <button type="submit" class="px-3 py-1.5 bg-violet-600 hover:bg-violet-700 text-white font-semibold text-xs rounded transition-colors">
                        Save Status
                    </button>
                </form>
            </div>

        </div>

    </main>

    <footer class="mt-auto py-4 px-6 border-t border-slate-800 bg-slate-950 text-center text-xs text-slate-600">
        <p>© {{ date('Y') }} Gurunanak Console. Print layout telemetry optimized natively.</p>
    </footer>

</body>
</html>
