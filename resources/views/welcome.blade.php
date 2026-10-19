<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LUXE. | Modern E-Commerce</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (via CDN for standalone demo) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js for Interactivity (Cart/Menu/Navigation) -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-white font-['figtree'] text-gray-900" 
      x-data="{ 
        activeTab: 'home', 
        isCartOpen: false, 
        isMenuOpen: false, 
        selectedCategory: 'All',
        cart: [],
        viewProduct(product) {
            this.selectedProduct = product;
            this.activeTab = 'product-detail';
            window.scrollTo(0, 0);
        },
        addToCart(product) {
            const existing = this.cart.find(i => i.id === product.id);
            if (existing) {
                existing.quantity++;
            } else {
                this.cart.push({ ...product, quantity: 1 });
            }
            this.isCartOpen = true;
        },
        removeFromCart(id) {
            this.cart = this.cart.filter(i => i.id !== id);
        },
        get cartTotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2);
        },
        get cartCount() {
            return this.cart.reduce((sum, item) => sum + item.quantity, 0);
        },
        selectedProduct: null,
        products: [
            { id: 1, name: 'Premium Wireless Headphones', price: 299.99, category: 'Electronics', rating: 4.8, reviews: 124, image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80', description: 'Experience studio-quality sound with our flagship wireless headphones featuring active noise cancellation.' },
            { id: 2, name: 'Minimalist Leather Watch', price: 159.00, category: 'Accessories', rating: 4.6, reviews: 89, image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80', description: 'A timeless timepiece designed for those who appreciate clean lines and premium materials.' },
            { id: 3, name: 'Smart Fitness Tracker', price: 89.99, category: 'Electronics', rating: 4.5, reviews: 210, image: 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?auto=format&fit=crop&w=600&q=80', description: 'Track your health and performance with precision. Waterproof and 7-day battery life.' },
            { id: 4, name: 'Ergonomic Desk Chair', price: 450.00, category: 'Furniture', rating: 4.9, reviews: 56, image: 'https://images.unsplash.com/photo-1505843490701-5be5d2b33252?auto=format&fit=crop&w=600&q=80', description: 'Redefine your workspace comfort with full lumbar support and premium breathable mesh.' },
            { id: 5, name: 'Organic Cotton Hoodie', price: 75.00, category: 'Apparel', rating: 4.7, reviews: 142, image: 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=600&q=80', description: 'Sustainable fashion at its finest. Ultra-soft organic cotton for everyday comfort.' },
            { id: 6, name: 'Compact Coffee Maker', price: 120.00, category: 'Kitchen', rating: 4.4, reviews: 95, image: 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?auto=format&fit=crop&w=600&q=80', description: 'Professional grade coffee from the comfort of your home. Sleek design for any kitchen.' }
        ]
      }">

    <!-- Navigation -->
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2 cursor-pointer" @click="activeTab = 'home'">
                    <div class="bg-black text-white p-1.5 rounded-lg">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight">LUXE.</span>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center space-x-8">
                    <button @click="activeTab = 'home'" :class="activeTab === 'home' ? 'text-black' : 'text-gray-500 hover:text-black'" class="text-sm font-medium">Dashboard</button>
                    <button @click="activeTab = 'shop'; selectedCategory = 'All'" :class="activeTab === 'shop' ? 'text-black' : 'text-gray-500 hover:text-black'" class="text-sm font-medium">Shop</button>
                    <button class="text-sm font-medium text-gray-500 hover:text-black">Categories</button>
                    <button class="text-sm font-medium text-gray-500 hover:text-black">About</button>
                </div>

                <!-- Icons -->
                <div class="flex items-center gap-4">
                    <button class="p-2 text-gray-500 hover:text-black hidden sm:block">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                    <button @click="isCartOpen = true" class="p-2 text-gray-500 hover:text-black relative">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <template x-if="cartCount > 0">
                            <span x-text="cartCount" class="absolute top-1 right-1 bg-black text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center"></span>
                        </template>
                    </button>
                    <button class="md:hidden p-2 text-gray-500" @click="isMenuOpen = !isMenuOpen">
                        <i x-show="!isMenuOpen" data-lucide="menu" class="w-6 h-6"></i>
                        <i x-show="isMenuOpen" data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="isMenuOpen" x-cloak class="md:hidden bg-white border-b border-gray-100 px-4 py-4 space-y-4">
            <button @click="activeTab = 'home'; isMenuOpen = false" class="block w-full text-left text-lg font-medium">Dashboard</button>
            <button @click="activeTab = 'shop'; isMenuOpen = false" class="block w-full text-left text-lg font-medium">Shop</button>
            <button class="block w-full text-left text-lg font-medium">Categories</button>
            <button class="block w-full text-left text-lg font-medium">Account</button>
        </div>
    </nav>

    <!-- Cart Drawer -->
    <div x-show="isCartOpen" x-cloak class="fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="isCartOpen = false"></div>
        <div class="fixed right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col transform transition-transform" 
             x-transition:enter="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="translate-x-0" x-transition:leave-end="translate-x-full">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold">Shopping Cart (<span x-text="cartCount"></span>)</h2>
                <button @click="isCartOpen = false" class="p-2 hover:bg-gray-100 rounded-full">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <template x-if="cart.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 space-y-4">
                        <i data-lucide="shopping-bag" class="w-12 h-12 stroke-1"></i>
                        <p>Your cart is empty</p>
                        <button @click="isCartOpen = false; activeTab = 'shop'" class="text-black font-semibold underline">Start Shopping</button>
                    </div>
                </template>

                <template x-for="item in cart" :key="item.id">
                    <div class="flex gap-4">
                        <img :src="item.image" class="w-20 h-24 object-cover rounded-lg bg-gray-50" />
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h4 x-text="item.name" class="font-medium text-gray-900 leading-tight"></h4>
                                <p x-text="'$' + (item.price * item.quantity).toFixed(2)" class="font-semibold"></p>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center border rounded-lg">
                                    <button @click="item.quantity > 1 ? item.quantity-- : removeFromCart(item.id)" class="px-2 py-1 hover:bg-gray-50">-</button>
                                    <span x-text="item.quantity" class="px-3 py-1 text-sm border-x"></span>
                                    <button @click="item.quantity++" class="px-2 py-1 hover:bg-gray-50">+</button>
                                </div>
                                <button @click="removeFromCart(item.id)" class="text-sm text-red-500 hover:text-red-700 font-medium">Remove</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <template x-if="cart.length > 0">
                <div class="p-6 border-t border-gray-100 space-y-4">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span x-text="'$' + cartTotal"></span>
                    </div>
                    <button class="w-full bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition-colors">Checkout Now</button>
                </div>
            </template>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Dashboard View -->
        <div x-show="activeTab === 'home'" x-cloak class="space-y-20 pb-20">
            <!-- Hero Section -->
            <section class="relative h-[80vh] min-h-[600px] flex items-center overflow-hidden bg-gray-50">
                <div class="absolute inset-0 z-0">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover opacity-60">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/90 to-transparent"></div>
                </div>
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="max-w-xl space-y-6">
                        <span class="inline-block px-4 py-1.5 bg-black text-white text-xs font-bold rounded-full uppercase tracking-wider">New Collection 2024</span>
                        <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 leading-[1.1]">Elevate Your <br><span class="text-gray-500">Everyday</span> Life.</h1>
                        <p class="text-lg text-gray-600 leading-relaxed">Curated essentials designed for the modern lifestyle. Quality craftsmanship meets minimalist aesthetic.</p>
                        <div class="flex gap-4 pt-4">
                            <button @click="activeTab = 'shop'" class="px-8 py-4 bg-black text-white rounded-xl font-bold flex items-center gap-2 hover:bg-gray-800 transition-all transform hover:-translate-y-1">
                                Shop Collection <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Featured Products Grid -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold mb-10 text-gray-900">Featured Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <template x-for="product in products.slice(0, 3)" :key="product.id">
                        <div class="group">
                            <div class="relative aspect-[4/5] bg-gray-50 rounded-[2rem] overflow-hidden cursor-pointer" @click="viewProduct(product)">
                                <img :src="product.image" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute top-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                    <button @click.stop="addToCart(product)" class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-black hover:text-white">
                                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 px-2">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-gray-900 text-lg" x-text="product.name" @click="viewProduct(product)"></h3>
                                    <p class="font-bold text-black" x-text="'$' + product.price"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </section>
        </div>

        <!-- Shop View -->
        <div x-show="activeTab === 'shop'" x-cloak class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-extrabold mb-8">All Products</h1>
            <div class="flex flex-wrap gap-2 mb-8">
                <template x-for="cat in ['All', 'Electronics', 'Accessories', 'Apparel', 'Furniture', 'Kitchen']">
                    <button @click="selectedCategory = cat" 
                            :class="selectedCategory === cat ? 'bg-black text-white' : 'bg-white text-gray-600 border border-gray-200'"
                            class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all" x-text="cat"></button>
                </template>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <template x-for="product in products.filter(p => selectedCategory === 'All' || p.category === selectedCategory)" :key="product.id">
                    <div class="group">
                        <div class="relative aspect-[4/5] bg-gray-50 rounded-[2rem] overflow-hidden cursor-pointer" @click="viewProduct(product)">
                            <img :src="product.image" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                <button @click.stop="addToCart(product)" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-black hover:text-white">
                                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 px-2">
                            <h3 class="font-bold text-gray-900" x-text="product.name"></h3>
                            <p class="font-bold text-black" x-text="'$' + product.price"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Product Detail View -->
        <div x-show="activeTab === 'product-detail'" x-cloak class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <template x-if="selectedProduct">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
                    <div class="aspect-[4/5] bg-gray-50 rounded-[2.5rem] overflow-hidden">
                        <img :src="selectedProduct.image" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col justify-center space-y-8">
                        <div>
                            <p class="text-gray-500 font-medium uppercase tracking-widest text-xs" x-text="selectedProduct.category"></p>
                            <h1 class="text-4xl font-extrabold text-gray-900" x-text="selectedProduct.name"></h1>
                        </div>
                        <p class="text-3xl font-bold text-black" x-text="'$' + selectedProduct.price"></p>
                        <p class="text-lg text-gray-600 leading-relaxed" x-text="selectedProduct.description"></p>
                        <button @click="addToCart(selectedProduct)" class="w-full bg-black text-white py-5 rounded-2xl font-bold text-lg hover:bg-gray-800 transition-all">
                            Add to Shopping Cart
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 pt-20 pb-10 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center items-center gap-2 mb-6">
                <div class="bg-black text-white p-1.5 rounded-lg">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                </div>
                <span class="text-xl font-bold tracking-tight">LUXE.</span>
            </div>
            <p class="text-gray-500 text-sm">© 2026 LUXE Store. Built with Laravel 13 and Tailwind CSS.</p>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        window.onload = () => {
            lucide.createIcons();
        };
        
        // Re-initialize icons when Alpine refreshes DOM
        document.addEventListener('alpine:initialized', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>