<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

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

        // Persist order and items with inventory validation.
        try {
            DB::transaction(function () use ($validated, $cart, $total, $request) {
                // If the buyer is not authenticated, ensure a user account exists and log them in.
                $userId = $request->user() ? $request->user()->id : null;
                if (! $userId) {
                    $existing = User::where('email', $validated['email'])->first();
                    if ($existing) {
                        $userId = $existing->id;
                    } else {
                        $password = Str::random(12);
                        $newUser = User::create([
                            'name' => $validated['name'],
                            'email' => $validated['email'],
                            'password' => Hash::make($password),
                        ]);
                        // Optionally store phone on the profile if users table has it. Skip if not present.
                        if (Schema::hasColumn('users', 'phone')) {
                            $newUser->phone = $validated['phone'];
                            $newUser->save();
                        }
                        $userId = $newUser->id;
                        // Log the user in so future requests are authenticated
                        Auth::login($newUser);
                    }
                }

                $order = Order::create([
                    'user_id' => $userId,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'total' => $total,
                    'payment_method' => $validated['payment_method'],
                    'status' => 'completed',
                ]);

                foreach ($cart as $item) {
                    $productId = $item['id'] ?? null;
                    $quantity = max(1, (int) ($item['quantity'] ?? 1));
                    $product = Product::lockForUpdate()->find($productId);

                    if (! $product) {
                        throw new \Exception('Product not found for one of the cart items.');
                    }

                    if ($product->stock < $quantity) {
                        throw new \Exception("Only {$product->stock} unit(s) left in stock for {$product->name}.");
                    }

                    $product->decrement('stock', $quantity);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $item['price'] ?? 0,
                        'quantity' => $quantity,
                    ]);
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('/')->with('success', 'Order placed successfully!');
    }
}
