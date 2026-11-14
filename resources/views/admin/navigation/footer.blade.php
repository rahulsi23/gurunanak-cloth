@extends('layouts.admin')

@section('title', 'Footer Menu Builder')

@section('head')
<!-- Sortable.js for Drag and Drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<!-- Alpine.js for Modals & Interactive States -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
<div class="mb-8 flex items-center justify-between" x-data="{ open: false }">
    <div>
        <h1 class="font-brand font-bold text-2xl text-white">Store Footer Menu Builder</h1>
        <p class="text-xs text-slate-400">Design your store's footer columns, build link lists, and drag-and-drop elements to reorder column positions and links in real-time.</p>
    </div>
    <button @click="$dispatch('open-create-modal', { parentId: null })" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-600/30 transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Column Block
    </button>
</div>

<!-- Main Builder Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="navBuilder()">
    
    <!-- Left: Drag-and-Drop Structure (2/3) -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between bg-slate-900/50">
                <div>
                    <h3 class="font-brand font-bold text-sm text-white">Footer Columns & Links</h3>
                    <p class="text-[10px] text-slate-500 font-medium">Drag columns or sub-links to rearrange their order on the storefront</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[8px] font-bold text-emerald-400 uppercase tracking-widest">Active Footer</span>
                </div>
            </div>

            <!-- Drag and Drop Tree Root -->
            <div id="navigation-root" class="p-6 space-y-4">
                @forelse($menus as $menu)
                    <div data-id="{{ $menu->id }}" class="parent-menu-item bg-slate-950 border border-slate-800 hover:border-slate-700 rounded-2xl p-4 transition-all space-y-3">
                        
                        <!-- Parent Link Header -->
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <!-- Drag Handle -->
                                <div class="cursor-move text-slate-600 hover:text-violet-400 p-1 rounded hover:bg-slate-900 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-white flex items-center gap-2">
                                        {{ $menu->label }}
                                        <span class="text-[9px] text-slate-550 font-mono font-medium">(Column Header)</span>
                                    </h4>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-1">
                                <button @click="$dispatch('open-create-modal', { parentId: {{ $menu->id }}, parentLabel: '{{ $menu->label }}' })" class="p-1.5 text-violet-400 hover:bg-violet-500/10 rounded-lg transition-all" title="Add Link to Column">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </button>
                                <button @click="$dispatch('open-edit-modal', { id: {{ $menu->id }}, label: '{{ $menu->label }}', url: '{{ $menu->url }}' })" class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-900 rounded-lg transition-all" title="Edit Column Title">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.footer-navigation.destroy', $menu) }}" method="POST" onsubmit="return confirm('Caution! Deleting this column will permanently remove all its child links. Do you wish to proceed?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-600 hover:text-red-500 hover:bg-red-500/10 rounded-lg transition-all" title="Delete Column">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Nested Submenu list (Sortable) -->
                        <div class="submenu-container pl-8 pr-2 py-1 space-y-2 border-l border-slate-850" data-parent-id="{{ $menu->id }}">
                            @foreach($menu->children as $child)
                                <div data-id="{{ $child->id }}" class="submenu-item bg-slate-900/60 border border-slate-850 rounded-xl p-3 flex items-center justify-between gap-4 transition-all">
                                    <div class="flex items-center gap-3">
                                        <!-- Drag Handle -->
                                        <div class="cursor-move text-slate-700 hover:text-violet-400 p-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                        </div>
                                        <div>
                                            <span class="text-xs font-medium text-slate-300">{{ $child->label }}</span>
                                            <span class="text-[9px] text-slate-600 font-mono ml-2">({{ $child->url }})</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Child Actions -->
                                    <div class="flex items-center gap-1">
                                        <button @click="$dispatch('open-edit-modal', { id: {{ $child->id }}, label: '{{ $child->label }}', url: '{{ $child->url }}' })" class="p-1 text-slate-500 hover:text-white rounded transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <form action="{{ route('admin.footer-navigation.destroy', $child) }}" method="POST" onsubmit="return confirm('Remove this footer link?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 text-slate-700 hover:text-red-500 rounded transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($menu->children->count() === 0)
                                <div class="py-2.5 text-center text-[10px] text-slate-600 border border-dashed border-slate-855 rounded-xl">No links in this column yet. Click + to add one.</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center bg-slate-950 border border-slate-800 rounded-2xl">
                        <svg class="w-12 h-12 text-slate-700 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        <p class="text-xs text-slate-500">No footer columns registered yet.</p>
                        <button @click="$dispatch('open-create-modal', { parentId: null })" class="mt-4 px-4 py-2 bg-slate-900 border border-slate-800 hover:border-violet-500 rounded-xl text-[10px] font-bold text-violet-400 transition-all">
                            Create First Footer Column
                        </button>
                    </div>
                @endforelse
            </div>
            
            <div class="px-6 py-4 bg-slate-950 border-t border-slate-800 flex justify-between items-center">
                <span class="text-[9px] text-slate-600">Reordering automatically saves in background</span>
                <button id="save-order-btn" onclick="saveMenuHierarchy()" class="px-5 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-[10px] font-bold shadow-lg shadow-violet-600/20 transition-all hidden">
                    Apply Layout Arrangement
                </button>
            </div>
        </div>
    </div>

    <!-- Right side helper guide -->
    <div class="space-y-6">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
            <h4 class="font-brand font-bold text-xs text-white uppercase tracking-wider">How to manage columns</h4>
            <ul class="text-[10px] text-slate-400 space-y-2 leading-relaxed">
                <li class="flex gap-2"><span class="text-violet-400 font-bold">•</span> Top-level elements represent footer columns. Drag-and-drop to change column sequence.</li>
                <li class="flex gap-2"><span class="text-violet-400 font-bold">•</span> Click the <svg class="w-3.5 h-3.5 inline text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> icon on any column header to add dynamic links under it.</li>
                <li class="flex gap-2"><span class="text-violet-400 font-bold">•</span> Link fields have a **Smart Link Selector** where you can choose a collection or specific products dynamically.</li>
            </ul>
        </div>
        
        <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-6 shadow-xl">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <h5 class="text-xs font-bold text-amber-500 mb-1">Layout Note</h5>
                    <p class="text-[10px] text-slate-400 leading-relaxed">These columns are rendered dynamically inside the storefront footer, right next to the scannable QR Code and Visual Branding logo block.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Link (Alpine Managed) -->
<div x-data="createModal()" 
     @open-create-modal.window="openModal($event.detail)" 
     x-show="isOpen" 
     class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
     x-cloak>
    
    <div class="bg-slate-900 border border-slate-800 rounded-3xl w-full max-w-md overflow-hidden shadow-2xl transition-all" @click.away="closeModal()">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <div>
                <h3 class="font-brand font-bold text-sm text-white" x-text="parentName ? `Add Link to Column: ${parentName}` : 'Add Column Block'"></h3>
                <p class="text-[9px] text-slate-500">Configure new route or directory navigation anchor</p>
            </div>
            <button @click="closeModal()" class="text-slate-500 hover:text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('admin.footer-navigation.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="parent_id" :value="parentId">
            
            <div class="space-y-1">
                <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Label (e.g. Linen Suit)</label>
                <input type="text" name="label" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all" placeholder="Enter display text">
            </div>

            <div class="space-y-2" x-data="{ 
                type: 'custom', 
                urlValue: '', 
                init() {
                    this.$watch('type', val => {
                        if (val === 'home') this.urlValue = '/';
                        else if (val === 'shop') this.urlValue = '/shop';
                        else if (val === 'about') this.urlValue = '/about';
                        else if (val === 'contact') this.urlValue = '/contact';
                    });
                }
            }">
                <div class="flex items-center justify-between">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Destination Link</label>
                    <select x-model="type" class="bg-slate-950 border border-slate-800 rounded px-2 py-0.5 text-[8px] text-slate-500">
                        <option value="custom">Custom URL</option>
                        <option value="home">Home Page</option>
                        <option value="shop">Catalog Page</option>
                        <option value="about">About Page</option>
                        <option value="contact">Contact Page</option>
                        <option value="collection">Collection</option>
                        <option value="product">Product Page</option>
                    </select>
                </div>

                <!-- Custom Link Input -->
                <div x-show="type === 'custom'">
                    <input type="text" name="url" x-model="urlValue" :required="type === 'custom'" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all" placeholder="e.g. /custom-page" value="#">
                </div>

                <!-- Hardcoded Home Link -->
                <div x-show="type === 'home'">
                    <input type="text" readonly name="url" value="/" class="w-full bg-slate-950/50 border border-slate-855 rounded-xl px-4 py-2.5 text-xs text-slate-500 cursor-not-allowed">
                </div>

                <!-- Hardcoded Shop Link -->
                <div x-show="type === 'shop'">
                    <input type="text" readonly name="url" value="/shop" class="w-full bg-slate-950/50 border border-slate-855 rounded-xl px-4 py-2.5 text-xs text-slate-500 cursor-not-allowed">
                </div>

                <!-- Hardcoded About Link -->
                <div x-show="type === 'about'">
                    <input type="text" readonly name="url" value="/about" class="w-full bg-slate-950/50 border border-slate-855 rounded-xl px-4 py-2.5 text-xs text-slate-500 cursor-not-allowed">
                </div>

                <!-- Hardcoded Contact Link -->
                <div x-show="type === 'contact'">
                    <input type="text" readonly name="url" value="/contact" class="w-full bg-slate-950/50 border border-slate-855 rounded-xl px-4 py-2.5 text-xs text-slate-500 cursor-not-allowed">
                </div>

                <!-- Collection Picker -->
                <div x-show="type === 'collection'">
                    <select @change="urlValue = '/collection/' + $event.target.value" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-violet-500">
                        <option value="">Choose collection...</option>
                        @foreach(['men', 'women', 'oversized', 'summer', 'streetwear', 'accessories'] as $cType)
                            <option value="{{ $cType }}">{{ ucfirst($cType) }} Collection</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="url" :value="urlValue">
                </div>

                <!-- Product Picker -->
                <div x-show="type === 'product'">
                    <select @change="urlValue = '/product/detail/' + $event.target.value" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-violet-500">
                        <option value="">Choose product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->slug }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="url" :value="urlValue">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-850 flex justify-end gap-3">
                <button type="button" @click="closeModal()" class="px-5 py-2.5 bg-slate-950 border border-slate-800 text-slate-400 hover:text-white rounded-xl text-xs font-bold transition-all">Cancel</button>
                <button type="submit" class="px-6 py-2.5 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-600/30 transition-all">Add Element</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Link (Alpine Managed) -->
