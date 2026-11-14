@extends('layouts.admin')

@section('title', 'Add New Section')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.homepage.index') }}" class="text-xs text-violet-400 hover:text-violet-300 flex items-center gap-1 mb-2 transition-all">
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Designer
    </a>
    <h1 class="font-brand font-bold text-2xl text-white">Add New Section</h1>
    <p class="text-xs text-slate-400">Choose a section type to add to your home page.</p>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.homepage.sections.store') }}" method="POST" class="bg-slate-900 border border-slate-800 rounded-2xl shadow-xl overflow-hidden p-8 space-y-6">
        @csrf
        
        <div class="space-y-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Section Type</label>
            <select name="section_type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 focus:outline-none focus:border-violet-500 transition-all">
                @foreach($types as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Internal Title</label>
            <input type="text" name="title" required placeholder="e.g., Summer Collection Hero" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-slate-200 focus:outline-none focus:border-violet-500 transition-all">
            <p class="text-[10px] text-slate-500 font-medium">This title is for your reference in the admin panel only.</p>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-3.5 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-violet-600/30 transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Section
            </button>
        </div>
    </form>
</div>
@endsection
