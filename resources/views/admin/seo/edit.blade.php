<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit SEO Settings - "{{ $seo->page_name }}"</title>
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
            <a href="{{ route('admin.seo.index') }}" class="text-slate-400 hover:text-white transition-colors">SEO Index</a>
        </div>
    </header>

    <!-- Main Workspace Container -->
    <main class="flex-1 max-w-4xl w-full mx-auto p-5 md:p-8 space-y-6">
        
        <!-- Heading Block -->
        <div class="pb-4 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Metadata Composer</span>
                <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Edit SEO - "{{ $seo->page_name }}"</h1>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                    Optimize search discoverability parameters. Use the interactive live simulator below to check exact Google appearance.
                </p>
            </div>
            <a href="{{ route('admin.seo.index') }}" class="shrink-0 px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white text-xs transition-all border border-slate-800 inline-flex items-center gap-1.5 self-start sm:self-auto">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to list</span>
            </a>
        </div>

        <!-- Google Simulator & Form Container -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Edit Form (7 Cols) -->
            <form action="{{ route('admin.seo.update', $seo->id) }}" method="POST" class="lg:col-span-7 space-y-6 bg-slate-900 border border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm">
                @csrf
                @method('PUT')

                <!-- 1. Google Meta Tag Info -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-violet-400 pb-2 border-b border-slate-800 flex items-center justify-between">
                        <span>1. Primary Search Engine Tags</span>
                        <span class="text-[9px] text-slate-500 font-medium font-brand">Google & Bing</span>
                    </h3>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-medium text-slate-300">SEO Meta Title *</label>
                            <span id="title-counter" class="text-[10px] font-mono text-slate-500">0 / 60 Chars</span>
                        </div>
                        <input type="text" 
                               id="input-meta-title"
                               name="meta_title" 
                               value="{{ old('meta_title', $seo->meta_title) }}" 
                               required 
                               placeholder="e.g. GURUNANAK | Minimalist Luxury Garments" 
                               class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all">
                        <span class="text-[9px] text-slate-500 block mt-1">Recommended length: 50-60 characters. Avoid keyword stuffing.</span>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-medium text-slate-300">SEO Meta Description *</label>
                            <span id="desc-counter" class="text-[10px] font-mono text-slate-500">0 / 160 Chars</span>
                        </div>
                        <textarea id="input-meta-desc"
                                  name="meta_description" 
                                  rows="3" 
                                  required 
                                  placeholder="e.g. Discover structural luxury outerwear and fine raw silk fabrics..." 
                                  class="w-full rounded-xl bg-slate-950 border border-slate-800 p-3 text-xs text-white focus:outline-none focus:border-violet-500 transition-all">{{ old('meta_description', $seo->meta_description) }}</textarea>
                        <span class="text-[9px] text-slate-500 block mt-1">Recommended length: 120-160 characters. Include secondary page keywords.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Meta Keywords (Comma separated)</label>
                        <input type="text" 
                               name="meta_keywords" 
                               value="{{ old('meta_keywords', $seo->meta_keywords) }}" 
                               placeholder="luxury, silk drape, blazer jacket" 
                               class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all font-mono">
                    </div>
                </div>

                <!-- 2. Social Media Open Graph Info -->
                <div class="space-y-4 pt-4 border-t border-slate-800">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-400 pb-2 border-b border-slate-800 flex items-center justify-between">
                        <span>2. Social Sharing Tags (Open Graph)</span>
                        <span class="text-[9px] text-slate-500 font-medium font-brand">Facebook & WhatsApp</span>
                    </h3>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">og:title (Social Share Title)</label>
                        <input type="text" 
                               name="og_title" 
                               value="{{ old('og_title', $seo->og_title) }}" 
                               placeholder="e.g. GURUNANAK - Premium Luxury Collection" 
                               class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">og:description (Social Share Summary)</label>
                        <textarea name="og_description" 
                                  rows="2" 
                                  placeholder="e.g. Explore double-breasted woolen blazers and raw silk shirts tailored at our studio." 
                                  class="w-full rounded-xl bg-slate-950 border border-slate-800 p-3 text-xs text-white focus:outline-none focus:border-indigo-500 transition-all">{{ old('og_description', $seo->og_description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">og:image URL (Horizontal Ratio Recommendation)</label>
                        <input type="text" 
                               name="og_image" 
                               value="{{ old('og_image', $seo->og_image) }}" 
                               placeholder="https://images.unsplash.com/photo-..." 
                               class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-all font-mono">
                        <span class="text-[9px] text-slate-500 block mt-1">Image URL for previews on social feeds. Standard resolution is 1200 x 630.</span>
                    </div>
                </div>

                <!-- Submit buttons -->
                <div class="pt-4 border-t border-slate-800 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.seo.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-medium transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-700 text-white text-xs font-semibold transition-all shadow-md shadow-violet-600/20">
                        Save Page SEO Config
                    </button>
                </div>

            </form>

            <!-- Google Search Simulator Panel (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-4 shadow-sm">
                    <span class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold block mb-1">✨ Google Preview Simulator</span>
                    <p class="text-[11px] text-slate-400 leading-relaxed">
                        Below is a live, high-fidelity render of how search engines will present this page in users' query results.
                    </p>

                    <!-- Google Mockup Card -->
                    <div class="bg-white text-black p-4 rounded-xl border border-slate-200 shadow-sm space-y-1.5 text-left select-none">
                        <!-- Breadcrumbs -->
                        <div class="flex items-center gap-1.5 text-[11px] text-[#202124]">
                            <div class="w-4 h-4 rounded-full bg-[#f1f3f4] flex items-center justify-center font-bold text-[8px] text-slate-700">G</div>
                            <span class="truncate">gurunanak.com</span>
                            <span class="text-[#5f6368] font-bold text-[9px] font-sans">›</span>
                            <span class="text-[#5f6368] font-medium truncate">
                                @if($seo->page_key === 'home')
                                    welcome
                                @elseif($seo->page_key === 'shop')
                                    shop
                                @else
                                    collection &rsaquo; {{ $seo->page_key }}
                                @endif
                            </span>
                        </div>

                        <!-- Clickable Link Title -->
                        <h4 id="google-mock-title" class="text-[18px] text-[#1a0dab] hover:underline font-normal font-sans leading-tight cursor-pointer break-words">
                            {{ $seo->meta_title }}
                        </h4>

                        <!-- Meta Description snippet -->
                        <p id="google-mock-desc" class="text-[13px] text-[#4d5156] font-sans leading-relaxed break-words">
                            {{ $seo->meta_description }}
                        </p>
                    </div>
                </div>

                <!-- Length Validation Assistant -->
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-3 shadow-sm">
                    <span class="text-[10px] uppercase tracking-wider text-amber-400 font-bold block mb-1">SEO Health Parameters</span>
                    
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between items-center pb-2 border-b border-slate-800/60">
                            <span class="text-slate-400">Title Length Range:</span>
                            <span id="title-status" class="px-2 py-0.5 rounded text-[9px] font-bold">Checking...</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Description Length Range:</span>
                            <span id="desc-status" class="px-2 py-0.5 rounded text-[9px] font-bold">Checking...</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Small Footer -->
    <footer class="mt-auto py-4 px-6 border-t border-slate-800 bg-slate-950 text-center text-xs text-slate-600">
        <p>© {{ date('Y') }} Gurunanak Console. Cache flushing mechanism globally active.</p>
    </footer>

    <!-- Interactive Live Simulator Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputTitle = document.getElementById('input-meta-title');
            const inputDesc = document.getElementById('input-meta-desc');
            const mockTitle = document.getElementById('google-mock-title');
            const mockDesc = document.getElementById('google-mock-desc');
            const counterTitle = document.getElementById('title-counter');
            const counterDesc = document.getElementById('desc-counter');
            const statusTitle = document.getElementById('title-status');
            const statusDesc = document.getElementById('desc-status');

            function updateSimulator() {
                const titleVal = inputTitle.value.trim();
                const descVal = inputDesc.value.trim();

                // Mock content updates
                mockTitle.textContent = titleVal || 'GURUNANAK - Premium Luxury Clothing & Apparel';
                mockDesc.textContent = descVal || 'Discover minimal luxury clothing designed with Apple-style cleanliness and editorial presentation. Shop premium high-end fashion, outerwear, and modern bespoke collections.';

                // Length calculations
                const titleLen = titleVal.length;
                const descLen = descVal.length;

                counterTitle.textContent = `${titleLen} / 60 Chars`;
                counterDesc.textContent = `${descLen} / 160 Chars`;

                // Title Health status
                if (titleLen === 0) {
                    statusTitle.textContent = 'EMPTY';
                    statusTitle.className = 'px-2 py-0.5 rounded bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[9px] font-bold';
                } else if (titleLen < 30) {
                    statusTitle.textContent = 'TOO SHORT';
                    statusTitle.className = 'px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-bold';
                } else if (titleLen > 70) {
                    statusTitle.textContent = 'TOO LONG';
                    statusTitle.className = 'px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-bold';
                } else {
                    statusTitle.textContent = 'HEALTHY';
                    statusTitle.className = 'px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[9px] font-bold';
                }

                // Description Health status
                if (descLen === 0) {
                    statusDesc.textContent = 'EMPTY';
                    statusDesc.className = 'px-2 py-0.5 rounded bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[9px] font-bold';
                } else if (descLen < 100) {
                    statusDesc.textContent = 'TOO SHORT';
                    statusDesc.className = 'px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-bold';
                } else if (descLen > 180) {
                    statusDesc.textContent = 'TOO LONG';
                    statusDesc.className = 'px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[9px] font-bold';
                } else {
                    statusDesc.textContent = 'HEALTHY';
                    statusDesc.className = 'px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[9px] font-bold';
                }
            }

            inputTitle.addEventListener('input', updateSimulator);
            inputDesc.addEventListener('input', updateSimulator);
            
            // Trigger immediately to show loaded parameters
            updateSimulator();
        });
    </script>
</body>
</html>
