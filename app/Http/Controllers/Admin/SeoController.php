<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class SeoController extends Controller
{
    /**
     * Display a listing of page SEO configurations.
     */
    public function index()
    {
        // Programmatic Migration Trigger: Automatically run pending migrations if schema is missing
        try {
            if (!Schema::hasTable('page_seos')) {
                Artisan::call('migrate', ['--force' => true]);
            }
        } catch (\Exception $e) {
            // Failsafe silence to prevent crashing during boot anomalies
        }

        $seos = PageSeo::orderBy('id')->get();
        return view('admin.seo.index', compact('seos'));
    }

    /**
     * Show the form for editing the specified page SEO configuration.
     */
    public function edit($id)
    {
        // Programmatic Migration Trigger
        try {
            if (!Schema::hasTable('page_seos')) {
                Artisan::call('migrate', ['--force' => true]);
            }
        } catch (\Exception $e) {
            // Failsafe silence
        }

        $seo = PageSeo::findOrFail($id);
        return view('admin.seo.edit', compact('seo'));
    }

    /**
     * Update the specified page SEO configuration in storage.
     */
    public function update(Request $request, $id)
    {
        $seo = PageSeo::findOrFail($id);

        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:1000',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:1000',
            'og_image' => 'nullable|string|max:255',
        ]);

        $seo->update($validated);

        // Instantly invalidate the cached SEO entry for this page so it updates live
        Cache::forget('seo_' . $seo->page_key);

        return redirect()->route('admin.seo.index')->with('success', "SEO Settings for '{$seo->page_name}' updated and cached successfully.");
    }

    /**
     * Generate the physical XML sitemap and LLM feed.
     */
    public function generateSitemap()
    {
        // 1. Compile Sitemap XML
        $products = \App\Models\Product::latest()->get();
        $blogs = [];
        if (class_exists(\App\Models\Blog::class)) {
            $blogs = \App\Models\Blog::where('is_published', true)->latest()->get();
        }
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
        
        // Static Core Routes
        $staticRoutes = ['/', '/shop', '/about', '/contact', '/blogs'];
        foreach ($staticRoutes as $route) {
            $xml .= '<url><loc>' . url($route) . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
        }
        
        // Products
        foreach ($products as $product) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('product.detail', $product->slug) . '</loc>';
            $xml .= '<lastmod>' . $product->updated_at->tz('UTC')->toAtomString() . '</lastmod>';
            if (!empty($product->image_path)) {
                $imageUrl = str_starts_with($product->image_path, 'http') ? htmlspecialchars($product->image_path) : url(htmlspecialchars($product->image_path));
                $xml .= '<image:image>';
                $xml .= '<image:loc>' . $imageUrl . '</image:loc>';
                $xml .= '<image:title>' . htmlspecialchars($product->title ?? $product->name ?? 'Product') . '</image:title>';
                $xml .= '</image:image>';
            }
            $xml .= '<changefreq>weekly</changefreq><priority>0.8</priority></url>';
        }

        // Blogs
        foreach ($blogs as $blog) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('blogs.show', $blog->slug) . '</loc>';
            $xml .= '<lastmod>' . $blog->updated_at->tz('UTC')->toAtomString() . '</lastmod>';
            if (!empty($blog->featured_image)) {
                $imageUrl = str_starts_with($blog->featured_image, 'http') ? htmlspecialchars($blog->featured_image) : url(htmlspecialchars($blog->featured_image));
                $xml .= '<image:image><image:loc>' . $imageUrl . '</image:loc><image:title>' . htmlspecialchars($blog->title) . '</image:title></image:image>';
            }
            $xml .= '<changefreq>monthly</changefreq><priority>0.6</priority></url>';
        }
        
        $xml .= '</urlset>';
        file_put_contents(public_path('sitemap.xml'), $xml);

        // 2. Compile LLM Discovery Document (AEO/GEO)
        $text = "# Gurunanak Cloth House - AEO / GEO AI Knowledge Base\n";
        $text .= "This document provides a highly detailed clean text representation of our entire storefront architecture, inventory, and policies for AI web crawlers (ChatGPT, Claude, Google Gemini).\n\n";
        
        $text .= "## Core Store Information\n";
        $text .= "- Store Name: Gurunanak Cloth House\n";
        $text .= "- Website: " . url('/') . "\n";
        $text .= "- Niche: Premium Luxury Clothing & Apparel\n";
        $text .= "- Description: A premium fashion brand creating clean, simple, and elegant clothing designed for everyday comfort and ultimate modern beauty.\n\n";

        $text .= "## Product Catalog\n\n";
        foreach ($products as $product) {
            $text .= "### " . ($product->title ?? $product->name ?? 'Product') . "\n";
            $text .= "- URL: " . route('product.detail', $product->slug) . "\n";
            $text .= "- Price: $" . $product->price . "\n";
            $text .= "- Subtitle/Category: " . ($product->subtitle ?? 'General') . "\n";
            $text .= "- Description: " . strip_tags($product->description ?? '') . "\n\n";
        }

        if (count($blogs) > 0) {
            $text .= "## Published Editorial Journals\n\n";
            foreach ($blogs as $blog) {
                $text .= "### " . $blog->title . "\n";
                $text .= "- URL: " . route('blogs.show', $blog->slug) . "\n";
                $text .= "- Excerpt: " . strip_tags($blog->excerpt ?? '') . "\n\n";
            }
        }
        
        file_put_contents(public_path('llm.txt'), $text);

        return back()->with('success', 'Comprehensive Physical XML Sitemap and LLM Discovery Feeds generated successfully!');
    }
}
