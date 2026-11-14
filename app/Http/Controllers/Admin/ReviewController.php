<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a paginated list of all customer product reviews.
     */
    public function index()
    {
        $reviews = Review::with('product')->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Toggle the visibility/approval status of a client review.
     */
    public function toggleApprove(Review $review)
    {
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        $state = $review->is_approved ? 'Approved and active' : 'Hidden from storefront';

        return redirect()->back()->with('success', "Review status modified: {$state}.");
    }

    /**
     * Remove the specified review from storage and trigger storage space garbage cleanup.
     */
    public function destroy(Review $review)
    {
        // Image Garbage Collector: Purge optional customer uploaded files safely from disk space
        if (!empty($review->image_path)) {
            $relativePath = str_replace(asset('/'), '', $review->image_path);
            $fullPath = public_path($relativePath);
            
            if (file_exists($fullPath) && is_file($fullPath)) {
                @unlink($fullPath);
            }
        }

        $review->delete();

        return redirect()->back()->with('success', 'Customer review securely purged and uploaded media cache released.');
    }

    /**
     * Store or update an administrative reply to a review.
     */
    public function reply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'admin_reply' => 'nullable|string|max:1000'
        ]);

        $review->update([
            'admin_reply' => $validated['admin_reply'] ?? null
        ]);

        return redirect()->back()->with('success', 'Your response to the customer review has been updated successfully.');
    }
}
