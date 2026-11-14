<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a paginated list of all promotional coupons.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'discount_percentage' => 'required|numeric|min:1|max:100',
        ]);

        Coupon::create([
            'code' => strtoupper(trim($validated['code'])),
            'discount_percentage' => $validated['discount_percentage'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Promo Coupon generated and live instantly.');
    }

    /**
     * Update the specified coupon in storage (Toggle Status).
     */
    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update([
            'is_active' => !$coupon->is_active
        ]);

        return redirect()->back()->with('success', 'Coupon status successfully toggled.');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('success', 'Coupon deleted from records permanently.');
    }
}
