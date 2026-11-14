@extends('layouts.admin')

@section('title', 'Home Page Designer')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="font-brand font-bold text-2xl text-white">Home Page Designer</h1>
        <p class="text-xs text-slate-400">Manage your store's landing page sections and navigation menu with Shopify-like control.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.homepage.sections.create') }}" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-600/30 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add New Section
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left: Section Management (2/3) -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="font-brand font-bold text-sm text-white">Layout Sections</h3>
                    <p class="text-[10px] text-slate-500 font-medium">Drag to reorder sections on the home page</p>
                </div>
                <span class="text-[8px] font-bold text-violet-400 bg-violet-400/10 px-2 py-0.5 rounded border border-violet-600/20 uppercase tracking-widest">Live Sync</span>
            </div>
            
            <div id="sortable-sections" class="p-4 space-y-3">
                @foreach($sections as $section)
                <div data-id="{{ $section->id }}" class="group bg-slate-950 border border-slate-800 rounded-xl p-4 flex items-center gap-4 cursor-move hover:border-violet-500/50 transition-all">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-500 group-hover:text-violet-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h4 class="text-xs font-bold text-slate-200 capitalize">{{ $section->title ?: str_replace('_', ' ', $section->section_type) }}</h4>
                            @if(!$section->is_active)
                                <span class="text-[8px] bg-slate-800 text-slate-500 px-1.5 py-0.5 rounded border border-slate-700">Hidden</span>
                            @endif
                        </div>
                        <p class="text-[10px] text-slate-500 mt-0.5">{{ strtoupper($section->section_type) }} • ID: #SEC-0{{ $section->id }}</p>
                    </div>

                    <div class="flex items-center gap-1">
                        <form action="{{ route('admin.homepage.sections.status', $section) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="is_active" value="{{ $section->is_active ? 0 : 1 }}">
                            <button type="submit" class="p-2 {{ $section->is_active ? 'text-emerald-500' : 'text-slate-500' }} hover:bg-slate-900 rounded-lg transition-all" title="{{ $section->is_active ? 'Hide Section' : 'Show Section' }}">
                                @if($section->is_active)
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                @endif
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.homepage.sections.edit', $section) }}" class="p-2 text-violet-400 hover:bg-violet-600/10 rounded-lg transition-all" title="Edit Content">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>

                        <form action="{{ route('admin.homepage.sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this section?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-500 hover:text-red-500 hover:bg-red-500/10 rounded-lg transition-all" title="Delete Section">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right: Menu Management (1/3) -->
    <div class="space-y-6" x-data="menuManager()">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="font-brand font-bold text-sm text-white">Main Navigation</h3>
                    <p class="text-[10px] text-slate-500 font-medium">Header menu with sub-links</p>
                </div>
                <button type="button" @click="addMenuItem()" class="text-violet-400 hover:text-violet-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </button>
            </div>
            
            <form action="{{ route('admin.homepage.menu.update') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-800">
                    <template x-for="(menu, index) in menus" :key="index">
                        <div class="space-y-4 p-4 bg-slate-950 border border-slate-800 rounded-2xl relative group">
                            <!-- Parent Item -->
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-bold text-violet-500 uppercase tracking-widest">Main Menu #<span x-text="index + 1"></span></span>
                                    <button type="button" @click="removeMenu(index)" class="p-1 text-slate-600 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                                <div class="space-y-2">
                                    <input type="hidden" :name="`menus[${index}][id]`" :value="menu.id">
                                    <input type="text" :name="`menus[${index}][label]`" x-model="menu.label" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-[10px] text-white focus:border-violet-500 transition-all" placeholder="Menu Label (e.g. Women)">
                                    
                                    <div class="flex gap-2" x-data="{ type: getLinkType(menu.url) }">
                                        <select x-model="type" class="bg-slate-900 border border-slate-800 rounded-lg px-2 py-1 text-[8px] text-slate-500">
                                            <option value="custom">URL</option>
                                            <option value="collection">Coll.</option>
                                            <option value="product">Prod.</option>
                                        </select>
                                        <div class="flex-1">
                                            <input x-show="type === 'custom'" type="text" :name="`menus[${index}][url]`" x-model="menu.url" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1 text-[9px] text-slate-200" placeholder="URL">
                                            <select x-show="type === 'collection'" @change="menu.url = '/collection/' + $event.target.value" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1 text-[9px] text-slate-200">
                                                <option value="">Select Collection</option>
                                                @foreach(['men', 'women', 'oversized', 'summer', 'streetwear', 'accessories'] as $cType)
                                                    <option value="{{ $cType }}" :selected="menu.url.includes('/collection/{{ $cType }}')">{{ ucfirst($cType) }}</option>
                                                @endforeach
                                            </select>
                                            <select x-show="type === 'product'" @change="menu.url = '/product/detail/' + $event.target.value" class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-1 text-[9px] text-slate-200">
                                                <option value="">Select Product</option>
                                                <template x-for="p in products">
                                                    <option :value="p.slug" x-text="p.title" :selected="menu.url.includes(p.slug)"></option>
                                                </template>
                                            </select>
                                            <input type="hidden" :name="`menus[${index}][url]`" :value="menu.url">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Child Items -->
                            <div class="space-y-3 pl-4 border-l border-slate-800">
                                <template x-for="(child, cIndex) in menu.children" :key="cIndex">
                                    <div class="p-3 bg-slate-900/50 border border-slate-800 rounded-xl space-y-2 relative group/child">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[8px] font-bold text-slate-600 uppercase">Sub-link</span>
                                            <button type="button" @click="removeChild(index, cIndex)" class="text-slate-700 hover:text-red-500 transition-colors">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                        <input type="hidden" :name="`menus[${index}][children][${cIndex}][id]`" :value="child.id">
                                        <input type="text" :name="`menus[${index}][children][${cIndex}][label]`" x-model="child.label" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1.5 text-[9px] text-white" placeholder="Sub-label">
                                        
                                        <div class="flex gap-2" x-data="{ cType: getLinkType(child.url) }">
                                            <select x-model="cType" class="bg-slate-950 border border-slate-800 rounded-lg px-2 py-0.5 text-[8px] text-slate-600">
                                                <option value="custom">URL</option>
                                                <option value="collection">Coll.</option>
                                                <option value="product">Prod.</option>
                                            </select>
                                            <div class="flex-1">
                                                <input x-show="cType === 'custom'" type="text" :name="`menus[${index}][children][${cIndex}][url]`" x-model="child.url" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1 text-[8px] text-slate-300" placeholder="URL">
                                                <select x-show="cType === 'collection'" @change="child.url = '/collection/' + $event.target.value" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1 text-[8px] text-slate-300">
                                                    <option value="">Select</option>
                                                    @foreach(['men', 'women', 'oversized', 'summer', 'streetwear', 'accessories'] as $cType)
                                                        <option value="{{ $cType }}" :selected="child.url.includes('/collection/{{ $cType }}')">{{ ucfirst($cType) }}</option>
                                                    @endforeach
                                                </select>
                                                <select x-show="cType === 'product'" @change="child.url = '/product/detail/' + $event.target.value" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1 text-[8px] text-slate-300">
                                                    <option value="">Select</option>
                                                    <template x-for="p in products">
                                                        <option :value="p.slug" x-text="p.title" :selected="child.url.includes(p.slug)"></option>
                                                    </template>
                                                </select>
                                                <input type="hidden" :name="`menus[${index}][children][${cIndex}][url]`" :value="child.url">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" @click="addChild(index)" class="w-full py-2 border border-dashed border-slate-800 hover:border-violet-500 rounded-xl text-[9px] font-bold text-slate-600 hover:text-violet-500 transition-all uppercase">
                                    + Add Sub-link
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
                
                <button type="submit" class="w-full py-2.5 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-600/30 transition-all mt-6">
                    Save Navigation Changes
                </button>
            </form>
        </div>
        
        <div class="bg-violet-600/10 border border-violet-600/20 rounded-2xl p-6">
            <h4 class="text-xs font-bold text-violet-400 mb-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Pro Tip
            </h4>
            <p class="text-[10px] text-slate-400 leading-relaxed">
                To create a submenu, add a parent item (e.g. "Women") and then click the <span class="text-violet-400">+</span> icon next to it to add its children.
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Section Sorting Logic
    const el = document.getElementById('sortable-sections');
    Sortable.create(el, {
        animation: 150,
        ghostClass: 'opacity-50',
        onEnd: function() {
            const order = Array.from(el.children).map(child => child.getAttribute('data-id'));
            fetch("{{ route('admin.homepage.sections.reorder') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ order: order })
            });
        }
    });

    <!-- Alpine JS Menu Manager -->
    <script>
    function menuManager() {
        return {
            menus: @json($menus),
            categories: @json($categories),
            products: @json($products),
            
            getLinkType(url) {
                if(!url) return 'custom';
                if(url.includes('/collection/')) return 'collection';
                if(url.includes('/product/detail/')) return 'product';
                return 'custom';
            },

            addMenuItem() {
                this.menus.push({ id: null, label: '', url: '', children: [] });
            },
            
            removeMenu(index) {
                if(confirm('Remove this menu and all sub-menus?')) {
                    this.menus.splice(index, 1);
                }
            },
            
            addChild(index) {
                if(!this.menus[index].children) this.menus[index].children = [];
                this.menus[index].children.push({ id: null, label: '', url: '' });
            },
            
            removeChild(mIndex, cIndex) {
                this.menus[mIndex].children.splice(cIndex, 1);
            }
        }
    }
    </script>
@endsection
