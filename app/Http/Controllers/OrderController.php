<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of client sales orders matching sleek Dark Mode guidelines.
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display detail parameters of specific order envelope.
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Generate printable billing invoice.
     */
    public function invoice(Order $order)
    {
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Update processing handoff lifecycle state.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:New Order,Processing,Dispatched,Delivered',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Intercept incoming storefront checkout payload streams directly into relational structures.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'total_amount' => 'required|numeric',
            'items' => 'required|string', // Incoming raw JSON array string
        ]);

        // Generate custom deterministic transaction number
        $orderNumber = 'GNK-' . date('Y') . '-' . rand(10000, 99999);

        $items = json_decode($validated['items'], true) ?: [];

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'shipping_address' => $validated['shipping_address'],
            'total_amount' => $validated['total_amount'],
            'items' => $items,
            'status' => 'New Order',
        ]);

        // Deduct inventory stock from product_variations
        foreach ($items as $item) {
            $product = \App\Models\Product::where('slug', $item['id'])->first();
            if ($product) {
                $variation = \App\Models\ProductVariation::where('product_id', $product->id)
                    ->where('size_label', $item['size'] ?? null)
                    ->where('color_label', $item['color'] ?? null)
                    ->first();
                
                if ($variation && $variation->stock_quantity > 0) {
                    $variation->decrement('stock_quantity', $item['qty']);
                }
            }
        }

        // Dispatch Automated Mailable Pipelines
        try {
            \Illuminate\Support\Facades\Mail::to($order->customer_email)->send(new \App\Mail\OrderPlacedReceipt($order));
            \Illuminate\Support\Facades\Mail::to('admin@gurunanakcloth.com')->send(new \App\Mail\AdminOrderAlert($order));
        } catch (\Exception $e) {
            // Fail silently so checkout does not crash if SMTP is not configured
            \Illuminate\Support\Facades\Log::error('Mail dispatch failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'message' => 'Order verified and mapped to live studio ledgers successfully.'
        ]);
    }
}
