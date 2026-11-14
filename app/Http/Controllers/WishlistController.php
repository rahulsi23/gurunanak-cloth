<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();
            
        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Toggle a product in the user's wishlist (Add/Remove).
     */
    public function toggle(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $userId = Auth::id();

        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlistItem) {
            // Remove from wishlist if it already exists
            $wishlistItem->delete();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'removed',
                    'message' => 'Product removed from wishlist.',
                    'count' => Wishlist::where('user_id', $userId)->count()
                ]);
            }
            
            return back()->with('success', 'Product removed from wishlist.');
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $product->id
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'added',
                    'message' => 'Product added to wishlist!',
                    'count' => Wishlist::where('user_id', $userId)->count()
                ]);
            }
            
            return back()->with('success', 'Product added to wishlist!');
        }
    }
}
