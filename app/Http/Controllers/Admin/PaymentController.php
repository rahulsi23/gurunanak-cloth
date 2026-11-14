<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show the payment gateway configuration form.
     */
    public function edit()
    {
        $settings = StoreSetting::pluck('value', 'key')->toArray();
        return view('admin.payment.edit', compact('settings'));
    }

    /**
     * Update the payment gateway API keys in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'payment_gateway_provider' => 'required|string|in:razorpay,stripe,cod',
            'razorpay_key_id' => 'nullable|string',
            'razorpay_key_secret' => 'nullable|string',
            'stripe_public_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            StoreSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // Clear the settings cache so it loads fresh on next checkout call
        \Illuminate\Support\Facades\Cache::forget('store_settings');

        return redirect()->back()->with('success', 'Payment Gateway APIs have been updated successfully.');
    }
}
