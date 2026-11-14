<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display the storefront blog directory index.
     */
    public function index(Request $request)
    {
        $categories = BlogCategory::withCount(['posts' => function($query) {
            $query->visible();
        }])->orderBy('name')->get();

        $query = BlogPost::visible()->with('category')->latest();

        // Optional filtering by category slug
        $activeCategory = null;
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $activeCategory = BlogCategory::where('slug', $categorySlug)->first();
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        $posts = $query->paginate(9);

        // Fetch custom page SEO for '/blogs' route if exists, or use default
        $pageSeo = new \stdClass();
        $pageSeo->meta_title = 'Bespoke Journal | GURUNANAK Tailoring & Heritage';
        $pageSeo->meta_description = 'Explore editorial stories on minimal design philosophy, luxury handloom heritage, styling guidelines, and tailoring legacy behind our premium garments.';
        $pageSeo->meta_keywords = 'luxury fashion blog, tailoring legacy, styling guide, handloom history';
        $pageSeo->og_title = $pageSeo->meta_title;
        $pageSeo->og_description = $pageSeo->meta_description;
        
        $settings = \Illuminate\Support\Facades\Cache::get('store_settings', []);
        if (!empty($settings['og_image'])) {
            $pageSeo->og_image = asset('storage/' . $settings['og_image']);
        } else {
            $pageSeo->og_image = '';
        }

        return view('blogs.index', compact('posts', 'categories', 'activeCategory', 'pageSeo'));
    }

    /**
     * Display a specific blog post detail page.
     */
    public function show($slug)
    {
        $post = BlogPost::visible()->with('category')->where('slug', $slug)->firstOrFail();

        // Compile custom dynamic SEO for the article
        $pageSeo = new \stdClass();
        $pageSeo->meta_title = ($post->meta_title ?: $post->title) . ' | GURUNANAK Bespoke Journal';
        $pageSeo->meta_description = $post->meta_description ?: ($post->short_summary ?: strip_tags(substr($post->content, 0, 160)));
        $pageSeo->meta_keywords = $post->meta_keywords ?: 'bespoke article, luxury fashion journal, gurunanak style';
        $pageSeo->og_title = $pageSeo->meta_title;
        $pageSeo->og_description = $pageSeo->meta_description;
        $pageSeo->og_image = $post->desktop_image ? asset('storage/' . $post->desktop_image) : '';

        // Fetch recent related articles in the same category or general recent posts
        $relatedPosts = BlogPost::visible()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, function($q) use ($post) {
                $q->where('category_id', $post->category_id);
            })
            ->latest()
            ->take(3)
            ->get();

        if ($relatedPosts->count() < 3) {
            $extraPosts = BlogPost::visible()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->latest()
                ->take(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->concat($extraPosts);
        }

        return view('blogs.show', compact('post', 'pageSeo', 'relatedPosts'));
    }
}
