<!DOCTYPE html>
<html lang="en" class="h-full bg-white text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <!-- Plus Jakarta Sans typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white; color: black; }
            .invoice-card { border: none !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="h-full flex flex-col bg-slate-50 text-slate-800 overflow-x-hidden antialiased">

    <!-- Sticky Floating Action Header for screen views only -->
    <header class="no-print h-16 bg-slate-900 border-b border-slate-800 px-6 flex items-center justify-between shrink-0 sticky top-0 z-40 shadow-md">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs text-slate-400 hover:text-white transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to Details</span>
            </a>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-lg transition-colors flex items-center gap-1.5 shadow-md shadow-emerald-900/10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Print / Save PDF</span>
            </button>
            <button onclick="window.close()" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-350 hover:text-white font-semibold text-xs rounded-lg transition-colors border border-slate-700">
                ✕ Close
            </button>
        </div>
    </header>

    <main class="flex-1 max-w-4xl w-full mx-auto p-4 md:p-8">
        
        <!-- Main Invoice Shell -->
        <div class="invoice-card bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xl p-8 space-y-8">
            
            <!-- Invoice Title & Brand Row -->
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 pb-6 border-b border-slate-150">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900 uppercase">Gurunanak Cloth House</h2>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Premium Luxury Apparel &amp; Bespoke Styling<br>
                        Amritsar, Punjab, India<br>
                        Support: orders@gurunanakcloth.com
                    </p>
                </div>
                
                <div class="text-left sm:text-right">
                    <h1 class="text-lg font-bold text-slate-400 uppercase tracking-widest leading-none mb-2">INVOICE RECEIPT</h1>
                    <div class="text-xs space-y-1 text-slate-600">
                        <div>Invoice No: <strong class="text-slate-900 font-mono">{{ $order->order_number }}</strong></div>
                        <div>Date: <span class="font-medium text-slate-900">{{ $order->created_at->format('d M Y') }}</span></div>
                        <div>Handoff Status: <span class="font-bold text-emerald-600 uppercase">{{ $order->status }}</span></div>
                    </div>
                </div>
            </div>

            <!-- Customer Destination Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-2">
                
                <!-- Billed To Box -->
                <div class="space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Customer Information</span>
                    <div class="text-xs space-y-1 text-slate-700">
                        <strong class="text-sm text-slate-900 block font-semibold">{{ $order->customer_name }}</strong>
                        <div>Phone: <span class="font-mono">{{ $order->customer_phone }}</span></div>
                        <div>Email: <span>{{ $order->customer_email }}</span></div>
                    </div>
                </div>

                <!-- Shipped To Box -->
                <div class="space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Shipping Destination</span>
                    <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-wrap font-medium">
                        {{ $order->shipping_address }}
                    </div>
                </div>

            </div>

            <!-- Purchased Garments Summary Table -->
            <div class="space-y-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Itemized Garments</span>
                
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                <th class="py-3 px-4">Garment Title</th>
                                <th class="py-3 px-4">Size</th>
                                <th class="py-3 px-4 text-center">Qty</th>
                                <th class="py-3 px-4 text-right">Unit Price</th>
                                <th class="py-3 px-4 text-right">Composite Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-150 text-slate-700">
                            @if(is_array($order->items) && count($order->items) > 0)
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="py-3.5 px-4">
                                            <strong class="text-slate-900 block font-semibold">{{ $item['title'] ?? 'Garment Silhouette' }}</strong>
                                            <span class="text-[10px] text-slate-400 block font-mono">SKU: {{ $item['id'] ?? 'N/A' }}</span>
                                        </td>
                                        <td class="py-3.5 px-4 font-mono font-bold text-slate-600">
                                            {{ $item['size'] ?? 'M' }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-bold text-slate-900">
                                            {{ $item['qty'] ?? 1 }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right text-slate-900 font-medium">
                                            ${{ number_format($item['price'] ?? 0, 2) }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-semibold text-slate-900">
                                            ${{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 italic">
                                        Legacy or manually generated order payload.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- Totals Handoff Floor -->
                    <div class="p-4 border-t border-slate-200 bg-slate-50 text-right space-y-1.5">
                        <div class="text-xs text-slate-500">
                            <span>Shipping / Freight Reserve:</span>
                            <span class="text-slate-950 font-medium ml-2">FREE</span>
                        </div>
                        <div class="text-xs text-slate-500">
                            <span>Processing Taxes:</span>
                            <span class="text-slate-950 font-medium ml-2">Absorbed Internally</span>
                        </div>
                        <div class="text-sm font-bold text-slate-900 pt-2.5 border-t border-slate-200 flex justify-end items-center">
                            <span>Ultimate Clearing Total:</span>
                            <span class="text-lg text-emerald-600 ml-4">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions / Signatures -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-6 border-t border-slate-150 text-[10px] text-slate-500">
                <div class="space-y-1.5">
                    <strong class="font-bold text-slate-700 uppercase tracking-wider block">Terms &amp; Disclaimers</strong>
                    <p class="leading-relaxed">
                        This is an official transaction statement generated dynamically. Standard exchange policies apply. Hand wash recommended for premium raw fabrics.
                    </p>
                </div>
                
                <div class="flex flex-col items-start sm:items-end justify-end space-y-1 mt-4 sm:mt-0">
                    <div class="w-36 border-b border-slate-300 h-10 flex items-end justify-center font-serif italic text-slate-400 text-xs select-none">
                        Gurunanak Store Representative
                    </div>
                    <span class="uppercase tracking-wider text-slate-400 text-[8px] font-bold block pt-1 mr-2">Authorized Handoff Seal</span>
                </div>
            </div>

        </div>

    </main>

    <!-- Auto-print trigger -->
    <script>
        window.addEventListener('load', function () {
            // Slight delay to allow layouts to render completely before printing
            setTimeout(function () {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
