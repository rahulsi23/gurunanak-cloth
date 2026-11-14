<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly submitted review in storage linked directly to product models.
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $imagePathUrl = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = time() . '-' . uniqid() . '.webp';
            $destinationPath = public_path('uploads/reviews');
            
            if (!file_exists($destinationPath)) {
                @mkdir($destinationPath, 0755, true);
            }
            
            if ($extension === 'webp') {
                $file->move($destinationPath, $filename);
            } else {
                $imagePath = $file->getRealPath();
                $image = null;
                
                if ($extension === 'jpg' || $extension === 'jpeg') {
                    $image = @imagecreatefromjpeg($imagePath);
                } elseif ($extension === 'png') {
                    $image = @imagecreatefrompng($imagePath);
                    if ($image) {
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                    }
                } elseif ($extension === 'gif') {
                    $image = @imagecreatefromgif($imagePath);
                }
                
                if ($image) {
                    @imagewebp($image, $destinationPath . '/' . $filename, 85);
                    @imagedestroy($image);
                } else {
                    $filename = time() . '-' . uniqid() . '.' . $extension;
                    $file->move($destinationPath, $filename);
                }
            }
            
            $imagePathUrl = asset('uploads/reviews/' . $filename);
        }

        $product->reviews()->create([
            'customer_name' => trim($validated['customer_name']),
            'rating' => (int) $validated['rating'],
            'comment' => isset($validated['comment']) ? trim($validated['comment']) : null,
            'image_path' => $imagePathUrl,
            'is_approved' => true, // Immediate display enablement for smooth demonstration loop flow
        ]);

        return redirect()->back()->with('review_success', 'Thank you! Your feedback has been published and integrated into live product ratings.');
    }
}
