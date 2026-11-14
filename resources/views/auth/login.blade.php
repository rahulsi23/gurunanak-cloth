<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Login | GURUNANAK CLOTH HOUSE</title>

    <!-- Google Fonts Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Compiler -->
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
            color: #1c1917;
        }
        .font-brand { font-family: 'Montserrat', sans-serif; }
        .motion-soft { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>
</head>
<body class="antialiased selection:bg-[#f5efe6] selection:text-[#8b7355] h-screen w-screen flex flex-col justify-between bg-gradient-to-br from-[#fdfbf7] via-[#f5efe6] to-[#eae4d8] overflow-hidden">

    <!-- Premium Clean Header -->
    <header class="w-full py-3 px-6 text-center border-b border-[#eae4d8]/40 bg-white/60 backdrop-blur-md shrink-0">
        <a href="{{ url('/') }}" class="inline-block group select-none">
            <span class="block font-brand font-extrabold text-lg tracking-[0.25em] text-[#1c1917] leading-none group-hover:text-[#8b7355] transition-colors duration-300">
                GURUNANAK
            </span>
            <span class="block font-sans font-medium text-[8px] tracking-[0.45em] uppercase text-[#8b7355] mt-1">
                CLOTH HOUSE
            </span>
            <span class="block text-[8px] uppercase tracking-[0.3em] text-[#a08a75] mt-1 font-medium">Customer Access Portal</span>
        </a>
    </header>

    <!-- Main Active Workspace Card (Locked overflow to prevent trackpad up/down movement) -->
    <main class="flex-1 flex items-center justify-center p-2 w-full overflow-hidden">
        <div class="w-full max-w-md bg-white/95 backdrop-blur-md rounded-2xl border border-[#eae4d8] p-5 sm:p-6 shadow-[0_20px_60px_rgba(139,115,85,0.12)] relative overflow-hidden my-auto">
            
            <!-- Premium top radiant gradient bar -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#e6cda3] via-[#8b7355] to-[#e6cda3]"></div>

            <div class="text-center mb-4">
                <h1 class="font-brand text-base font-bold tracking-wider text-[#1c1917]">Welcome Back</h1>
                <p class="text-[11px] text-[#786451] mt-0.5 font-light leading-normal">
                    Please sign in to access your saved orders, wishlist, and profile settings.
                </p>
            </div>

            <!-- Validation Error Matrix -->
            @if ($errors->any())
                <div class="mb-3 p-2 bg-[#fff9f9] border-l-2 border-[#dc2626] rounded-r-md text-[11px] text-[#dc2626]">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Session Status indicator -->
            @if (session('status'))
                <div class="mb-3 p-2 bg-[#f5efe6] rounded-md text-[11px] text-[#8b7355] text-center font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-3.5">
                @csrf

                <!-- Email Address Input -->
                <div>
                    <label for="email" class="block font-brand text-[9px] uppercase tracking-wider text-[#786451] font-semibold mb-0.5">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="name@example.com"
                           class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl px-3.5 py-2 text-xs focus:outline-none focus:border-[#8b7355] focus:bg-white motion-soft transition-all placeholder:text-[#c1b5a5] shadow-xs">
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-0.5">
                        <label for="password" class="block font-brand text-[9px] uppercase tracking-wider text-[#786451] font-semibold">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[9px] text-[#8b7355] hover:text-[#786451] font-medium hover:underline motion-soft transition-colors">
                                Forgot Password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full bg-[#fdfbf7] border border-[#eae4d8] rounded-xl pl-3.5 pr-10 py-2 text-xs focus:outline-none focus:border-[#8b7355] focus:bg-white motion-soft transition-all placeholder:text-[#c1b5a5] shadow-xs">
                        <button type="button" onclick="const inp = document.getElementById('password'); inp.type = inp.type === 'password' ? 'text' : 'password';" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#a08a75] hover:text-[#8b7355] focus:outline-none p-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Simple Remember Me Toggle -->
                <div class="flex items-center pt-0.5">
                    <input id="remember_me" type="checkbox" name="remember" class="w-3.5 h-3.5 accent-[#8b7355] rounded border-[#eae4d8] cursor-pointer">
                    <label for="remember_me" class="ml-2 text-xs text-[#786451] select-none cursor-pointer font-light">
                        Remember my device
                    </label>
                </div>

                <!-- Submit Sign In Button -->
                <div class="pt-1.5">
                    <button type="submit" class="w-full bg-[#8b7355] text-white font-brand text-xs uppercase tracking-[0.15em] font-bold py-2.5 px-4 rounded-xl hover:bg-[#786451] hover:shadow-md motion-soft transition-all duration-300">
                        Sign In
                    </button>
                </div>

            </form>

            <!-- Registration Entry Link -->
            <div class="mt-4 pt-3 border-t border-[#eae4d8]/60 text-center">
                <p class="text-[11px] text-[#786451] font-light">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-brand text-[#8b7355] font-bold hover:underline ml-1 transition-colors">
                        Register here
                    </a>
                </p>
            </div>

        </div>
    </main>

    <!-- Warm Footer -->
    <footer class="w-full py-2.5 text-center text-[9px] uppercase tracking-widest text-[#a08a75] border-t border-[#eae4d8]/40 bg-white/40 backdrop-blur-xs font-light shrink-0">
        GURUNANAK CLOTH HOUSE • Premium Quality Defined
    </footer>

</body>
</html>
