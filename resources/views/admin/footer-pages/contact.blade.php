@extends('layouts.admin')

@section('title', 'Contact Us Page Builder')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="font-brand font-bold text-2xl text-white">Contact Us Page Content Builder</h1>
        <p class="text-xs text-slate-400">Design your brand's contact portal dynamically. Customise customer coordinates and dynamic hero image assets.</p>
    </div>
    <a href="{{ route('contact') }}" target="_blank" class="px-4 py-2 bg-slate-900 border border-slate-800 hover:border-violet-500 rounded-xl text-xs font-bold text-violet-400 transition-all flex items-center gap-2 shadow-lg">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        Live Preview Page
    </a>
</div>

<form action="{{ route('admin.footer-pages.contact.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Columns: Main Page Content Builder -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Section 1: Contact General presentation -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <h3 class="font-brand font-bold text-sm text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                        1. Header & Welcoming Section
                    </h3>
                    <p class="text-[10px] text-slate-500 font-medium">Configure welcoming message and primary banner graphics</p>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Page Heading</label>
                    <input type="text" name="contact_heading" value="{{ old('contact_heading', $settings['contact_heading'] ?? 'Connect With Our Studio') }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-violet-500 transition-all" placeholder="Enter headline text">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Welcoming Introduction</label>
                    <textarea name="contact_content" required rows="4" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-violet-500 transition-all leading-relaxed" placeholder="Write your welcoming message here...">{{ old('contact_content', $settings['contact_content'] ?? 'For general inquiries, sizing guidance, custom designs, or wholesale opportunities, get in touch with our concierge team.') }}</textarea>
                </div>

                <!-- Contact Hero Image Upload -->
                <div class="space-y-2">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Contact Banner Image</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        <div>
                            @if(!empty($settings['contact_image']))
                                <div class="relative rounded-xl overflow-hidden border border-slate-800 bg-slate-950 group h-36">
                                    <img src="{{ asset('storage/' . $settings['contact_image']) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                        <span class="text-[9px] text-slate-400 font-bold uppercase">Active Banner</span>
                                    </div>
                                </div>
                            @else
                                <div class="rounded-xl border border-dashed border-slate-800 bg-slate-950/50 flex flex-col items-center justify-center p-6 h-36 text-center text-slate-600">
                                    <svg class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[9px] uppercase tracking-wider font-bold">No active image</span>
                                </div>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <label class="w-full rounded-xl border border-slate-800 bg-slate-950 hover:bg-slate-900 hover:border-violet-500/50 p-4 flex flex-col items-center justify-center cursor-pointer transition-all h-36">
                                <svg class="w-6 h-6 text-violet-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="text-[10px] text-slate-300 font-bold uppercase tracking-wider">Choose Image</span>
                                <span class="text-[8px] text-slate-500 mt-1">PNG, JPG, WEBP max 4MB</span>
                                <input type="file" name="contact_image" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Studio Coordinates & Directory Details -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <h3 class="font-brand font-bold text-sm text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                        2. Studio Coordinates & details
                    </h3>
                    <p class="text-[10px] text-slate-500 font-medium">Configure primary contact details and physical address blocks</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Studio Support Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'studio@gurunanak.com') }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-violet-500 transition-all" placeholder="e.g. support@gurunanak.com">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Studio Contact Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+91 98765 43210') }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-violet-500 transition-all" placeholder="e.g. +91 98765 43210">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Studio Physical Address</label>
                    <textarea name="contact_address" required rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-violet-500 transition-all leading-relaxed" placeholder="Enter full visual store address...">{{ old('contact_address', $settings['contact_address'] ?? '123 Luxury Atelier Suite, Mall Road, Amritsar, Punjab, India') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Right 1 Column: SEO Settings Manager -->
        <div class="space-y-6">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <h3 class="font-brand font-bold text-sm text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        3. SEO & Crawl Optimizer
                    </h3>
                    <p class="text-[10px] text-slate-500 font-medium">Fine-tune dynamic metadata elements to rank high on search engine pages</p>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Meta Title Tag</label>
                    <input type="text" name="contact_meta_title" value="{{ old('contact_meta_title', $settings['contact_meta_title'] ?? 'Connect With Our Studio | GURUNANAK') }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Meta Description</label>
                    <textarea name="contact_meta_description" rows="4" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all leading-normal" placeholder="Enter brief meta summary...">{{ old('contact_meta_description', $settings['contact_meta_description'] ?? 'Connect directly with our luxury concierge. Locate our premium Amritsar tailoring studio, request custom sizing, or get phone and email details.') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] text-slate-400 uppercase tracking-widest font-bold block">Meta Keywords</label>
                    <input type="text" name="contact_meta_keywords" value="{{ old('contact_meta_keywords', $settings['contact_meta_keywords'] ?? 'contact, email, phone, location, amritsar, tailor, support') }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-violet-500 transition-all" placeholder="Comma separated values">
                </div>
            </div>

            <!-- Page Builder Save Controller -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
                <button type="submit" class="w-full py-3 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-600/30 hover:shadow-violet-600/40 transition-all duration-200 uppercase tracking-wider">
                    Save Page Contents
                </button>
                <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-xl">
                    <div class="flex gap-2">
                        <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-[9px] text-slate-400 leading-normal">
                            Saving flushes frontend caches. Your dynamic contact page updates instantaneously on the next storefront visit.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
