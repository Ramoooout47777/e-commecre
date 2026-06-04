<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = json_decode($request->input('cart', '[]'), true);
        
        if (empty($cart)) {
            return redirect('/')->with('error', 'Cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('payment', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'payment_method' => 'required|in:credit_card,bank_transfer,cash_on_delivery',
        ]);

        $cart = json_decode($request->input('cart', '[]'), true);

        if (empty($cart)) {
            return redirect('/')->with('error', 'Cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        }

        // TODO: Integrate with payment gateway here. For now assume payment succeeded.

        // Persist order and items
        DB::transaction(function () use ($validated, $cart, $total, $request) {
            $order = Order::create([
                'user_id' => $request->user() ? $request->user()->id : null,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'] ?? null,
                    'product_name' => $item['name'] ?? ($item['title'] ?? 'Unknown'),
                    'price' => $item['price'] ?? 0,
                    'quantity' => $item['quantity'] ?? 1,
                ]);
            }
        });

        return redirect('/')->with('success', 'Order placed successfully!');
    }
}
