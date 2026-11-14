<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the blog posts.
     */
    public function index()
    {
        $posts = BlogPost::with('category')->latest()->paginate(10);
        return view('admin.blogs.index', compact('posts'));
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog post in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:blog_categories,id',
            'short_summary' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'desktop_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $postData = $request->only([
            'title', 'category_id', 'short_summary', 'content', 
            'meta_title', 'meta_description', 'meta_keywords'
        ]);

        // Auto-generate unique slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $postData['slug'] = $slug;
        
        $postData['is_visible'] = $request->has('is_visible');

        // Handle Image Uploads
        if ($request->hasFile('desktop_image')) {
            $path = $request->file('desktop_image')->store('blogs', 'public');
            $postData['desktop_image'] = $path;
        }

        if ($request->hasFile('mobile_image')) {
            $path = $request->file('mobile_image')->store('blogs', 'public');
            $postData['mobile_image'] = $path;
        }

        BlogPost::create($postData);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post published successfully!');
    }

    /**
     * Show the form for editing the specified blog post.
     */
    public function edit($id)
    {
        $blog = BlogPost::findOrFail($id);
        $categories = BlogCategory::orderBy('name')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog post in database.
     */
    public function update(Request $request, $id)
    {
        $blog = BlogPost::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:blog_categories,id',
            'short_summary' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'desktop_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $postData = $request->only([
            'title', 'category_id', 'short_summary', 'content', 
            'meta_title', 'meta_description', 'meta_keywords'
        ]);

        // Re-generate slug if title changed
        if ($blog->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (BlogPost::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $postData['slug'] = $slug;
        }

        $postData['is_visible'] = $request->has('is_visible');

        // Handle Image Updates
        if ($request->hasFile('desktop_image')) {
            // Delete old file
            if ($blog->desktop_image && Storage::disk('public')->exists($blog->desktop_image)) {
                Storage::disk('public')->delete($blog->desktop_image);
            }
            $path = $request->file('desktop_image')->store('blogs', 'public');
            $postData['desktop_image'] = $path;
        }

        if ($request->hasFile('mobile_image')) {
            // Delete old file
            if ($blog->mobile_image && Storage::disk('public')->exists($blog->mobile_image)) {
                Storage::disk('public')->delete($blog->mobile_image);
            }
            $path = $request->file('mobile_image')->store('blogs', 'public');
            $postData['mobile_image'] = $path;
        }

        $blog->update($postData);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog post from database.
     */
    public function destroy($id)
    {
        $blog = BlogPost::findOrFail($id);

        // Delete associated files
        if ($blog->desktop_image && Storage::disk('public')->exists($blog->desktop_image)) {
            Storage::disk('public')->delete($blog->desktop_image);
        }
        if ($blog->mobile_image && Storage::disk('public')->exists($blog->mobile_image)) {
            Storage::disk('public')->delete($blog->mobile_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully.');
    }
}
