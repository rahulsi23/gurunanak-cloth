<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin Console</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Jodit Editor CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@3.24.2/build/jodit.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/jodit@3.24.2/build/jodit.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-brand { font-family: 'Outfit', sans-serif; }
        /* Premium custom overrides for Jodit Editor to blend cleanly with Slate-950 UI */
        .jodit-container {
            border: 1px solid #1e293b !important;
            background-color: #020617 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
        }
        .jodit-workplace {
            background-color: #020617 !important;
            color: #f1f5f9 !important;
        }
        .jodit-wysiwyg {
            color: #f1f5f9 !important;
            font-size: 13px !important;
            line-height: 1.6 !important;
        }
        .jodit-toolbar__box {
            background-color: #0f172a !important;
            border-bottom: 1px solid #1e293b !important;
        }
        .jodit-status-bar {
            background-color: #0f172a !important;
            border-top: 1px solid #1e293b !important;
            color: #64748b !important;
        }
    </style>
</head>
<body class="h-full flex flex-col bg-slate-950 text-slate-100">

    <header class="h-16 border-b border-slate-800 bg-slate-900/90 backdrop-blur-xl px-4 md:px-8 flex items-center justify-between shrink-0 sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 via-violet-700 to-indigo-800 flex items-center justify-center font-brand font-bold text-lg text-white tracking-tighter">
                GC
            </div>
            <div>
                <span class="font-brand font-bold text-base tracking-tight text-white block leading-none">gurunanak<span class="text-violet-400">panel</span></span>
                <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Product Editing Portal</span>
            </div>
        </div>
        <div class="flex items-center gap-4 text-xs font-medium">
            <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition-colors">Dashboard</a>
            <span class="text-slate-800">|</span>
            <a href="{{ route('admin.products.index') }}" class="text-slate-400 hover:text-white transition-colors">Products List</a>
            <span class="text-slate-800">|</span>
            <a href="{{ route('admin.orders.index') }}" class="text-slate-400 hover:text-white transition-colors">Customer Orders</a>
        </div>
    </header>

    <main class="flex-1 max-w-4xl w-full mx-auto p-5 md:p-8 space-y-6">
        
        <div class="pb-4 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Catalog Update</span>
                <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Edit "{{ $product->title }}"</h1>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                    Update your listed item parameters using everyday terms below. You can update SEO keywords or drop a replacement image to recompile its WebP package instantly.
                </p>
            </div>
            <a href="{{ url('/product/detail/' . $product->slug) }}" target="_blank" class="shrink-0 px-3 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white text-xs transition-all border border-slate-800 inline-flex items-center gap-1.5 self-start sm:self-auto">
                <span>View Live Link</span>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-xs text-rose-400 space-y-1">
                <strong class="font-semibold block mb-1">Please fix the following validation errors:</strong>
                <ul class="list-disc pl-4 space-y-0.5 text-rose-300">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8 bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm">
            @csrf
            @method('PUT')

            <!-- Section 1: Core Details -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-violet-400 pb-2 border-b border-slate-800">
                    1. Primary Details
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Product Name *</label>
                        <input type="text" name="title" value="{{ old('title', $product->title) }}" required class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">URL Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Product Subtitle / Tagline</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $product->subtitle) }}" class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Price ($ USD) *</label>
                        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all font-semibold">
                    </div>
                </div>
            </div>

            <!-- Section 2: Storefront Setup -->
            <div class="space-y-4 pt-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-violet-400 pb-2 border-b border-slate-800">
                    2. Collection & Categories
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Collection Page *</label>
                        <select name="lookbook" required class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all cursor-pointer">
                            @foreach($lookbooks as $key => $label)
                                <option value="{{ $key }}" {{ old('lookbook', $product->lookbook) === $key ? 'selected' : '' }}>{{ $label }} ({{ $key }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Category Type *</label>
                        <input type="text" name="category_slug" value="{{ old('category_slug', $product->category_slug) }}" required class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all font-mono">
                    </div>
                </div>

                <!-- Removed static sizes text input. Replaced by Inventory Matrix below -->

            <!-- Section 2.5: Live Inventory Matrix Engine -->
            <div class="space-y-4 pt-2" id="inventory-matrix-section">
                <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-amber-400">
                        Live Inventory & Variations
                    </h3>
                    <button type="button" onclick="addVariationRow()" class="px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-lg text-[10px] font-bold hover:bg-amber-500/20 transition-colors">
                        + Add Variation
                    </button>
                </div>
                
                <p class="text-[10px] text-slate-500">Update exact physical stock counts per size and color combination.</p>

                <div id="variations-container" class="space-y-3">
                    @if($product->variations->count() > 0)
                        @foreach($product->variations as $idx => $variation)
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-950 border border-slate-800 variation-row">
                                <div class="flex-1">
                                    <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Size</label>
                                    <input type="text" name="variations[{{$idx}}][size]" value="{{ $variation->size_label }}" placeholder="e.g. M" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Color</label>
                                    <input type="text" name="variations[{{$idx}}][color]" value="{{ $variation->color_label }}" placeholder="e.g. Black" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                                </div>
                                <div class="w-24">
                                    <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Stock Qty</label>
                                    <input type="number" name="variations[{{$idx}}][stock]" value="{{ $variation->stock_quantity }}" min="0" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                                </div>
                                <div class="w-24">
                                    <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">SKU (Opt)</label>
                                    <input type="text" name="variations[{{$idx}}][sku]" value="{{ $variation->sku_code }}" placeholder="SKU-X" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                                </div>
                                <div class="pt-4">
                                    <button type="button" onclick="this.closest('.variation-row').remove()" class="text-rose-500 hover:text-rose-400 p-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Default Blank Row if no variations exist -->
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-950 border border-slate-800 variation-row">
                            <div class="flex-1">
                                <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Size</label>
                                <input type="text" name="variations[0][size]" placeholder="e.g. M" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                            </div>
                            <div class="flex-1">
                                <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Color</label>
                                <input type="text" name="variations[0][color]" placeholder="e.g. Black" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                            </div>
                            <div class="w-24">
                                <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Stock Qty</label>
                                <input type="number" name="variations[0][stock]" value="10" min="0" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                            </div>
                            <div class="w-24">
                                <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">SKU (Opt)</label>
                                <input type="text" name="variations[0][sku]" placeholder="SKU-1" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                            </div>
                            <div class="pt-4">
                                <button type="button" onclick="this.closest('.variation-row').remove()" class="text-rose-500 hover:text-rose-400 p-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 3: Image & Guidelines -->
            <div class="space-y-4 pt-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-violet-400 pb-2 border-b border-slate-800">
                    3. Product Image & Description
                </h3>

                <!-- Multiple Images Uploader with Star Selection -->
                <div x-data="mediaUploader()" x-init="init()" class="space-y-4">
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">Product Media (उत्पाद तस्वीरें)</label>
                    
                    <!-- Previews & File Drag/Drop Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 p-4 rounded-xl bg-slate-950 border border-slate-800 min-h-[160px]">
                        
                        <!-- Existing Images (from database) -->
                        <template x-for="(img, index) in existingImages" :key="img.id">
                            <div class="group relative aspect-[3/4] rounded-lg overflow-hidden border border-slate-700 bg-slate-900 transition-all duration-300 hover:scale-[1.03] hover:border-violet-500/50 shadow-lg">
                                <img :src="img.image_path" class="w-full h-full object-cover object-top" />
                                
                                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                
                                <!-- Star Selector (Top Left) -->
                                <button type="button" @click="setPrimary('existing', img.id)" 
                                        class="absolute top-2 left-2 p-1.5 rounded-lg backdrop-blur-md transition-all duration-200 shadow-md"
                                        :class="isPrimary('existing', img.id) ? 'bg-amber-500 text-white scale-110' : 'bg-black/50 text-slate-400 hover:text-amber-400 group-hover:block hidden'">
                                    <svg class="w-3.5 h-3.5" :fill="isPrimary('existing', img.id) ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.977-2.888a1 1 0 00-1.176 0l-3.977 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </button>
                                
                                <!-- Remove Button (Top Right) -->
                                <button type="button" @click="removeExisting(index, img.id)" 
                                        class="absolute top-2 right-2 p-1.5 rounded-lg bg-black/50 hover:bg-rose-600/90 text-slate-300 hover:text-white backdrop-blur-md transition-all duration-200 shadow-md group-hover:block hidden">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                
                                <div x-show="isPrimary('existing', img.id)" class="absolute bottom-2 left-2 right-2 text-center py-0.5 rounded bg-amber-500/90 backdrop-blur-xs text-[9px] font-brand font-bold uppercase tracking-wider text-white select-none">
                                    Featured
                                </div>
                            </div>
                        </template>

                        <!-- Newly Uploaded Images Previews -->
                        <template x-for="(img, index) in newImages" :key="img.id">
                            <div class="group relative aspect-[3/4] rounded-lg overflow-hidden border border-slate-700 bg-slate-900 transition-all duration-300 hover:scale-[1.03] hover:border-violet-500/50 shadow-lg">
                                <img :src="img.url" class="w-full h-full object-cover object-top" />
                                
                                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                
                                <!-- Star Selector (Top Left) -->
                                <button type="button" @click="setPrimary('new', index)" 
                                        class="absolute top-2 left-2 p-1.5 rounded-lg backdrop-blur-md transition-all duration-200 shadow-md"
                                        :class="isPrimary('new', index) ? 'bg-amber-500 text-white scale-110' : 'bg-black/50 text-slate-400 hover:text-amber-400 group-hover:block hidden'">
                                    <svg class="w-3.5 h-3.5" :fill="isPrimary('new', index) ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.977-2.888a1 1 0 00-1.176 0l-3.977 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </button>
                                
                                <!-- Remove Button (Top Right) -->
                                <button type="button" @click="removeNew(index)" 
                                        class="absolute top-2 right-2 p-1.5 rounded-lg bg-black/50 hover:bg-rose-600/90 text-slate-300 hover:text-white backdrop-blur-md transition-all duration-200 shadow-md group-hover:block hidden">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                
                                <div x-show="isPrimary('new', index)" class="absolute bottom-2 left-2 right-2 text-center py-0.5 rounded bg-amber-500/90 backdrop-blur-xs text-[9px] font-brand font-bold uppercase tracking-wider text-white select-none">
                                    Featured
                                </div>
                            </div>
                        </template>
                        
                        <!-- Add More Button -->
                        <button type="button" @click="$refs.fileInput.click()" 
                                class="flex flex-col items-center justify-center aspect-[3/4] rounded-lg border-2 border-dashed border-slate-800 hover:border-violet-500 bg-slate-900/20 hover:bg-slate-900/60 transition-all duration-300 group cursor-pointer p-4 text-center">
                            <div class="w-8 h-8 rounded-full bg-slate-900 group-hover:bg-violet-600/10 flex items-center justify-center text-slate-400 group-hover:text-violet-400 transition-all duration-300 mb-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-400 group-hover:text-slate-300 uppercase">Add Photos</span>
                        </button>
                    </div>
                    
                    <input type="file" x-ref="fileInput" name="product_images[]" multiple accept="image/*" class="hidden" @change="handleFiles($event)" />
                    
                    <!-- Form Submission States -->
                    <input type="hidden" name="primary_image_source" :value="primarySource" />
                    <input type="hidden" name="primary_image_id" :value="primaryValue" />
                    <input type="hidden" name="primary_image_index" :value="primarySource === 'new' ? primaryValue : ''" />
                    
                    <!-- Deletion Queue Hidden Inputs -->
                    <template x-for="id in deletedImageIds" :key="id">
                        <input type="hidden" name="deleted_image_ids[]" :value="id" />
                    </template>
                    
                    <!-- Validation Check: At least one image remaining/added -->
                    <input type="text" name="media_presence" :value="(existingImages.length + newImages.length) > 0 ? 'yes' : ''" required class="opacity-0 w-0 h-0 pointer-events-none absolute" />

                    <p class="text-[10px] text-slate-500 mt-1 leading-normal">
                        💡 <strong>Pro Tip:</strong> Click the <span class="text-amber-400">★ Star</span> icon on the image you want to show first on the website (Main cover photo).
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            <span>Short Description (संक्षिप्त विवरण)</span>
                        </label>
                        <textarea id="short_description" name="short_description" class="w-full">{{ old('short_description', $product->short_description) }}</textarea>
                        <span class="text-[10px] text-slate-500 block mt-1">A brief summary of the garment displayed prominently under the title.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Full Product Story (विस्तृत कहानी)</span>
                        </label>
                        <textarea id="description" name="description" class="w-full">{{ old('description', $product->description) }}</textarea>
                        <span class="text-[10px] text-slate-500 block mt-1">Detailed story, fabric composition, wash care instructions, and styling tips.</span>
                    </div>
                </div>
            </div>

            <!-- Section 4: Localized SEO Fields -->
            <div class="space-y-4 pt-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-400 pb-2 border-b border-slate-800 flex items-center gap-2">
                    <span>4. Search Engine Optimization (SEO)</span>
                    <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 text-[9px] font-bold">Google Friendly</span>
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">SEO Title (Meta Title)</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" placeholder="Custom title output shown in browser tabs and search engines" class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-emerald-500 transition-all">
                        <span class="text-[10px] text-slate-500 block mt-1">If left blank, storefront themes fallback gracefully to the standard product name string.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">SEO Description (Meta Description)</label>
                        <textarea name="meta_description" rows="2" placeholder="Custom summary text presented under Google search results..." class="w-full rounded-xl bg-slate-950 border border-slate-800 p-3 text-xs text-white focus:outline-none focus:border-emerald-500 transition-all">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-medium transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-700 text-white text-xs font-semibold transition-all shadow-md shadow-violet-600/20">
                    Save Updates
                </button>
            </div>

        </form>

    </main>

    <footer class="mt-auto py-4 px-6 border-t border-slate-800 bg-slate-950 text-center text-xs text-slate-600">
        <p>© {{ date('Y') }} Gurunanak Console. Equipped with native SEO fields and automated WebP compilation.</p>
    </footer>

    <script>
        let varCount = {{ max(1, $product->variations->count()) }};
        function addVariationRow() {
            const container = document.getElementById('variations-container');
            const row = document.createElement('div');
            row.className = 'flex items-center gap-3 p-3 rounded-lg bg-slate-950 border border-slate-800 variation-row';
            row.innerHTML = `
                <div class="flex-1">
                    <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Size</label>
                    <input type="text" name="variations[${varCount}][size]" placeholder="e.g. M" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                </div>
                <div class="flex-1">
                    <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Color</label>
                    <input type="text" name="variations[${varCount}][color]" placeholder="e.g. Black" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                </div>
                <div class="w-24">
                    <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">Stock Qty</label>
                    <input type="number" name="variations[${varCount}][stock]" value="10" min="0" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                </div>
                <div class="w-24">
                    <label class="block text-[9px] uppercase tracking-wider text-slate-500 mb-1 font-bold">SKU (Opt)</label>
                    <input type="text" name="variations[${varCount}][sku]" placeholder="SKU-X" class="w-full bg-slate-900 border border-slate-700 rounded px-2.5 py-1.5 text-xs text-white focus:border-amber-500 outline-none">
                </div>
                <div class="pt-4">
                    <button type="button" onclick="this.closest('.variation-row').remove()" class="text-rose-500 hover:text-rose-400 p-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            container.appendChild(row);
            varCount++;
        }

        // Initialize Jodit Editors
        document.addEventListener('DOMContentLoaded', function() {
            const joditConfig = {
                theme: 'dark',
                height: 350,
                uploader: {
                    insertImageAsBase64URI: true
                },
                buttons: [
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'ul', 'ol', '|',
                    'font', 'fontsize', 'paragraph', '|',
                    'image', 'table', 'link', '|',
                    'align', 'undo', 'redo', '|',
                    'fullsize', 'preview', 'print'
                ]
            };

            const joditShort = Jodit.make('#short_description', {
                ...joditConfig,
                placeholder: 'Start writing a beautiful, premium short description...',
                height: 200
            });

            const joditFull = Jodit.make('#description', {
                ...joditConfig,
                placeholder: 'Start writing the full product story and heritage...',
                height: 400
            });
        });
    </script>
    <script>
        function mediaUploader() {
            return {
                existingImages: @json($product->images),
                newImages: [],
                deletedImageIds: [],
                primarySource: 'existing',
                primaryValue: null,
                nextId: 1,

                init() {
                    const currentPrimary = "{{ $product->image_path }}";
                    const found = this.existingImages.find(img => img.image_path === currentPrimary);
                    if (found) {
                        this.primarySource = 'existing';
                        this.primaryValue = found.id;
                    } else if (this.existingImages.length > 0) {
                        this.primarySource = 'existing';
                        this.primaryValue = this.existingImages[0].id;
                    } else {
                        this.primarySource = 'none';
                        this.primaryValue = null;
                    }
                },

                handleFiles(event) {
                    const files = Array.from(event.target.files);
                    if (!files.length) return;

                    files.forEach(file => {
                        const reader = new FileReader();
                        const id = this.nextId++;
                        reader.onload = (e) => {
                            this.newImages.push({
                                id: id,
                                file: file,
                                url: e.target.result
                            });

                            if (this.primarySource === 'none') {
                                this.primarySource = 'new';
                                this.primaryValue = 0;
                            }

                            this.updateFileInput();
                        };
                        reader.readAsDataURL(file);
                    });

                    event.target.value = '';
                },

                removeExisting(index, id) {
                    this.existingImages.splice(index, 1);
                    this.deletedImageIds.push(id);

                    if (this.primarySource === 'existing' && this.primaryValue == id) {
                        this.selectFallbackPrimary();
                    }
                },

                removeNew(index) {
                    this.newImages.splice(index, 1);
                    
                    if (this.primarySource === 'new' && this.primaryValue == index) {
                        this.selectFallbackPrimary();
                    } else if (this.primarySource === 'new' && this.primaryValue > index) {
                        this.primaryValue--;
                    }

                    this.updateFileInput();
                },

                setPrimary(source, val) {
                    this.primarySource = source;
                    this.primaryValue = val;
                },

                isPrimary(source, val) {
                    return this.primarySource === source && this.primaryValue == val;
                },

                selectFallbackPrimary() {
                    if (this.existingImages.length > 0) {
                        this.primarySource = 'existing';
                        this.primaryValue = this.existingImages[0].id;
                    } else if (this.newImages.length > 0) {
                        this.primarySource = 'new';
                        this.primaryValue = 0;
                    } else {
                        this.primarySource = 'none';
                        this.primaryValue = null;
                    }
                },

                updateFileInput() {
                    const dt = new DataTransfer();
                    this.newImages.forEach(img => {
                        dt.items.add(img.file);
                    });
                    this.$refs.fileInput.files = dt.files;
                }
            }
        }
    </script>
</body>
</html>
