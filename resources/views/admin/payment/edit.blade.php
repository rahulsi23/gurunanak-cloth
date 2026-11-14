<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway Config | Admin Console</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@500;700;800&display=swap" rel="stylesheet">
    
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
</head>
<body class="bg-slate-950 text-slate-300 antialiased min-h-screen flex flex-col selection:bg-rose-500/30 selection:text-rose-200">

    <!-- Top Header -->
    <header class="h-16 border-b border-slate-800/80 bg-slate-900/50 backdrop-blur-md sticky top-0 z-50 flex items-center justify-between px-4 sm:px-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div class="flex items-center gap-2.5 border-l border-slate-800 pl-4">
                <div class="w-8 h-8 rounded bg-gradient-to-br from-rose-500 to-rose-700 flex items-center justify-center shadow-lg shadow-rose-500/20">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                    <h1 class="text-sm font-brand font-bold text-white leading-none">Payment Gateway Hub</h1>
                    <span class="text-[10px] text-slate-500 uppercase tracking-wider font-medium mt-0.5 block">Security Level: Maximum</span>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-4xl w-full mx-auto p-4 sm:p-6 lg:p-8">

        @if(session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <h3 class="text-sm font-bold text-emerald-400">APIs Synchronized</h3>
                    <p class="text-xs text-emerald-400/80 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="p-6 sm:p-8 border-b border-slate-800 bg-slate-900/50">
                <h2 class="text-lg font-brand font-bold text-white">Live Payment Processors</h2>
                <p class="text-xs text-slate-400 mt-1">Configure your API keys here. Ensure your secret keys remain hidden and never share them with unauthorized staff.</p>
            </div>

            <form action="{{ route('admin.payment.update') }}" method="POST" class="p-6 sm:p-8 space-y-8">
                @csrf
                @method('PUT')

                <!-- Global Toggle -->
                <div class="space-y-4">
                    <label class="text-xs font-bold text-slate-300 uppercase tracking-wider block">Active Payment Gateway</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        
                        <label class="relative flex cursor-pointer rounded-xl border border-slate-700 bg-slate-800/50 p-4 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500">
                            <input type="radio" name="payment_gateway_provider" value="razorpay" class="peer sr-only" {{ ($settings['payment_gateway_provider'] ?? '') == 'razorpay' ? 'checked' : '' }}>
                            <span class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-rose-500 peer-checked:bg-rose-500/5 transition-all"></span>
                            <div class="relative flex flex-col gap-1 w-full">
                                <span class="font-bold text-white text-sm">Razorpay (India)</span>
                                <span class="text-xs text-slate-500">Supports UPI, Netbanking & Cards</span>
                            </div>
                        </label>

                        <label class="relative flex cursor-pointer rounded-xl border border-slate-700 bg-slate-800/50 p-4 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500">
                            <input type="radio" name="payment_gateway_provider" value="stripe" class="peer sr-only" {{ ($settings['payment_gateway_provider'] ?? '') == 'stripe' ? 'checked' : '' }}>
                            <span class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-rose-500 peer-checked:bg-rose-500/5 transition-all"></span>
                            <div class="relative flex flex-col gap-1 w-full">
                                <span class="font-bold text-white text-sm">Stripe (Global)</span>
                                <span class="text-xs text-slate-500">Supports Apple Pay & Int. Cards</span>
                            </div>
                        </label>

                        <label class="relative flex cursor-pointer rounded-xl border border-slate-700 bg-slate-800/50 p-4 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500">
                            <input type="radio" name="payment_gateway_provider" value="cod" class="peer sr-only" {{ ($settings['payment_gateway_provider'] ?? 'cod') == 'cod' ? 'checked' : '' }}>
                            <span class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-rose-500 peer-checked:bg-rose-500/5 transition-all"></span>
                            <div class="relative flex flex-col gap-1 w-full">
                                <span class="font-bold text-white text-sm">Cash on Delivery</span>
                                <span class="text-xs text-slate-500">Manual verification bypass</span>
                            </div>
                        </label>

                    </div>
                </div>

                <hr class="border-slate-800">

                <!-- Razorpay API Keys -->
                <div class="space-y-5">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Razorpay API Credentials</h3>
                        <span class="text-[9px] bg-slate-800 text-slate-400 px-2 py-0.5 rounded font-bold uppercase">Production</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Key ID</label>
                            <input type="text" name="razorpay_key_id" value="{{ $settings['razorpay_key_id'] ?? '' }}" placeholder="rzp_live_xxxxxxxxxxx" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-all font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Key Secret</label>
                            <input type="password" name="razorpay_key_secret" value="{{ $settings['razorpay_key_secret'] ?? '' }}" placeholder="••••••••••••••••••••••••" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-all font-mono">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-800">

                <!-- Stripe API Keys -->
                <div class="space-y-5">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Stripe API Credentials</h3>
                        <span class="text-[9px] bg-slate-800 text-slate-400 px-2 py-0.5 rounded font-bold uppercase">Production</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Publishable Key</label>
                            <input type="text" name="stripe_public_key" value="{{ $settings['stripe_public_key'] ?? '' }}" placeholder="pk_live_xxxxxxxxxxx" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-all font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Secret Key</label>
                            <input type="password" name="stripe_secret_key" value="{{ $settings['stripe_secret_key'] ?? '' }}" placeholder="••••••••••••••••••••••••" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition-all font-mono">
                        </div>
                    </div>
                </div>

                <!-- Form Action -->
                <div class="pt-6 border-t border-slate-800 flex justify-end">
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-brand font-bold uppercase tracking-wider px-6 py-3 rounded-xl transition-colors flex items-center gap-2 shadow-lg shadow-rose-600/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Synchronize API Keys</span>
                    </button>
                </div>

            </form>
        </div>
    </main>

</body>
</html>
