@extends('layouts.admin')

@section('title', 'Sales Channels Management')

@section('content')
<div x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    editId: '', 
    editName: '', 
    editUrl: '', 
    editIconUrl: '',
    openEdit(id, name, url, iconUrl) {
        this.editId = id;
        this.editName = name;
        this.editUrl = url;
        this.editIconUrl = iconUrl;
        this.showEditModal = true;
    }
}" class="space-y-6">

    <!-- Header Block -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800 pb-5">
        <div>
            <h2 class="font-brand font-bold text-xl sm:text-2xl text-white">Sales Channels</h2>
            <p class="text-xs text-slate-400 mt-1">Manage external marketplaces and third-party stores (like Flipkart, Amazon, Myntra, etc.) where your custom products are sold.</p>
        </div>
        <button @click="showAddModal = true" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold flex items-center gap-2 shadow-lg shadow-emerald-900/30 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Channel
        </button>
    </div>

    <!-- Error Validation Display -->
    @if ($errors->any())
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-xs space-y-1">
            <p class="font-bold">Please correct the following errors:</p>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Grid Array -->
    @if($channels->isEmpty())
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-16 text-center space-y-4 shadow-xl">
            <div class="w-16 h-16 rounded-full bg-slate-850 border border-slate-700/60 flex items-center justify-center mx-auto text-slate-500 shadow-inner">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
            <div class="space-y-1 max-w-sm mx-auto">
                <h3 class="font-brand font-bold text-sm text-white">No Sales Channels Configured</h3>
                <p class="text-xs text-slate-400">External marketplace channels will automatically be highlighted under your public storefront footers once added here.</p>
            </div>
            <button @click="showAddModal = true" class="inline-flex px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-xs font-semibold items-center gap-1.5 transition-all shadow-md">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Your First Channel
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($channels as $channel)
                <div class="bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-2xl p-5 flex flex-col justify-between shadow-xl transition-all duration-300 relative group">
                    
                    <div class="space-y-4">
                        <!-- Icon Preview Container in rounded white card -->
                        <div class="w-20 h-20 rounded-2xl bg-white border border-slate-700/40 flex items-center justify-center overflow-hidden shrink-0 mx-auto shadow-md p-3 group-hover:scale-105 transition-transform duration-300">
                            @if($channel->icon)
                                <img src="{{ asset('storage/' . $channel->icon) }}" alt="{{ $channel->name }} logo" class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Brand Title / Name -->
                        <div class="text-center">
                            <h4 class="font-brand font-bold text-base text-white tracking-tight uppercase leading-tight">{{ $channel->name }}</h4>
                            <a href="{{ $channel->url }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-violet-400 hover:text-violet-300 hover:underline transition-colors mt-2 uppercase tracking-widest">
                                Store Link
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Actions Layer (Pen and Trash with absolute tooltips) -->
                    <div class="flex items-center justify-center gap-3 border-t border-slate-800/80 pt-4 mt-5">
                        
                        <!-- Edit Pen Button -->
                        <button @click="openEdit('{{ $channel->id }}', '{{ addslashes($channel->name) }}', '{{ addslashes($channel->url) }}', '{{ $channel->icon ? asset('storage/' . $channel->icon) : '' }}')" class="p-2.5 bg-blue-600/10 text-blue-400 border border-blue-600/20 rounded-xl hover:bg-blue-600/25 hover:text-white transition-all duration-200" title="Edit platform details">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        
                        <!-- Delete Button with dynamic form submit -->
                        <form action="{{ route('admin.sales-channels.destroy', $channel->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sales channel? The storefront icon link will be completely removed.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5 bg-rose-600/10 text-rose-400 border border-rose-600/20 rounded-xl hover:bg-rose-600/25 hover:text-white transition-all duration-200 relative group/del" title="Delete Channel">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                
                                <!-- Floating Tooltip -->
                                <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2.5 py-1 text-[9px] bg-slate-950 border border-slate-800 rounded text-slate-350 opacity-0 group-hover/del:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-20">
                                    Delete Channel
                                </span>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

    <!-- ADD CHANNEL MODAL -->
    <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-cloak>
        <div @click.away="showAddModal = false" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl animate-scaleIn">
            <div class="px-5 py-4 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-brand font-bold text-white text-sm uppercase tracking-wider">New Channel</h3>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-white font-bold text-xs uppercase tracking-wide">✕ Close</button>
            </div>
            
            <form action="{{ route('admin.sales-channels.store') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">PLATFORM NAME</label>
                    <input type="text" name="name" required placeholder="e.g. Amazon, Flipkart, Myntra" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500 uppercase tracking-widest font-brand font-semibold">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">FULL URL</label>
                    <input type="url" name="url" required placeholder="https://www.amazon.in/store/..." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-250 focus:outline-none focus:border-violet-500 font-mono">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">ICON IMAGE</label>
                    <div class="flex items-center gap-3 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-12 h-12 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0 text-slate-650">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="icon" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Recommended: Transparent square image (PNG/WebP/SVG)</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-slate-800">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 text-xs font-bold text-slate-450 hover:text-white transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-md transition-colors">Add Channel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT CHANNEL MODAL -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm" x-cloak>
        <div @click.away="showEditModal = false" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl animate-scaleIn">
            <div class="px-5 py-4 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-brand font-bold text-white text-sm uppercase tracking-wider">Edit Channel</h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-white font-bold text-xs uppercase tracking-wide">✕ Close</button>
            </div>
            
            <form :action="'{{ route('admin.sales-channels.index') }}/' + editId" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">PLATFORM NAME</label>
                    <input type="text" name="name" required x-model="editName" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500 uppercase tracking-widest font-brand font-semibold">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">FULL URL</label>
                    <input type="url" name="url" required x-model="editUrl" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-250 focus:outline-none focus:border-violet-500 font-mono">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">ICON IMAGE</label>
                    <div class="flex items-center gap-3 bg-slate-950/50 p-3 rounded-xl border border-slate-800/80">
                        <div class="w-12 h-12 rounded-lg bg-slate-900 border border-slate-700/60 flex items-center justify-center overflow-hidden shrink-0 bg-white">
                            <template x-if="editIconUrl">
                                <img :src="editIconUrl" class="w-full h-full object-contain p-1">
                            </template>
                            <template x-if="!editIconUrl">
                                <svg class="w-6 h-6 text-slate-650" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </template>
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" name="icon" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-violet-600/10 file:text-violet-400 hover:file:bg-violet-600/20 cursor-pointer">
                            <span class="text-[9px] text-slate-600 block mt-1">Recommended: Transparent square image (PNG/WebP/SVG)</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-slate-800">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-xs font-bold text-slate-450 hover:text-white transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-xs font-bold shadow-md transition-colors">Update Channel</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('head')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    [x-cloak] { display: none !important; }
    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .animate-scaleIn {
        animation: scaleIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection
