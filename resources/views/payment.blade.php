    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Checkout - MONACOSHOP. | Modern E-Commerce</title>
        
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
                       <div class="bg-white text-gray-900 p-1.5 rounded-lg shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <path d="M12 12 C6 12 2 9 2 5 C2 2 6 2 12 8 C12 8 12 12 12 12 Z" />
                            <path d="M12 12 C7 4 3 18 C3 21 7 21 12 15 Z" />
                            <path d="M12 12 C18 12 22 9 22 5 C22 2 18 2 12 8 C12 8 12 12 12 12 Z" />
                            <path d="M12 12 C17 1 18 C21 21 17 21 12 15 Z" />
                        </svg>
                    </div>
                        <span class="text-xl font-bold tracking-tight">MONACOSHOP.</span>
                    </a>

                    <!-- Search + Auth -->
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex items-center bg-gray-100 rounded-lg px-3 py-1">
                            <input type="text" placeholder="Search products" class="bg-transparent outline-none text-sm w-64" />
                            <button class="text-gray-600 hover:text-black">
                                <i data-lucide="search" class="w-4 h-4"></i>
                            </button>
                        </div>

                        @auth
                            <div class="flex items-center gap-3">
                                <a href="{{ route('profile.edit') }}" class="text-sm text-gray-700 hover:text-black">{{ auth()->user()->name }}</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm px-3 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">Logout</button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-black">Login</a>
                                <a href="{{ route('register') }}" class="text-sm px-3 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Register</a>
                            </div>
                        @endauth
                    </div>
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
    <footer class="bg-white border-t border-gray-100 pt-16 pb-8 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-12 border-b border-gray-100">
            <!-- Brand Column -->
            <div class="text-center md:text-left">
                <div class="flex justify-center md:justify-start items-center gap-2 mb-4">
                   <div class="bg-white text-gray-900 p-1.5 rounded-lg shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <path d="M12 12 C6 12 2 9 2 5 C2 2 6 2 12 8 C12 8 12 12 12 12 Z" />
                <path d="M12 12 C7 4 3 18 C3 21 7 21 12 15 Z" />
                <path d="M12 12 C18 12 22 9 22 5 C22 2 18 2 12 8 C12 8 12 12 12 12 Z" />
                <path d="M12 12 C17 1 18 C21 21 17 21 12 15 Z" />
            </svg>
        </div>
                    <span class="text-xl font-bold tracking-tight">MONACOSHOP.</span>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Premium quality products for the modern lifestyle. Style meets substance.
                </p>
                <div class="flex justify-center md:justify-start gap-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-black transition-colors">
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-black transition-colors">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-black transition-colors">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-black transition-colors">
                        <i data-lucide="github" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Shop Column -->
            <div class="text-center md:text-left">
                <h3 class="font-semibold text-gray-900 mb-4">Shop</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">New Arrivals</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Best Sellers</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Sale</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Gift Cards</a></li>
                </ul>
            </div>

            <!-- Support Column -->
            <div class="text-center md:text-left">
                <h3 class="font-semibold text-gray-900 mb-4">Support</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Shipping Info</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Returns</a></li>
                    <li><a href="#" class="text-gray-500 hover:text-black text-sm transition-colors">Size Guide</a></li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="text-center md:text-left">
                <h3 class="font-semibold text-gray-900 mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="flex justify-center md:justify-start items-center gap-2 text-gray-500 text-sm">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        <span>monacoshop@luxe.com</span>
                    </li>
                    <li class="flex justify-center md:justify-start items-center gap-2 text-gray-500 text-sm">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                        <span>+1 (555) 123-4567</span>
                    </li>
                    <li class="flex justify-center md:justify-start items-center gap-2 text-gray-500 text-sm">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        <span>123 Fashion Ave, NYC</span>
                    </li>
                </ul>
            </div>
        </div>


            <!-- Bottom Bar -->
            <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-xs">© 2026 MONACOSHOP Store. Built with Laravel 13 and Vanilla JavaScript.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-400 hover:text-black text-xs transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-black text-xs transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-black text-xs transition-colors">Cookie Settings</a>
                </div>
            </div>
        </div>
    </footer>

        <script>
            lucide.createIcons();
        </script>
    </body>
    </html>
