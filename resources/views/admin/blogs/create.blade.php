@extends('layouts.admin')

@section('title', 'Write Journal Post')

@section('head')
<!-- Jodit Rich Text Editor CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jodit/3.24.2/jodit.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/3.24.2/jodit.min.js"></script>
<style>
    /* Dark Theme customizations for Jodit to blend perfectly with hPanel slate-900 template */
    .jodit-container {
        background-color: #090d16 !important;
        border: 1px solid #1e293b !important;
        border-radius: 0.75rem !important;
        color: #e2e8f0 !important;
    }
    .jodit-toolbar__box {
        background-color: #0f172a !important;
        border-bottom: 1px solid #1e293b !important;
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    .jodit-toolbar-button__trigger {
        color: #94a3b8 !important;
    }
    .jodit-toolbar-button {
        color: #e2e8f0 !important;
    }
    .jodit-toolbar-button:hover {
        background-color: #1e293b !important;
    }
    .jodit-wysiwyg {
        background-color: #090d16 !important;
        color: #e2e8f0 !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 13px !important;
    }
    .jodit-status-bar {
        background-color: #0f172a !important;
        border-top: 1px solid #1e293b !important;
        border-radius: 0 0 0.75rem 0.75rem !important;
        color: #64748b !important;
        font-size: 10px !important;
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3 pb-4 border-b border-slate-800">
        <a href="{{ route('admin.blogs.index') }}" class="p-2 rounded-lg bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-400 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <span class="text-[10px] uppercase tracking-wider text-violet-400 font-bold block mb-1">Journal Studio</span>
            <h1 class="font-brand text-2xl font-bold text-white tracking-tight">Write Journal Post</h1>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-xs text-rose-400 font-medium space-y-1">
            <p class="font-bold">Please correct the following validation errors:</p>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- LEFT COLUMN: Post Title, Short Summary, Content, SEO -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-5">
                    
                    <!-- Post Title -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Post Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Enter catchy title..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-none focus:border-violet-500 transition-colors">
                    </div>

                    <!-- Short Summary -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Short Summary</label>
                        <textarea name="short_summary" rows="3" placeholder="Brief excerpt for search results..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-none focus:border-violet-500 transition-colors leading-relaxed">{{ old('short_summary') }}</textarea>
                        <p class="text-[9px] text-slate-500 mt-1">Recommended: 150-160 characters. This acts as the meta description for the article in search engines.</p>
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Content</label>
                        <textarea id="content_editor" name="content">{{ old('content') }}</textarea>
                    </div>

                </div>

                <!-- SEO Meta settings collapsible panel -->
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
                    <button type="button" onclick="toggleSeoAccordion()" class="flex items-center justify-between w-full text-left">
                        <div>
                            <h3 class="font-brand font-semibold text-white text-sm">SEO Meta Customization</h3>
                            <p class="text-[10px] text-slate-500 mt-0.5">Customize meta elements for search engine positioning.</p>
                        </div>
                        <svg id="seo-chevron" class="w-4 h-4 text-slate-400 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="seo-accordion-content" class="hidden pt-4 border-t border-slate-800/80 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Meta Title Tag</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Title seen in Google tab..." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Meta Description</label>
                            <textarea name="meta_description" rows="2" placeholder="Exquisite snippet summarizing this article..." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">{{ old('meta_description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Meta Keywords (Comma separated)</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="bespoke clothing, handloom heritage, style diary" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-violet-500">
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Category, Desktop Image, Mobile Image, Visibility, Submit -->
            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-5">
                    
                    <!-- Category selection dropdown -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Category</label>
                        <select name="category_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-300 focus:outline-none focus:border-violet-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Desktop Image Upload Box -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-semibold text-slate-300">Desktop Image</label>
                            <span class="text-[9px] uppercase tracking-wider text-violet-400 font-bold">RECOMMENDED: 1200 x 630px</span>
                        </div>
                        <input type="file" name="desktop_image" id="desktop_input" accept="image/*" class="hidden" onchange="previewDesktopImage(this)">
                        
                        <div onclick="document.getElementById('desktop_input').click()" class="relative border-2 border-dashed border-slate-800 hover:border-violet-500/50 bg-slate-950/60 rounded-xl p-5 flex flex-col items-center justify-center cursor-pointer min-h-[140px] text-center transition-all group overflow-hidden">
                            <div id="desktop_placeholder" class="space-y-2">
                                <svg class="w-6 h-6 text-slate-500 mx-auto transition-transform duration-300 group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[10px] text-slate-500 font-bold block uppercase tracking-wider">CLICK TO UPLOAD</span>
                                <span class="text-[8px] text-slate-600 block mt-1">Aspect Ratio: 1.91:1 (Landscape)</span>
                            </div>
                            <img id="desktop_img_preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        </div>
                        <p class="text-[9px] text-slate-500 mt-1 leading-relaxed">This image is rendered on wide desktop grids and article header backgrounds. Using the suggested size keeps text overlays perfectly visible.</p>
                    </div>

                    <!-- Mobile Image Upload Box -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-semibold text-slate-300">Mobile Image</label>
                            <span class="text-[9px] uppercase tracking-wider text-violet-400 font-bold">RECOMMENDED: 600 x 600px (SQUARE)</span>
                        </div>
                        <input type="file" name="mobile_image" id="mobile_input" accept="image/*" class="hidden" onchange="previewMobileImage(this)">
                        
                        <div onclick="document.getElementById('mobile_input').click()" class="relative border-2 border-dashed border-slate-800 hover:border-violet-500/50 bg-slate-950/60 rounded-xl p-5 flex flex-col items-center justify-center cursor-pointer min-h-[140px] text-center transition-all group overflow-hidden">
                            <div id="mobile_placeholder" class="space-y-2">
                                <svg class="w-6 h-6 text-slate-500 mx-auto transition-transform duration-300 group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[10px] text-slate-500 font-bold block uppercase tracking-wider">CLICK TO UPLOAD</span>
                                <span class="text-[8px] text-slate-600 block mt-1">Aspect Ratio: 1:1 (Square)</span>
                            </div>
                            <img id="mobile_img_preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        </div>
                        <p class="text-[9px] text-slate-500 mt-1 leading-relaxed">This image is rendered on phone screens and square card listings. This prevents cropping and guarantees that no central part of the visual gets cut off on mobile.</p>
                    </div>

                    <!-- Visibility Toggle Switch -->
                    <div class="flex items-center justify-between pt-3 border-t border-slate-800/80">
                        <div>
                            <label class="block text-xs font-semibold text-slate-200">Visibility</label>
                            <span class="text-[9px] text-slate-500 block mt-0.5">Make this post public</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="is_visible" value="1" checked class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-violet-600 peer-checked:after:bg-white peer-checked:after:border-violet-600"></div>
                        </label>
                    </div>

                    <!-- Publish Button (Bold solid black) -->
                    <button type="submit" class="w-full py-3 mt-2 rounded-xl bg-white hover:bg-slate-200 text-slate-950 font-bold text-xs uppercase tracking-widest transition-colors shadow-xl">
                        Publish Article
                    </button>

                </div>

            </div>

        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Initialize Jodit Rich Text Editor
    const editor = new Jodit('#content_editor', {
        theme: 'dark',
        height: 400,
        placeholder: 'Start writing your story...',
        buttons: [
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'eraser', '|',
            'ul', 'ol', '|',
            'font', 'fontsize', 'paragraph', '|',
            'image', 'table', 'link', '|',
            'align', 'undo', 'redo', '|',
            'fullsize', 'dots'
        ]
    });

    // Toggle SEO expansion accordion panel
    function toggleSeoAccordion() {
        const content = document.getElementById('seo-accordion-content');
        const chevron = document.getElementById('seo-chevron');
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    }

    // Dynamic Image Live Previews
    function previewDesktopImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('desktop_placeholder').classList.add('hidden');
                const img = document.getElementById('desktop_img_preview');
                img.src = e.target.result;
                img.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewMobileImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('mobile_placeholder').classList.add('hidden');
                const img = document.getElementById('mobile_img_preview');
                img.src = e.target.result;
                img.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
