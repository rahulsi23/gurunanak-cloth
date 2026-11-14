<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the blog categories.
     */
    public function index()
    {
        $categories = BlogCategory::withCount('posts')->orderBy('name')->get();
        return view('admin.blog_categories.index', compact('categories'));
    }

    /**
     * Store a newly created blog category in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:blog_categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        BlogCategory::create($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category created successfully.');
    }

    /**
     * Update the specified blog category in database.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:blog_categories,name,' . $blogCategory->id,
            'description' => 'nullable|string|max:500',
        ]);

        $blogCategory->update($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category updated successfully.');
    }

    /**
     * Remove the specified blog category from database.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category deleted successfully.');
    }
}
