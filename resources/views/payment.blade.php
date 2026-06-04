    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Checkout - LUXE. | Modern E-Commerce</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="antialiased bg-gray-50 font-['figtree'] text-gray-900">

        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2 cursor-pointer">
                        <div class="bg-black text-white p-1.5 rounded-lg">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight">LUXE.</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Summary -->
                <div class="lg:col-span-1 order-last lg:order-none">
                    <div class="bg-white rounded-2xl p-8 sticky top-8 border border-gray-100">
                        <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                        
                        <div class="space-y-6 mb-6 pb-6 border-b border-gray-100 max-h-96 overflow-y-auto">
                            @foreach($cart as $item)
                                <div class="flex gap-4">
                                    <img src="{{ $item['image'] }}" class="w-16 h-20 object-cover rounded-lg bg-gray-100" />
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-sm text-gray-900">{{ $item['name'] }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">Qty: {{ $item['quantity'] }}</p>
                                        <p class="font-semibold mt-2">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold">Free</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-semibold">$0.00</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold pt-4 border-t border-gray-100">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl p-8 border border-gray-100">
                        <h1 class="text-3xl font-bold mb-2">Checkout</h1>
                        <p class="text-gray-500 mb-8">Complete your purchase securely</p>

                        <form action="{{ route('payment.process') }}" method="POST" class="space-y-8">
                            @csrf

                            @if(session('success'))
                                <div class="p-4 bg-green-50 border border-green-100 text-green-700 rounded">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="p-4 bg-red-50 border border-red-100 text-red-700 rounded">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <input type="hidden" name="cart" value='@json($cart)'>

                            <!-- Billing Information -->
                            <div>
                                <h3 class="text-lg font-bold mb-4">Billing Information</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                        <input type="text" name="name" required 
                                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black transition-colors"
                                            placeholder="John Doe">
                                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="email" required 
                                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black transition-colors"
                                            placeholder="john@example.com">
                                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" name="phone" required 
                                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black transition-colors"
                                            placeholder="+1 (555) 000-0000">
                                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                        <input type="text" name="address" required 
                                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-black transition-colors"
                                            placeholder="123 Main St, City, State 12345">
                                        @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <h3 class="text-lg font-bold mb-4">Payment Method</h3>
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="payment_method" value="credit_card" checked required class="w-4 h-4">
                                        <span class="ml-3 flex items-center gap-2">
                                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                                            <span class="font-medium">Credit/Debit Card</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="payment_method" value="bank_transfer" required class="w-4 h-4">
                                        <span class="ml-3 flex items-center gap-2">
                                            <i data-lucide="building-2" class="w-5 h-5"></i>
                                            <span class="font-medium">Bank Transfer</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="payment_method" value="cash_on_delivery" required class="w-4 h-4">
                                        <span class="ml-3 flex items-center gap-2">
                                            <i data-lucide="banknote" class="w-5 h-5"></i>
                                            <span class="font-medium">Cash on Delivery</span>
                                        </span>
                                    </label>
                                    @error('payment_method') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-4 pt-6 border-t border-gray-100">
                                <a href="/" class="flex-1 px-6 py-4 border border-gray-200 rounded-lg font-semibold text-center hover:bg-gray-50 transition-colors">
                                    Continue Shopping
                                </a>
                                <button type="submit" class="flex-1 px-6 py-4 bg-black text-white rounded-lg font-semibold hover:bg-gray-800 transition-colors">
                                    Complete Purchase
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 mt-20 pt-20 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="flex justify-center items-center gap-2 mb-6">
                    <div class="bg-black text-white p-1.5 rounded-lg">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight">LUXE.</span>
                </div>
                <p class="text-gray-500 text-sm">© 2026 LUXE Store. Built with Laravel 13 and Vanilla JavaScript.</p>
            </div>
        </footer>

        <script>
            lucide.createIcons();
        </script>
    </body>
    </html>
