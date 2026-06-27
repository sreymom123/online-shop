<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();
        return response()->json($orders);
    }

    public function show(Request $request, $id)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);
        return response()->json($order);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'address' => 'nullable|string',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart ទទេ!'], 400);
        }

        // Calculate total
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Create Order
        $order = Order::create([
            'user_id'      => $request->user()->id,
            'total_amount' => $total,
            'address'      => $request->address,
            'status'       => 'pending',
        ]);

        // Create Order Items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        // Clear Cart
        Cart::where('user_id', $request->user()->id)->delete();

        return response()->json([
            'message' => 'Order Success!',
            'order'   => $order->load('orderItems.product'),
        ], 201);
    }
}