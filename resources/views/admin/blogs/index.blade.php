@extends('layouts.admin')

@section('title', 'Journal Articles')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Blogs Studio</span>
            <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Journal Articles</h1>
            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                Create, edit, and organize editorial articles for your Bespoke Journal storefront showcase.
            </p>
        </div>
        <div class="shrink-0">
            <a href="{{ route('admin.blogs.create') }}" class="px-5 py-2.5 rounded-lg bg-violet-600 hover:bg-violet-500 text-white font-semibold text-xs transition-all shadow-lg shadow-violet-600/20 inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v8m0 0v8m0-8h8m-8 0H4"/></svg>
                Publish New Article
            </a>
        </div>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-xl">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
            <h3 class="font-brand font-semibold text-white text-sm">Published Journal Posts</h3>
            <span class="px-2 py-0.5 rounded text-[9px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">Blogs list</span>
        </div>

        @if($posts->isEmpty())
            <div class="py-16 text-center space-y-4">
                <svg class="w-12 h-12 text-slate-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v7a2 2 0 01-2 2H9a2 2 0 01-2-2v-1"/></svg>
                <div class="space-y-1">
                    <p class="text-xs uppercase text-slate-500 tracking-wider font-bold">No Articles Found</p>
                    <p class="text-[10px] text-slate-600">Start writing standard editorial posts to tell your brand story and boost your search engine ranking.</p>
                </div>
                <a href="{{ route('admin.blogs.create') }}" class="px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-[10px] transition-colors inline-block">
                    Write First Post
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="pb-3 pl-2">Article</th>
                            <th class="pb-3">Category</th>
                            <th class="pb-3">Visibility</th>
                            <th class="pb-3">Published Date</th>
                            <th class="pb-3 pr-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @foreach($posts as $post)
                            <tr class="text-slate-300 hover:bg-slate-800/10">
                                <td class="py-4 pl-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-9 rounded bg-slate-950 border border-slate-800 overflow-hidden shrink-0 flex items-center justify-center">
                                            @if($post->desktop_image)
                                                <img src="{{ asset('storage/' . $post->desktop_image) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-[9px] text-slate-600">No Image</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-semibold text-white truncate max-w-xs md:max-w-md">{{ $post->title }}</h4>
                                            <p class="text-[9px] text-slate-500 font-mono mt-0.5 truncate">{{ $post->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    @if($post->category)
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-violet-600/10 text-violet-400 font-semibold border border-violet-600/20">
                                            {{ $post->category->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-600 italic">Uncategorized</span>
                                    @endif
                                </td>
                                <td class="py-4">
                                    @if($post->is_visible)
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-500/10 text-emerald-400 font-semibold border border-emerald-500/20">
                                            Public
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-amber-500/10 text-amber-400 font-semibold border border-amber-500/20">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 text-slate-400 font-medium">
                                    {{ $post->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-4 pr-2 text-right space-x-2">
                                    <a href="{{ route('admin.blogs.edit', $post->id) }}" class="px-2.5 py-1 text-[10px] bg-slate-800 hover:bg-slate-700 text-slate-300 rounded font-semibold transition-colors inline-block">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this blog post? This action is permanent.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 text-[10px] bg-rose-600/10 hover:bg-rose-600/20 text-rose-400 border border-rose-600/20 rounded font-semibold transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                    @if($post->is_visible)
                                        <a href="{{ route('blogs.show', $post->slug) }}" target="_blank" class="px-2.5 py-1 text-[10px] bg-violet-600/10 hover:bg-violet-600/20 text-violet-400 border border-violet-600/20 rounded font-semibold transition-colors inline-block">
                                            Preview
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 pt-4 border-t border-slate-800">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
