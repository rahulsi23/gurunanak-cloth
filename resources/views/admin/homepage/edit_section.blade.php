@extends('layouts.admin')

@section('title', 'Edit Section: ' . $section->section_type)

@section('head')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.homepage.index') }}" class="p-2 bg-slate-900 border border-slate-800 rounded-lg text-slate-400 hover:text-white transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="font-brand font-bold text-2xl text-white uppercase tracking-tight">{{ str_replace('_', ' ', $section->section_type) }} Section</h1>
    </div>
    <p class="text-xs text-slate-400">Modify the content data for this section. Changes reflect immediately on the home page.</p>
</div>

<form action="{{ route('admin.homepage.sections.update', $section) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6 border-b border-slate-800">
            <h3 class="font-brand font-bold text-sm text-white">Content Configuration</h3>
            <p class="text-[10px] text-slate-500 font-medium">Configure text, images, and links for this module</p>
        </div>
        
        <div class="p-8 space-y-8">
            @php
                $content = (array) $section->content;
                if ($section->section_type === 'hero') {
                    if (!array_key_exists('layout_mode', $content)) {
                        $content['layout_mode'] = 'image';
                    }
                    if (!array_key_exists('video', $content)) {
                        $content['video'] = '';
                    }
                }
            @endphp

            @foreach($content as $key => $value)
                <div class="space-y-4 pb-8 border-b border-slate-800 last:border-0">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-bold text-violet-400 uppercase tracking-[0.2em] block">{{ str_replace('_', ' ', $key) }}</label>
                        <span class="text-[9px] text-slate-600 font-mono uppercase tracking-tighter">Field: {{ $key }}</span>
                    </div>
                    
                    @if(is_array($value))
                        @if($key === 'product_slugs')
                            @php
                                $selectedSlugs = (!empty($value) && is_array($value)) ? array_values(array_filter($value)) : [];
                                while (count($selectedSlugs) < 4) {
                                    $selectedSlugs[] = '';
                                }
                            @endphp
                            <div class="space-y-4">
                                <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                    <div>
                                        <p class="text-xs font-bold text-slate-200 uppercase tracking-wide">Select Products via Dropdowns</p>
                                        <p class="text-[10px] text-slate-400 font-medium">Select a product for each slot from the dropdown list. Its live image, collection, and price appear automatically.</p>
                                    </div>
                                    <button 
                                        type="button" 
                                        onclick="addProductSlot()" 
                                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-violet-600/30 shrink-0 cursor-pointer"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        + Add Another Product
                                    </button>
                                </div>

                                <!-- Dynamic Product Dropdown Slots Grid -->
                                <div id="product-slots-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($selectedSlugs as $idx => $currentSlug)
                                        @php
                                            $currentProduct = !empty($currentSlug) ? $products->firstWhere('slug', $currentSlug) : null;
                                        @endphp
                                        <div class="product-slot-card p-4 bg-slate-950 border border-slate-800 rounded-xl space-y-3 relative group">
                                            <!-- Slot Header -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <span class="slot-number-badge w-5 h-5 rounded-full bg-violet-600/20 text-violet-400 border border-violet-500/30 flex items-center justify-center text-[10px] font-bold">{{ $idx + 1 }}</span>
                                                    <span class="text-xs font-bold text-slate-200">
                                                        Product <span class="slot-number-text">{{ $idx + 1 }}</span>
                                                    </span>
                                                </div>
                                                <button 
                                                    type="button" 
                                                    onclick="removeProductSlot(this)" 
                                                    class="text-[11px] text-slate-500 hover:text-red-400 transition-colors font-medium cursor-pointer"
                                                    title="Remove this slot"
                                                >
                                                    ✕ Remove
                                                </button>
                                            </div>

                                            <!-- Dropdown Select -->
                                            <div>
                                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Choose Product Dropdown:</label>
                                                <select 
                                                    name="content[{{ $key }}][]" 
                                                    onchange="updateProductPreview(this)" 
                                                    class="product-select-dropdown w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500 transition-all font-medium cursor-pointer"
                                                >
                                                    <option value="">-- Choose a Product (Click to Select) --</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->slug }}" 
                                                                data-image="{{ $product->image_url }}"
                                                                data-title="{{ $product->title }}"
                                                                data-category="{{ ucfirst($product->category_slug ?? $product->lookbook) }}"
                                                                data-price="{{ number_format($product->price, 2) }}"
                                                                {{ $currentSlug === $product->slug ? 'selected' : '' }}>
                                                            {{ $product->title }} ({{ ucfirst($product->category_slug ?? $product->lookbook) }} - ${{ number_format($product->price, 2) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Live Preview Box with Real Image -->
                                            <div class="product-preview-box {{ $currentProduct ? 'flex' : 'hidden' }} items-center gap-3 p-2.5 bg-slate-900/90 border border-slate-800 rounded-lg">
                                                <div class="w-12 h-14 rounded-md bg-slate-950 overflow-hidden shrink-0 border border-slate-700 relative">
                                                    <img 
                                                        src="{{ $currentProduct ? $currentProduct->image_url : '' }}" 
                                                        alt="{{ $currentProduct ? $currentProduct->title : '' }}" 
                                                        class="preview-img w-full h-full object-cover object-top"
                                                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80';"
                                                    >
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="preview-title text-xs font-bold text-white truncate">{{ $currentProduct ? $currentProduct->title : '' }}</p>
                                                    <div class="flex items-center gap-3 mt-1 text-[10px]">
                                                        <span class="preview-category text-slate-400 capitalize">Collection: {{ $currentProduct ? ucfirst($currentProduct->category_slug ?? $currentProduct->lookbook) : '' }}</span>
                                                        <span class="preview-price text-emerald-400 font-bold font-mono">${{ $currentProduct ? number_format($currentProduct->price, 2) : '0.00' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Placeholder when not selected -->
                                            <div class="product-empty-placeholder {{ $currentProduct ? 'hidden' : 'block' }} py-2.5 px-3 bg-slate-900/40 border border-dashed border-slate-800 rounded-lg text-center">
                                                <span class="text-[10px] text-slate-500">Please choose a product from the dropdown above.</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <script>
                            function updateProductPreview(selectElem) {
                                const card = selectElem.closest('.product-slot-card');
                                const previewBox = card.querySelector('.product-preview-box');
                                const emptyPlaceholder = card.querySelector('.product-empty-placeholder');
                                const selectedOption = selectElem.options[selectElem.selectedIndex];

                                if (selectElem.value && selectedOption && selectedOption.dataset.title) {
                                    previewBox.querySelector('.preview-img').src = selectedOption.dataset.image || '';
                                    previewBox.querySelector('.preview-title').textContent = selectedOption.dataset.title || '';
                                    previewBox.querySelector('.preview-category').textContent = 'Collection: ' + (selectedOption.dataset.category || '');
                                    previewBox.querySelector('.preview-price').textContent = '$' + (selectedOption.dataset.price || '0.00');
                                    previewBox.classList.remove('hidden');
                                    previewBox.classList.add('flex');
                                    emptyPlaceholder.classList.add('hidden');
                                    emptyPlaceholder.classList.remove('block');
                                } else {
                                    previewBox.classList.add('hidden');
                                    previewBox.classList.remove('flex');
                                    emptyPlaceholder.classList.remove('hidden');
                                    emptyPlaceholder.classList.add('block');
                                }
                            }

                            function removeProductSlot(btn) {
                                const container = document.getElementById('product-slots-container');
                                const cards = container.querySelectorAll('.product-slot-card');
                                if (cards.length > 1) {
                                    btn.closest('.product-slot-card').remove();
                                    reindexSlots();
                                } else {
                                    const select = cards[0].querySelector('select');
                                    select.value = '';
                                    updateProductPreview(select);
                                }
                            }

                            function addProductSlot() {
                                const container = document.getElementById('product-slots-container');
                                const firstCard = container.querySelector('.product-slot-card');
                                if (!firstCard) return;

                                const newCard = firstCard.cloneNode(true);
                                const select = newCard.querySelector('select');
                                select.value = '';
                                updateProductPreview(select);
                                container.appendChild(newCard);
                                reindexSlots();
                            }

                            function reindexSlots() {
                                const container = document.getElementById('product-slots-container');
                                const cards = container.querySelectorAll('.product-slot-card');
                                cards.forEach((card, idx) => {
                                    const num = idx + 1;
                                    const badge = card.querySelector('.slot-number-badge');
                                    const text = card.querySelector('.slot-number-text');
                                    if (badge) badge.textContent = num;
                                    if (text) text.textContent = num;
                                });
                            }
                            </script>
                        @elseif($key === 'images' || str_contains($key, 'gallery'))
                            <!-- Gallery Uploader -->
                            <div class="space-y-4" x-data="{ 
                                items: [],
                                init() {
                                    try {
                                        const raw = this.$el.dataset.gallery;
                                        const parsed = JSON.parse(raw || '[]');
                                        this.items = (Array.isArray(parsed) ? parsed : []).map((url, i) => ({ 
                                            id: Date.now() + i + Math.random().toString(), 
                                            url: url, 
                                            preview: url 
                                        }));
                                    } catch(e) {
                                        this.items = [];
                                    }
                                },
                                addNew() {
                                    this.items.push({ id: Date.now() + Math.random().toString(), url: '', preview: '' });
                                },
                                handleFileChange(idx, event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        this.items[idx].preview = URL.createObjectURL(file);
                                    }
                                }
                            }" data-gallery="{{ json_encode($value) }}">
                                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
                                    <template x-for="(item, idx) in items" :key="item.id">
                                        <div class="relative group aspect-square rounded-xl overflow-hidden border border-slate-800 bg-slate-950 flex items-center justify-center">
                                            <template x-if="item.preview">
                                                <img :src="item.preview" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!item.preview">
                                                <div class="flex flex-col items-center text-slate-600">
                                                    <svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    <span class="text-[8px] font-bold uppercase">No Image</span>
                                                </div>
                                            </template>

                                            <!-- Keep existing URL in hidden field so it is preserved if no new file is uploaded -->
                                            <input type="hidden" :name="`content[${key}][${idx}]`" :value="item.url">

                                            <!-- File upload triggers handleFileChange for instant local preview -->
                                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                                                <input type="file" :name="`content[${key}][${idx}]`" @change="handleFileChange(idx, $event)" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                <span class="text-[8px] text-white font-bold uppercase">Upload</span>
                                            </div>

                                            <button type="button" @click="items.splice(idx, 1)" class="absolute top-2 right-2 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition-all shadow-lg z-20">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    </template>
                                    <button type="button" @click="addNew()" class="aspect-square rounded-xl border-2 border-dashed border-slate-800 hover:border-violet-500 hover:bg-violet-500/5 transition-all flex flex-col items-center justify-center gap-2 text-slate-500 hover:text-violet-400">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        <span class="text-[9px] font-bold uppercase">Add Photo</span>
                                    </button>
                                </div>
                            </div>
                        @elseif($key === 'categories')
                            <!-- Category Array Manager -->
                            <div class="space-y-4" x-data="{ items: @json($value) }">
                                <template x-for="(cat, idx) in items" :key="idx">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-slate-950 border border-slate-800 rounded-2xl relative group">
                                        <div class="space-y-1">
                                            <label class="text-[8px] text-slate-500 font-bold uppercase">Title</label>
                                            <input type="text" :name="`content[${key}][${idx}][title]`" x-model="cat.title" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-[10px] text-white">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[8px] text-slate-500 font-bold uppercase">Slug/URL</label>
                                            <input type="text" :name="`content[${key}][${idx}][slug]`" x-model="cat.slug" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1.5 text-[10px] text-white">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-[8px] text-slate-500 font-bold uppercase">Image</label>
                                            <div class="flex gap-2 items-center">
                                                <div class="w-10 h-10 rounded bg-slate-900 overflow-hidden shrink-0 border border-slate-800">
                                                    <img :src="cat.image" class="w-full h-full object-cover">
                                                </div>
                                                <input type="file" :name="`content[${key}][${idx}][image]`" class="flex-1 text-[8px] text-slate-500">
                                                <input type="hidden" :name="`content[${key}][${idx}][image]`" :value="cat.image">
                                            </div>
                                        </div>
                                        <button type="button" @click="items.splice(idx, 1)" class="absolute -top-2 -right-2 p-1.5 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-all shadow-lg">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="items.push({title: '', slug: '', image: ''})" class="w-full py-3 rounded-2xl border-2 border-dashed border-slate-800 hover:border-violet-500 hover:bg-violet-500/5 transition-all text-slate-500 hover:text-violet-400 text-[10px] font-bold uppercase">
                                    + Add New Category Card
                                </button>
                            </div>
                        @else
                            <textarea name="content[{{ $key }}]" rows="5" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-none focus:border-violet-500 transition-all font-mono">{{ json_encode($value, JSON_PRETTY_PRINT) }}</textarea>
                        @endif
                    @elseif($key === 'layout_mode')
                        <div class="space-y-3">
                            <p class="text-[10px] text-slate-500 font-medium font-brand">Select the active layout style for your homepage Hero section. (Cinematic Video layout requires a valid video link configured below).</p>
                            <div class="w-full sm:w-80">
                                <select name="content[{{ $key }}]" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3.5 text-xs text-slate-300 font-bold uppercase tracking-wider focus:outline-none focus:border-violet-500 transition-all">
                                    <option value="image" {{ $value === 'image' ? 'selected' : '' }}>📸 Image Banner Layout (Zara-Style Split Grid)</option>
                                    <option value="video" {{ $value === 'video' ? 'selected' : '' }}>🎬 Immersive Cinematic Video Layout (Singer-Style Full Background)</option>
                                </select>
                            </div>
                        </div>
                    @elseif(str_contains($key, 'video'))
                        <div class="space-y-3" x-data="{ preview: '{{ $value }}' }">
                            <div class="flex flex-col sm:flex-row items-start gap-6">
                                <div class="w-48 aspect-video rounded-2xl overflow-hidden border-2 border-slate-800 shrink-0 shadow-2xl relative group bg-slate-950 flex items-center justify-center">
                                    <template x-if="preview">
                                        <video :src="preview" autoplay loop muted playsinline class="w-full h-full object-cover"></video>
                                    </template>
                                    <template x-if="!preview">
                                        <div class="flex flex-col items-center text-slate-600">
                                            <svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            <span class="text-[8px] font-bold uppercase text-slate-500">No Video background</span>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex-1 w-full space-y-3">
                                    <div class="relative overflow-hidden group">
                                        <button type="button" class="w-full py-3 bg-slate-950 border border-slate-800 hover:border-violet-500 rounded-xl text-[10px] font-bold text-slate-400 hover:text-violet-400 transition-all flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Upload New Video File (.mp4)
                                        </button>
                                        <input type="file" name="content[{{ $key }}]" accept="video/*" @change="preview = URL.createObjectURL($event.target.files[0])" class="absolute inset-0 opacity-0 cursor-pointer">
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[9px] text-slate-600 font-bold uppercase">Video URL:</span>
                                            <input type="text" name="content[{{ $key }}]" x-model="preview" class="flex-1 bg-slate-950 border border-slate-800 rounded-lg px-3 py-1.5 text-[10px] text-slate-300 focus:outline-none focus:border-violet-500" placeholder="e.g. https://assets.mixkit.co/...mp4">
                                        </div>
                                        <p class="text-[8px] text-slate-500">Upload a custom video or paste any video link (e.g. from Pexels, Mixkit, or storage). Leave blank to disable video background and use image banner layout instead.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(str_contains($key, 'image'))
                        <div class="space-y-3" x-data="{ preview: '{{ $value }}' }">
                            <div class="flex items-center gap-6">
                                <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-slate-800 shrink-0 shadow-2xl relative group bg-slate-950">
                                    <img :src="preview" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </div>
                                </div>
                                <div class="flex-1 space-y-3">
                                    <div class="relative overflow-hidden group">
                                        <button type="button" class="w-full py-3 bg-slate-950 border border-slate-800 hover:border-violet-500 rounded-xl text-[10px] font-bold text-slate-400 hover:text-violet-400 transition-all flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Choose New Image File
                                        </button>
                                        <input type="file" name="content[{{ $key }}]" @change="preview = URL.createObjectURL($event.target.files[0])" class="absolute inset-0 opacity-0 cursor-pointer">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] text-slate-600 font-bold uppercase">Current URL:</span>
                                        <input type="text" name="content[{{ $key }}]" x-model="preview" class="flex-1 bg-transparent border-0 p-0 text-[9px] text-slate-500 focus:ring-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(str_contains($key, 'url'))
                        <div class="flex flex-col sm:flex-row gap-3" x-data="{ 
                            type: 'custom',
                            url: '{{ $value }}',
                            init() {
                                if(this.url.includes('/collection/')) this.type = 'collection';
                                else if(this.url.includes('/product/detail/')) this.type = 'product';
                            }
                        }">
                            <div class="w-full sm:w-40">
                                <select x-model="type" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2.5 text-[10px] text-slate-400 font-bold uppercase tracking-wider focus:outline-none focus:border-violet-500 transition-all">
                                    <option value="custom">Custom URL</option>
                                    <option value="collection">Collection</option>
                                    <option value="product">Product</option>
                                </select>
                            </div>
                            
                            <div class="flex-1">
                                <!-- Custom URL Input -->
                                <div x-show="type === 'custom'">
                                    <input type="text" name="content[{{ $key }}]" x-model="url" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-[10px] text-slate-200 focus:outline-none focus:border-violet-500 transition-all" placeholder="Enter custom URL">
                                </div>

                                <!-- Collection Picker -->
                                <div x-show="type === 'collection'">
                                    <select @change="url = '/collection/' + $event.target.value" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-[10px] text-slate-200 focus:outline-none focus:border-violet-500">
                                        <option value="">Select a Collection</option>
                                        @foreach(['men', 'women', 'oversized', 'summer', 'streetwear', 'accessories'] as $type)
                                            <option value="{{ $type }}" {{ str_contains($value, '/collection/'.$type) ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="content[{{ $key }}]" :value="url">
                                </div>

                                <!-- Product Picker -->
                                <div x-show="type === 'product'">
                                    <select @change="url = '/product/detail/' + $event.target.value" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-[10px] text-slate-200 focus:outline-none focus:border-violet-500">
                                        <option value="">Select a Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->slug }}" {{ str_contains($value, '/product/detail/'.$product->slug) ? 'selected' : '' }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="content[{{ $key }}]" :value="url">
                                </div>
                            </div>
                        </div>
                    @elseif(strlen($value) > 100)
                        <textarea name="content[{{ $key }}]" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-none focus:border-violet-500 transition-all">{{ $value }}</textarea>
                    @else
                        <input type="text" name="content[{{ $key }}]" value="{{ $value }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-none focus:border-violet-500 transition-all">
                    @endif
                </div>
            @endforeach
        </div>

        <div class="px-8 py-6 bg-slate-950 border-t border-slate-800 flex justify-end gap-3">
            <a href="{{ route('admin.homepage.index') }}" class="px-6 py-2.5 bg-slate-900 text-slate-300 hover:text-white rounded-xl text-xs font-bold transition-all border border-slate-800">Cancel</a>
            <button type="submit" class="px-8 py-2.5 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-600/30 transition-all">
                Publish Changes
            </button>
        </div>
    </div>
</form>

<div class="mt-8 bg-amber-500/10 border border-amber-500/20 rounded-2xl p-6">
    <div class="flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-amber-500/20 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <h4 class="text-xs font-bold text-amber-500 mb-1">Safety Note</h4>
            <p class="text-[10px] text-slate-400 leading-relaxed font-medium">If you are editing JSON data (textareas with brackets), ensure the format remains valid. Broken JSON might cause display issues on the home page.</p>
        </div>
    </div>
</div>
@endsection
