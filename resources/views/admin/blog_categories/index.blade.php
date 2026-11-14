@extends('layouts.admin')

@section('title', 'Blog Categories')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Blogs Studio</span>
            <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Blog Categories</h1>
            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                Organize your Bespoke Journal articles. Add or manage taxonomy categories to segment your luxury storefront content.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: List of categories -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl">
                <h3 class="font-brand font-semibold text-white text-sm mb-4">Active Categories</h3>
                
                @if($categories->isEmpty())
                    <div class="py-12 text-center space-y-3">
                        <svg class="w-8 h-8 text-slate-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <p class="text-xs uppercase text-slate-500 tracking-wider">No Categories Found</p>
                        <p class="text-[10px] text-slate-600">Add a category on the right to start segmenting your articles.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="border-b border-slate-800 text-slate-400 font-bold uppercase tracking-wider">
                                    <th class="pb-3 pl-2">Name</th>
                                    <th class="pb-3">Slug</th>
                                    <th class="pb-3 text-center">Article Count</th>
                                    <th class="pb-3 pr-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60">
                                @foreach($categories as $category)
                                    <tr class="text-slate-300 hover:bg-slate-800/10">
                                        <td class="py-4 pl-2 font-semibold text-white">{{ $category->name }}</td>
                                        <td class="py-4 font-mono text-[10px] text-violet-400">{{ $category->slug }}</td>
                                        <td class="py-4 text-center font-brand font-bold">{{ $category->posts_count }}</td>
                                        <td class="py-4 pr-2 text-right space-x-2">
                                            <button onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description) }}')" class="px-2.5 py-1 text-[10px] bg-slate-800 hover:bg-slate-700 text-slate-300 rounded font-semibold transition-colors">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.blog-categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category? Linked posts will lose their category association.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1 text-[10px] bg-rose-600/10 hover:bg-rose-600/20 text-rose-400 border border-rose-600/20 rounded font-semibold transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Create Category Form -->
        <div class="lg:col-span-1">
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl space-y-4">
                <div class="border-b border-slate-800 pb-2">
                    <h3 class="font-brand font-semibold text-white text-sm">Create Category</h3>
                </div>

                <form action="{{ route('admin.blog-categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Category Name</label>
                        <input type="text" name="name" required placeholder="e.g. Fabric Heritage" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        @error('name')
                            <span class="text-[10px] text-rose-500 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1">Description (Optional)</label>
                        <textarea name="description" rows="3" placeholder="Brief outline for admin reference..." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500"></textarea>
                        @error('description')
                            <span class="text-[10px] text-rose-500 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-2 rounded-lg bg-violet-600 hover:bg-violet-500 text-white font-semibold text-xs transition-colors shadow-lg shadow-violet-600/20">
                        Create Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="bg-slate-900 border border-slate-800 rounded-xl w-full max-w-md p-6 shadow-2xl z-10 relative space-y-4">
        <div class="flex items-center justify-between border-b border-slate-800 pb-2">
            <h3 class="font-brand font-semibold text-white text-sm">Edit Blog Category</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-white text-sm">✕</button>
        </div>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Category Name</label>
                <input type="text" name="name" id="edit_name" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Description (Optional)</label>
                <textarea name="description" id="edit_description" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-lg">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 bg-violet-600 hover:bg-violet-500 text-white text-xs font-semibold rounded-lg shadow-lg shadow-violet-600/20">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, description) {
        const form = document.getElementById('editForm');
        form.action = `/admin/blog-categories/${id}`;
        
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        
        const modal = document.getElementById('editModal');
        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
    }
</script>
@endsection
