<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Render the specific master Lookbook collection view dynamically.
     */
    public function showLookbook($type)
    {
        $validTypes = ['men', 'women', 'oversized', 'summer', 'streetwear', 'accessories'];

        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $products = Product::where('lookbook', $type)->latest()->get();
        $categories = Category::where('lookbook', $type)->get();

        return view('collection.' . $type, compact('products', 'categories', 'type'));
    }

    /**
     * Render the specific garment detail viewport page.
     */
    public function showDetail($slug = 'coat')
    {
        // Resolve dynamic piece by slug preloading authorized client reviews array and live stock variations
        $product = Product::with(['reviews' => function ($query) {
            $query->where('is_approved', true)->latest();
        }, 'variations'])->where('slug', $slug)->first();

        return view('product.detail', compact('product', 'slug'));
    }

    /**
     * Search live inventory directly inside database matching partial strings.
     */
    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen(trim($query)) === 0) {
            return response()->json([]);
        }

        $products = Product::where('title', 'LIKE', '%' . $query . '%')
            ->orWhere('lookbook', 'LIKE', '%' . $query . '%')
            ->orWhere('category_slug', 'LIKE', '%' . $query . '%')
            ->limit(8)
            ->get();

        $results = $products->map(function ($item) {
            return [
                'slug' => $item->slug,
                'title' => $item->title,
                'price' => (float) $item->price,
                'image' => $item->image_path,
                'lookbook' => ucfirst($item->lookbook),
                'category' => ucfirst($item->category_slug),
            ];
        });

        return response()->json($results);
    }

    /**
     * Show the dynamic, premium brand About Us page.
     */
    public function showAbout()
    {
        return view('about');
    }

    /**
     * Show the dynamic, premium brand Contact Us page.
     */
    public function showContact()
    {
        return view('contact');
    }
}
