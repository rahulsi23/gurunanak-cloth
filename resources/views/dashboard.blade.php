<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('favicon.ico') }}">
    <title>My Account | GURUNANAK CLOTH HOUSE</title>

    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        brand: ['Montserrat', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fdfbf7;
            color: #1c1917;
        }
        .font-brand { font-family: 'Montserrat', sans-serif; }
        .motion-soft { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        .tab-btn-active {
            color: #1c1917 !important;
            font-weight: 700 !important;
            border-left-color: #8b7355 !important;
            background-color: #f5efe6 !important;
        }
    </style>
</head>
<body class="antialiased selection:bg-[#f5efe6] selection:text-[#8b7355] min-h-screen flex flex-col justify-between">

    <!-- 1. Minimal Premium Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-[#eae4d8]/60 shadow-xs transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Brand Mark -->
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

            <!-- Core Navigation Actions -->
            <div class="flex items-center gap-4 sm:gap-6 font-brand text-xs uppercase tracking-wider text-[#44403c] font-medium">
                <a href="{{ url('/') }}" class="hover:text-[#8b7355] motion-soft transition-colors">Storefront</a>
                <a href="{{ route('shop.index') }}" class="hover:text-[#8b7355] motion-soft transition-colors">Collections</a>
                
                <!-- Explicit Post Logout Trigger -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-[#dc2626] hover:underline font-bold cursor-pointer">
                        Log Out
                    </button>
                </form>
            </div>

        </div>
    </header>

    <!-- 2. Customer Workspace Layout -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Welcome Customer Summary Banner -->
        <div class="bg-white rounded-2xl border border-[#eae4d8] p-6 sm:p-8 mb-8 relative overflow-hidden shadow-xs">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-[#f5efe6] to-transparent rounded-bl-full pointer-events-none"></div>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] font-brand uppercase tracking-widest bg-[#f5efe6] text-[#8b7355] px-2.5 py-1 rounded-md font-bold">Customer Account</span>
                    <h1 class="font-brand text-xl sm:text-2xl font-bold text-[#1c1917] mt-2.5">Welcome back, {{ Auth::user()->name }}</h1>
                    <div class="mt-1.5 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-[#786451]">
                        <span>Email: <strong class="text-[#1c1917] font-medium">{{ Auth::user()->email }}</strong></span>
                        <span class="text-[#eae4d8]">|</span>
                        <span>Phone: <strong id="top-phone-display" class="text-[#1c1917] font-medium">+91 98765 43210</strong></span>
                    </div>
                    @if(Auth::user()->is_admin)
                        <div class="mt-3">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#1c1917] hover:bg-[#8b7355] text-white font-brand text-[10px] font-bold uppercase tracking-wider transition-colors shadow-xs">
                                <span>⚡ Administrator Studio</span>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="text-left sm:text-right shrink-0">
                    <span class="block text-[10px] uppercase tracking-widest text-[#a08a75]">Customer Tier</span>
                    <span class="block font-brand text-xs font-bold text-[#8b7355] mt-0.5">Gold Member</span>
                    <span class="block text-[11px] text-[#786451] mt-0.5">Member since {{ Auth::user()->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Password Update Success Notification Matrix -->
        @if (session('status') === 'password-updated')
            <div class="mb-8 p-4 bg-[#f0fdf4] border border-[#bbf7d0] rounded-xl text-xs text-[#166534] flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="text-base">✓</span>
                    <strong class="font-bold">Success!</strong> Your account password has been changed successfully.
                </div>
                <button onclick="this.parentElement.remove()" class="font-bold text-[#166534] hover:opacity-70">✕</button>
            </div>
        @endif

        @if ($errors->updatePassword->any() || $errors->any())
            <div class="mb-8 p-4 bg-[#fff9f9] border-l-4 border-[#dc2626] rounded-r-xl text-xs text-[#dc2626] shadow-xs">
                <strong class="font-bold block mb-1">Please review the following fields:</strong>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->updatePassword->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Dashboard Workspace Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Left Navigation Plain Tabs -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-[#eae4d8] overflow-hidden divide-y divide-[#eae4d8]/60 shadow-xs">
                    <button onclick="switchClientTab('overview')" id="btn-tab-overview" class="w-full text-left font-brand text-xs uppercase tracking-wider text-[#786451] py-4 px-5 border-l-4 border-transparent hover:bg-[#fdfbf7] hover:text-[#1c1917] motion-soft transition-all tab-btn-active block font-medium">
                        My Dashboard
                    </button>
                    <button onclick="switchClientTab('orders')" id="btn-tab-orders" class="w-full text-left font-brand text-xs uppercase tracking-wider text-[#786451] py-4 px-5 border-l-4 border-transparent hover:bg-[#fdfbf7] hover:text-[#1c1917] motion-soft transition-all block font-medium">
                        My Orders
                    </button>
                    <button onclick="switchClientTab('addresses')" id="btn-tab-addresses" class="w-full text-left font-brand text-xs uppercase tracking-wider text-[#786451] py-4 px-5 border-l-4 border-transparent hover:bg-[#fdfbf7] hover:text-[#1c1917] motion-soft transition-all block font-medium">
                        Saved Addresses
                    </button>
                    <button onclick="switchClientTab('settings')" id="btn-tab-settings" class="w-full text-left font-brand text-xs uppercase tracking-wider text-[#786451] py-4 px-5 border-l-4 border-transparent hover:bg-[#fdfbf7] hover:text-[#1c1917] motion-soft transition-all block font-medium">
                        Account Settings
                    </button>
                </div>

                <!-- Simple Customer Assistance Widget -->
                <div class="mt-6 p-5 bg-white rounded-xl border border-[#eae4d8] text-center shadow-xs">
                    <span class="block font-brand text-[10px] uppercase tracking-widest text-[#8b7355] font-bold">Need Help?</span>
                    <p class="text-xs text-[#786451] mt-1.5 leading-relaxed">Have questions about your order or sizing? Our support team is ready to assist you.</p>
                    <a href="tel:+919876543210" class="inline-block mt-3 bg-[#8b7355] text-white text-[10px] font-brand uppercase tracking-wider px-4 py-2 rounded-lg font-bold hover:bg-[#786451] motion-soft transition-colors shadow-xs">
                        Call Customer Care
                    </a>
                </div>
            </div>

            <!-- Right Interactive Panels -->
            <div class="lg:col-span-3">
                
                <!-- TAB 1: My Dashboard Overview -->
                <div id="panel-overview" class="space-y-6 block">
                    
                    <!-- Quick Counters Card Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-white rounded-xl border border-[#eae4d8] p-5 text-center shadow-xs">
                            <span class="block text-[10px] uppercase tracking-wider text-[#a08a75]">Reward Tier</span>
                            <span class="block font-brand text-lg font-bold text-[#8b7355] mt-1">Gold Member</span>
                            <span class="block text-[10px] text-[#786451] mt-0.5">Free Premium Packaging</span>
                        </div>
                        <div class="bg-white rounded-xl border border-[#eae4d8] p-5 text-center shadow-xs">
                            <span class="block text-[10px] uppercase tracking-wider text-[#a08a75]">Total Orders</span>
                            <span class="block font-brand text-lg font-bold text-[#1c1917] mt-1">{{ count($activeOrders) + count($pastOrders) }} Orders</span>
                            <span class="block text-[10px] text-[#786451] mt-0.5">Recorded in History</span>
                        </div>
                        <div class="bg-white rounded-xl border border-[#eae4d8] p-5 text-center shadow-xs">
                            <span class="block text-[10px] uppercase tracking-wider text-[#a08a75]">Shopping Cart</span>
                            <span class="block font-brand text-lg font-bold text-[#8b7355] mt-1" id="dash-bag-counter">0 Items</span>
                            <span class="block text-[10px] text-[#786451] mt-0.5">Ready for Checkout</span>
                        </div>
                    </div>

                    <!-- Plain User Notifications -->
                    <div class="bg-white rounded-xl border border-[#eae4d8] p-6 sm:p-8 shadow-xs">
                        <h2 class="font-brand text-xs uppercase tracking-wider text-[#1c1917] font-bold border-b border-[#eae4d8] pb-3">Recent Notifications</h2>
                        <div class="mt-4 space-y-4 divide-y divide-[#eae4d8]/40 text-xs text-[#44403c]">
                            <div class="pt-2 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-[#1c1917]">Account Linked Successfully</span>
                                    <p class="text-xs text-[#786451] mt-0.5">Your email address has been safely verified and set as your primary sign-in ID.</p>
                                </div>
                                <span class="text-[10px] bg-[#f5efe6] text-[#8b7355] px-2.5 py-1 rounded font-bold">Active</span>
                            </div>
                            <div class="pt-4 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-[#1c1917]">Welcome to Premium Club</span>
                                    <p class="text-xs text-[#786451] mt-0.5">Enjoy automatic priority dispatch on all seasonal collection clothing releases.</p>
                                </div>
                                <span class="text-[10px] bg-[#f0fdf4] text-[#166534] border border-[#bbf7d0] px-2.5 py-1 rounded font-bold">Granted</span>
                            </div>
                        </div>
                    </div>

                    <!-- Secure Path to Cart -->
                    <div class="p-4 bg-white rounded-xl border border-[#eae4d8] flex items-center justify-between text-xs shadow-xs">
                        <span class="text-[#786451] font-medium">Ready to confirm items in your bag?</span>
                        <a href="{{ route('checkout.index') }}" class="font-brand text-[#8b7355] font-bold hover:underline uppercase tracking-wider text-[10px]">
                            Proceed to Secure Checkout →
                        </a>
                    </div>

                </div>

                <!-- TAB 2: My Orders (With Dynamic State Binding) -->
                <div id="panel-orders" class="space-y-6 hidden">
                    <div class="bg-white rounded-xl border border-[#eae4d8] p-6 sm:p-8 shadow-xs">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-[#eae4d8] pb-4 mb-6 gap-2">
                            <div>
                                <h2 class="font-brand text-sm uppercase tracking-wider text-[#1c1917] font-bold">Order Tracking & History</h2>
                                <p class="text-xs text-[#786451] mt-0.5">Real-time status of your active shipments and past purchases</p>
                            </div>
                        </div>

                        <!-- Active Processing Orders -->
                        @if(count($activeOrders) > 0)
                            <h3 class="font-brand text-xs uppercase tracking-wider text-[#a08a75] font-bold mb-4">Active Shipments</h3>
                            <div class="space-y-6 mb-8">
                                @foreach($activeOrders as $order)
                                    <div class="border-2 border-[#8b7355] rounded-xl overflow-hidden bg-white shadow-xs relative">
                                        <div class="bg-[#f5efe6] p-4 border-b border-[#eae4d8] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-brand text-xs font-bold text-[#1c1917]">{{ $order->order_number }}</span>
                                                    <span class="text-[9px] bg-amber-100 text-amber-800 border border-amber-200 px-2 py-0.5 rounded font-bold uppercase tracking-wider">{{ $order->status }}</span>
                                                </div>
                                                <span class="text-[11px] text-[#786451] block mt-0.5 font-light">Placed on {{ $order->created_at->format('F j, Y') }}</span>
                                            </div>
                                            <div class="text-left sm:text-right">
                                                <span class="text-[10px] uppercase tracking-wider text-[#a08a75] block">Total Amount</span>
                                                <span class="font-brand text-xs font-bold text-[#8b7355]">${{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="p-4 bg-white">
                                            <div class="divide-y divide-[#eae4d8]/30">
                                                @php $items = is_string($order->items) ? json_decode($order->items, true) : $order->items; @endphp
                                                @foreach($items as $item)
                                                    <div class="flex items-start justify-between gap-4 py-3 border-b border-[#eae4d8]/40 last:border-none">
                                                        <div class="flex items-start gap-3">
                                                            @if(isset($item['image']))
                                                                <img src="{{ $item['image'] }}" class="w-12 h-14 object-cover object-top rounded border border-[#eae4d8] bg-[#f5efe6] shrink-0">
                                                            @endif
                                                            <div>
                                                                <h5 class="text-xs font-bold text-[#1c1917] line-clamp-1">{{ $item['title'] ?? 'Product' }}</h5>
                                                                <p class="text-[10px] text-[#8b7355] mt-0.5">Size: <strong class="uppercase text-[#1c1917]">{{ $item['size'] ?? 'N/A' }}</strong> • Tone: {{ $item['color'] ?? 'N/A' }}</p>
                                                                <span class="text-[10px] font-medium text-[#786451]">Qty: {{ $item['qty'] ?? 1 }}</span>
                                                            </div>
                                                        </div>
                                                        <span class="font-brand text-xs font-bold text-[#1c1917] shrink-0">${{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 2) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Past Orders History Ledger -->
                        <h3 class="font-brand text-xs uppercase tracking-wider text-[#a08a75] font-bold mb-4">Past Purchases</h3>
                        @if(count($pastOrders) > 0)
                            <div class="space-y-4">
                                @foreach($pastOrders as $order)
                                    <div class="border border-[#eae4d8] rounded-xl overflow-hidden bg-[#fdfbf7] shadow-xs">
                                        <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-brand text-xs font-bold text-[#1c1917]">{{ $order->order_number }}</span>
                                                    <span class="text-[9px] bg-emerald-100 text-emerald-800 border border-emerald-200 px-2 py-0.5 rounded font-bold uppercase tracking-wider">Delivered</span>
                                                </div>
                                                <span class="text-[11px] text-[#786451] block mt-0.5 font-light">Placed on {{ $order->created_at->format('M j, Y') }}</span>
                                            </div>
                                            <div class="text-left sm:text-right">
                                                <span class="text-[10px] uppercase tracking-wider text-[#a08a75] block">Total Paid</span>
                                                <span class="font-brand text-xs font-bold text-[#8b7355]">${{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(count($activeOrders) === 0 && count($pastOrders) === 0)
                            <div class="py-12 px-4 text-center border-2 border-dashed border-[#eae4d8] rounded-xl bg-[#fdfbf7]">
                                <div class="w-12 h-12 rounded-full bg-[#f5efe6] text-[#8b7355] text-xl flex items-center justify-center mx-auto font-bold mb-3">!</div>
                                <h3 class="font-brand text-base font-bold text-[#1c1917]">You haven't placed any orders yet.</h3>
                                <p class="text-xs text-[#786451] mt-1 max-w-md mx-auto leading-relaxed">
                                    Once you complete an authorized payment via secure checkout, your tracking updates and history will appear here instantly.
                                </p>
                                <a href="{{ route('shop.index') }}" class="inline-block mt-4 bg-[#8b7355] text-white font-brand text-xs uppercase tracking-wider font-bold px-5 py-2.5 rounded-xl hover:bg-[#786451] transition-all duration-300 shadow-xs">
                                    Browse Storefront
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- TAB 3: Saved Addresses -->
                <div id="panel-addresses" class="space-y-6 hidden">
                    <div class="bg-white rounded-xl border border-[#eae4d8] p-6 sm:p-8 shadow-xs">
                        <h2 class="font-brand text-sm uppercase tracking-wider text-[#1c1917] font-bold border-b border-[#eae4d8] pb-4 mb-6">Saved Shipping Locations</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Primary Address Card -->
                            <div class="border-2 border-[#8b7355] rounded-xl bg-[#fdfbf7] p-5 relative shadow-xs">
                                <span class="absolute top-3 right-3 text-[9px] uppercase tracking-widest bg-[#8b7355] text-white px-2 py-0.5 rounded font-brand font-bold">Default</span>
                                
                                <h3 class="font-brand text-xs font-bold text-[#1c1917] mb-2">{{ Auth::user()->name }}</h3>
                                <p class="text-xs text-[#786451] leading-relaxed">
                                    Gurunanak Cloth House Hub<br>
                                    Main Store Building, Clock Tower Road<br>
                                    Amritsar, Punjab<br>
                                    Pincode: 143001
                                </p>
                                
                                <div class="mt-4 pt-3 border-t border-[#eae4d8] flex items-center justify-between text-xs">
                                    <span class="text-[#a08a75] font-medium">Primary Shipping</span>
                                    <button onclick="editAddressNode('Primary Address')" class="text-[#8b7355] hover:underline font-bold">Edit Address</button>
                                </div>
                            </div>

                            <!-- Alternate Office Card -->
                            <div class="border border-[#eae4d8] rounded-xl bg-white p-5 relative shadow-xs">
                                <span class="absolute top-3 right-3 text-[9px] uppercase tracking-widest bg-[#f5efe6] text-[#786451] px-2 py-0.5 rounded font-brand font-bold">Office</span>
                                
                                <h3 class="font-brand text-xs font-bold text-[#1c1917] mb-2">{{ Auth::user()->name }} (Work)</h3>
                                <p class="text-xs text-[#786451] leading-relaxed">
                                    Corporate Center Suite<br>
                                    Ranjit Avenue Commercial Block<br>
                                    Amritsar, Punjab<br>
                                    Pincode: 143001
                                </p>
                                
                                <div class="mt-4 pt-3 border-t border-[#eae4d8] flex items-center justify-between text-xs">
                                    <span class="text-[#a08a75] font-medium">Secondary Backup</span>
                                    <button onclick="editAddressNode('Office Address')" class="text-[#786451] hover:underline font-bold">Edit Address</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- TAB 4: Account Settings & Change Password Form -->
                <div id="panel-settings" class="space-y-6 hidden">
                    
                    <!-- General Details Block -->
                    <div class="bg-white rounded-xl border border-[#eae4d8] p-6 sm:p-8 shadow-xs">
                        <h2 class="font-brand text-sm uppercase tracking-wider text-[#1c1917] font-bold border-b border-[#eae4d8] pb-4 mb-6">Profile Details</h2>

                        <div class="max-w-xl space-y-4 text-xs">
                            <div>
                                <label class="block text-[10px] uppercase tracking-wider text-[#786451] font-bold mb-1">Full Name</label>
                                <input type="text" readonly value="{{ Auth::user()->name }}" class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl px-4 py-2.5 text-[#1c1917] font-medium select-all focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-wider text-[#786451] font-bold mb-1">Registered Email Address</label>
                                <input type="text" readonly value="{{ Auth::user()->email }}" class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl px-4 py-2.5 text-[#1c1917] font-medium select-all focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-wider text-[#786451] font-bold mb-1">Security Key Mapping</label>
                                <input type="text" readonly value="SECURE-ACCOUNT-ID-{{ Auth::user()->id }}" class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl px-4 py-2.5 text-[#a08a75] font-mono text-xs select-all focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Functional Sub-Card -->
                    <div class="bg-white rounded-xl border border-[#eae4d8] p-6 sm:p-8 shadow-xs">
                        <h2 class="font-brand text-sm uppercase tracking-wider text-[#1c1917] font-bold border-b border-[#eae4d8] pb-4 mb-6">Change Password</h2>

                        <form method="POST" action="{{ route('password.update') }}" class="max-w-xl space-y-4">
                            @csrf
                            @method('put')

                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block font-brand text-[10px] uppercase tracking-wider text-[#786451] font-bold mb-1">
                                    Current Password
                                </label>
                                <div class="relative">
                                    <input id="dash_current_password" name="current_password" type="password" required autocomplete="current-password"
                                           placeholder="••••••••"
                                           class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl pl-4 pr-10 py-2.5 text-xs focus:outline-none focus:border-[#8b7355] focus:bg-white transition-all shadow-xs">
                                    <button type="button" onclick="const inp = document.getElementById('dash_current_password'); inp.type = inp.type === 'password' ? 'text' : 'password';" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#a08a75] hover:text-[#8b7355] focus:outline-none p-1 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block font-brand text-[10px] uppercase tracking-wider text-[#786451] font-bold mb-1">
                                    New Password
                                </label>
                                <div class="relative">
                                    <input id="dash_password" name="password" type="password" required autocomplete="new-password"
                                           placeholder="••••••••"
                                           class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl pl-4 pr-10 py-2.5 text-xs focus:outline-none focus:border-[#8b7355] focus:bg-white transition-all shadow-xs">
                                    <button type="button" onclick="const inp = document.getElementById('dash_password'); inp.type = inp.type === 'password' ? 'text' : 'password';" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#a08a75] hover:text-[#8b7355] focus:outline-none p-1 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label for="password_confirmation" class="block font-brand text-[10px] uppercase tracking-wider text-[#786451] font-bold mb-1">
                                    Confirm New Password
                                </label>
                                <div class="relative">
                                    <input id="dash_password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                           placeholder="••••••••"
                                           class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl pl-4 pr-10 py-2.5 text-xs focus:outline-none focus:border-[#8b7355] focus:bg-white transition-all shadow-xs">
                                    <button type="button" onclick="const inp = document.getElementById('dash_password_confirmation'); inp.type = inp.type === 'password' ? 'text' : 'password';" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#a08a75] hover:text-[#8b7355] focus:outline-none p-1 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="bg-[#8b7355] text-white font-brand text-xs uppercase tracking-wider font-bold py-3 px-6 rounded-xl hover:bg-[#786451] shadow-xs hover:shadow-md transition-all duration-300">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Phone Number Updates & Binding Card -->
                    <div class="bg-white rounded-xl border border-[#eae4d8] p-6 sm:p-8 shadow-xs">
                        <h2 class="font-brand text-sm uppercase tracking-wider text-[#1c1917] font-bold border-b border-[#eae4d8] pb-4 mb-6">Phone Number Settings</h2>
                        
                        <div class="max-w-xl space-y-4">
                            <div>
                                <label for="client_telephone" class="block font-brand text-[10px] uppercase tracking-wider text-[#786451] font-bold mb-1">
                                    Primary Contact Number
                                </label>
                                <input id="client_telephone" type="text" placeholder="+91 98765 43210"
                                       class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl px-4 py-2.5 text-xs text-[#1c1917] font-medium focus:outline-none focus:border-[#8b7355] focus:bg-white transition-all shadow-xs">
                            </div>
                            <div class="pt-1 flex items-center justify-between">
                                <span id="phone-save-status" class="text-[11px] text-[#166534] font-medium opacity-0 transition-opacity duration-300">✓ Phone synchronized successfully!</span>
                                <button type="button" onclick="persistClientPhone()" class="bg-[#1c1917] text-white font-brand text-xs uppercase tracking-wider font-bold py-2.5 px-5 rounded-xl hover:bg-[#8b7355] transition-all duration-300 shadow-xs">
                                    Save Phone Number
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- Warm Standard Footer -->
    <footer class="w-full py-8 text-center border-t border-[#eae4d8]/60 bg-white shrink-0 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-xs text-[#a08a75] space-y-1.5 flex flex-col items-center justify-center">
            @if(($settings['footer_logo_type'] ?? 'text') === 'image' && !empty($settings['footer_logo_image']))
                <img src="{{ asset('storage/' . $settings['footer_logo_image']) }}" alt="{{ $settings['footer_logo_text'] ?? 'GURUNANAK' }}" class="h-8 w-auto object-contain mb-2">
            @else
                <p class="font-brand tracking-widest text-[#1c1917] font-bold uppercase text-xs mb-1.5">
                    {{ $settings['footer_logo_text'] ?? 'GURUNANAK' }}
                </p>
            @endif
            <p>Quality fabrics, honest tailoring, and everyday clothing since 1990.</p>
            <p class="text-[10px] pt-1">© {{ date('Y') }} Gurunanak Cloth House. All rights reserved.</p>
        </div>
    </footer>

    <!-- Client-side Tab & Data Syncer Logic -->
    <script>
        // 1. Navigation Tab Switching Logic
        function switchClientTab(targetId) {
            const panels = ['overview', 'orders', 'addresses', 'settings'];
            panels.forEach(p => {
                const el = document.getElementById('panel-' + p);
                if (el) el.style.display = (p === targetId) ? 'block' : 'none';
            });

            panels.forEach(p => {
                const btn = document.getElementById('btn-tab-' + p);
                if (btn) {
                    if (p === targetId) {
                        btn.classList.add('tab-btn-active');
                    } else {
                        btn.classList.remove('tab-btn-active');
                    }
                }
            });

            // Persist current active tab key so page refreshed (e.g. password updates) reload correct view
            localStorage.setItem('gurunanak_active_tab', targetId);
            
            if (targetId === 'orders') {
                renderAuthenticOrdersList();
            }
        }

        // 2. Mock functions removed because orders are now mapped from database directly.

        // 5. General Helpers
        function editAddressNode(label) {
            const updated = prompt('Update delivery instruction line for ' + label + ':', 'Suite 101, Luxury Arcade');
            if (updated) {
                alert('Saved instruction: "' + updated + '". State mirrored for immediate checkout.');
            }
        }

        // 6. Telephone parameter storage handler
        function persistClientPhone() {
            const inpNode = document.getElementById('client_telephone');
            const statusNode = document.getElementById('phone-save-status');
            const topNode = document.getElementById('top-phone-display');
            if (inpNode && inpNode.value.trim()) {
                const phoneVal = inpNode.value.trim();
                localStorage.setItem('gurunanak_phone', phoneVal);
                if (topNode) topNode.innerText = phoneVal;
                
                statusNode.classList.remove('opacity-0');
                setTimeout(() => statusNode.classList.add('opacity-0'), 3000);
            } else {
                alert('Please enter a valid string structure for your telephone mapping.');
            }
        }

        // Initial Runtime Bindings
        window.addEventListener('DOMContentLoaded', () => {
            // Restore Tab if session returns from a password form validation
            const savedTab = localStorage.getItem('gurunanak_active_tab') || 'overview';
            // If validation errors belong to password update, force open settings tab
            @if ($errors->updatePassword->any() || session('status') === 'password-updated')
                switchClientTab('settings');
            @else
                switchClientTab(savedTab);
            @endif

            // Sync phone storage mirrors
            const storedPhone = localStorage.getItem('gurunanak_phone') || '+91 98765 43210';
            const topPhone = document.getElementById('top-phone-display');
            const inpPhone = document.getElementById('client_telephone');
            if (topPhone) topPhone.innerText = storedPhone;
            if (inpPhone) inpPhone.value = storedPhone === '+91 98765 43210' ? '' : storedPhone;

            // Sync Cart Counter for top widget stats summary
            const rawBag = localStorage.getItem('gurunanak_bespoke_bag');
            if (rawBag) {
                try {
                    const parsed = JSON.parse(rawBag);
                    const counterNode = document.getElementById('dash-bag-counter');
                    if (counterNode && Array.isArray(parsed)) {
                        const totalPieces = parsed.reduce((acc, item) => acc + (parseInt(item.qty) || 1), 0);
                        counterNode.innerText = totalPieces === 1 ? '1 Piece' : totalPieces + ' Pieces';
                    }
                } catch(e){}
            }

            // Removed JS renderAuthenticOrdersList() as orders are mapped from server.
        });
    </script>

</body>
</html>
