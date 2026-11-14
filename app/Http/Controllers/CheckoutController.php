<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Validate and apply coupon code via AJAX request.
     */
    public function applyCoupon(Request $request)
    {
        $code = strtoupper(trim($request->input('code', '')));
        $subtotal = (float) $request->input('subtotal', 0);

        if (empty($code)) {
            return response()->json(['success' => false, 'message' => 'Please enter a coupon code.']);
        }

        $coupon = Coupon::where('code', $code)->where('is_active', true)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }

        $discountPercentage = $coupon->discount_percentage;
        $discountAmount = ($subtotal * $discountPercentage) / 100;
        $newTotal = $subtotal - $discountAmount;

        return response()->json([
            'success' => true,
            'discount_percentage' => (float) $discountPercentage,
            'discount_amount' => round($discountAmount, 2),
            'new_total' => round($newTotal, 2),
            'message' => 'Coupon applied successfully!'
        ]);
    }
}