<div x-data="editModal()" 
     @open-edit-modal.window="openModal($event.detail)" 
     x-show="isOpen" 
     class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
     x-cloak>
    
    <div class="bg-slate-900 border border-slate-800 rounded-3xl w-full max-w-md overflow-hidden shadow-2xl transition-all" @click.away="closeModal()">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <div>
                <h3 class="font-brand font-bold text-sm text-white">Edit Link</h3>
                <p class="text-[9px] text-slate-500">Configure parameters for this route anchor</p>
            </div>
            <button @click="closeModal()" class="text-slate-500 hover:text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form :action="`/admin/footer-navigation/${menuId}`" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            
            <div class="space-y-1">
                <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Label</label>
                <input type="text" name="label" x-model="label" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all">
            </div>

            <div class="space-y-2" x-data="{ 
                type: 'custom', 
                init() {
                    this.$watch('$store.editUrlValue', val => {
                        if(val === '/') this.type = 'home';
                        else if(val === '/shop') this.type = 'shop';
                        else if(val === '/about') this.type = 'about';
                        else if(val === '/contact') this.type = 'contact';
                        else if(val.includes('/collection/')) this.type = 'collection';
                        else if(val.includes('/product/detail/')) this.type = 'product';
                        else this.type = 'custom';
                    });
                    this.$watch('type', val => {
                        if(val === 'home') $store.editUrlValue = '/';
                        else if(val === 'shop') $store.editUrlValue = '/shop';
                        else if(val === 'about') $store.editUrlValue = '/about';
                        else if(val === 'contact') $store.editUrlValue = '/contact';
                    });
                }
            }">
                <div class="flex items-center justify-between">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Destination Link</label>
                    <select x-model="type" class="bg-slate-950 border border-slate-800 rounded px-2 py-0.5 text-[8px] text-slate-500">
                        <option value="custom">Custom URL</option>
                        <option value="home">Home Page</option>
                        <option value="shop">Catalog Page</option>
                        <option value="about">About Page</option>
                        <option value="contact">Contact Page</option>
                        <option value="collection">Collection</option>
                        <option value="product">Product Page</option>
                    </select>
                </div>

                <!-- Custom Link Input -->
                <div x-show="type === 'custom'">
                    <input type="text" name="url" x-model="$store.editUrlValue" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all">
                </div>

                <!-- Hardcoded Home Link -->
                <div x-show="type === 'home'">
                    <input type="text" readonly name="url" value="/" class="w-full bg-slate-950/50 border border-slate-855 rounded-xl px-4 py-2.5 text-xs text-slate-500 cursor-not-allowed">
                </div>

                <!-- Hardcoded Shop Link -->
                <div x-show="type === 'shop'">
                    <input type="text" readonly name="url" value="/shop" class="w-full bg-slate-950/50 border border-slate-855 rounded-xl px-4 py-2.5 text-xs text-slate-550 cursor-not-allowed">
                </div>

                <!-- Hardcoded About Link -->
                <div x-show="type === 'about'">
                    <input type="text" readonly name="url" value="/about" class="w-full bg-slate-950/50 border border-slate-855 rounded-xl px-4 py-2.5 text-xs text-slate-500 cursor-not-allowed">
                </div>

                <!-- Hardcoded Contact Link -->
                <div x-show="type === 'contact'">
                    <input type="text" readonly name="url" value="/contact" class="w-full bg-slate-950/50 border border-slate-855 rounded-xl px-4 py-2.5 text-xs text-slate-500 cursor-not-allowed">
                </div>

                <!-- Collection Picker -->
                <div x-show="type === 'collection'">
                    <select @change="$store.editUrlValue = '/collection/' + $event.target.value" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-violet-500">
                        <option value="">Choose collection...</option>
                        @foreach(['men', 'women', 'oversized', 'summer', 'streetwear', 'accessories'] as $cType)
                            <option value="{{ $cType }}" :selected="$store.editUrlValue.includes('/collection/{{ $cType }}')">{{ ucfirst($cType) }} Collection</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="url" :value="$store.editUrlValue">
                </div>

                <!-- Product Picker -->
                <div x-show="type === 'product'">
                    <select @change="$store.editUrlValue = '/product/detail/' + $event.target.value" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-violet-500">
                        <option value="">Choose product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->slug }}" :selected="$store.editUrlValue.includes('{{ $product->slug }}')">{{ $product->title }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="url" :value="$store.editUrlValue">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-855 flex justify-end gap-3">
                <button type="button" @click="closeModal()" class="px-5 py-2.5 bg-slate-950 border border-slate-800 text-slate-400 hover:text-white rounded-xl text-xs font-bold transition-all">Cancel</button>
                <button type="submit" class="px-6 py-2.5 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-600/30 transition-all">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('editUrlValue', '');
    });

    // Parent Navigation Sorting
    const rootEl = document.getElementById('navigation-root');
    Sortable.create(rootEl, {
        animation: 150,
        ghostClass: 'bg-slate-900/50',
        handle: '.cursor-move',
        onEnd: function() {
            triggerReorder();
        }
    });

    // Submenu Items Sorting
    document.querySelectorAll('.submenu-container').forEach(container => {
        Sortable.create(container, {
            animation: 150,
            ghostClass: 'bg-slate-950',
            handle: '.cursor-move',
            onEnd: function() {
                triggerReorder();
            }
        });
    });

    // Gather sorting tree and send ajax reorder
    function triggerReorder() {
        const orderData = [];
        
        // Loop through each top level element
        const parentElements = Array.from(rootEl.children);
        parentElements.forEach((parentEl, index) => {
            const id = parentEl.getAttribute('data-id');
            if (!id) return;
            
            const children = [];
            const submenuContainer = parentEl.querySelector('.submenu-container');
            if (submenuContainer) {
                Array.from(submenuContainer.children).forEach(childEl => {
                    const childId = childEl.getAttribute('data-id');
                    if (childId) {
                        children.push({ id: childId });
                    }
                });
            }
            
            orderData.push({
                id: id,
                children: children
            });
        });

        // Show save status overlay or button if desired, but we can do silent save
        const saveBtn = document.getElementById('save-order-btn');
        if (saveBtn) {
            saveBtn.classList.remove('hidden');
        }
    }

    function saveMenuHierarchy() {
        const orderData = [];
        const parentElements = Array.from(rootEl.children);
        
        parentElements.forEach((parentEl, index) => {
            const id = parentEl.getAttribute('data-id');
            if (!id) return;
            
            const children = [];
            const submenuContainer = parentEl.querySelector('.submenu-container');
            if (submenuContainer) {
                Array.from(submenuContainer.children).forEach(childEl => {
                    const childId = childEl.getAttribute('data-id');
                    if (childId) {
                        children.push({ id: childId });
                    }
                });
            }
            
            orderData.push({
                id: id,
                children: children
            });
        });

        const btn = document.getElementById('save-order-btn');
        btn.innerHTML = 'Saving Arrangements...';
        btn.disabled = true;

        fetch("{{ route('admin.footer-navigation.reorder') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ menu_order: orderData })
        })
        .then(res => res.json())
        .then(data => {
            btn.innerHTML = 'Saved Successfully!';
            btn.classList.add('bg-emerald-600', 'hover:bg-emerald-750');
            btn.classList.remove('bg-violet-600', 'hover:bg-violet-700');
            setTimeout(() => {
                btn.classList.add('hidden');
                btn.innerHTML = 'Apply Layout Arrangement';
                btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-750');
                btn.classList.add('bg-violet-600', 'hover:bg-violet-700');
                btn.disabled = false;
            }, 1500);
        })
        .catch(err => {
            alert('Failed to save layout arrangement.');
            btn.innerHTML = 'Apply Layout Arrangement';
            btn.disabled = false;
        });
    }

    // Alpine functions
    function navBuilder() {
        return {
            init() {}
        }
    }

    function createModal() {
        return {
            isOpen: false,
            parentId: null,
            parentName: '',
            
            openModal(data) {
                this.parentId = data.parentId;
                this.parentName = data.parentLabel || '';
                this.isOpen = true;
            },
            
            closeModal() {
                this.isOpen = false;
            }
        }
    }

    function editModal() {
        return {
            isOpen: false,
            menuId: null,
            label: '',
            
            openModal(data) {
                this.menuId = data.id;
                this.label = data.label;
                Alpine.store('editUrlValue', data.url);
                this.isOpen = true;
            },
            
            closeModal() {
                this.isOpen = false;
            }
        }
    }
</script>
@endsection
