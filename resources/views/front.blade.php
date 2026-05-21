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
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .hidden-section { display: none !important; }
        .cart-overlay { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        .cart-overlay.active { opacity: 1; pointer-events: auto; }
        .cart-drawer { transform: translateX(100%); transition: transform 0.3s ease-out; }
        .cart-drawer.active { transform: translateX(0); }
    </style>
</head>
<body class="antialiased bg-white font-['figtree'] text-gray-900">

    @php
        $products = $products->map(function($prod) {
        return [
            'id'          => $prod->id,
            'name'        => $prod->name,
            'price'       => $prod->price,
            'category'    => $prod->category ? $prod->category->name : 'Uncategorized',
            'rating'      => 4.5, // Placeholder rating
            'reviews'     => 100, // Placeholder reviews count
            'image'       => 'storage/' . $prod->image ?? 'https://via.placeholder.com/400x500?text=No+image',
            'description' => $prod->description ?? 'No description available.',
        ];
    });
         $categories = $categories->pluck('name')

    @endphp

    <!-- Navigation -->
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2 cursor-pointer" onclick="app.setTab('home')">
                    <div class="bg-black text-white p-1.5 rounded-lg">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight">LUXE.</span>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center space-x-8">
                    <button onclick="app.setTab('home')" id="nav-home" class="nav-btn text-sm font-medium text-black">{{ __('lang.home') }}</button>
                    <button onclick="app.setTab('shop')" id="nav-shop" class="nav-btn text-sm font-medium text-gray-500 hover:text-black">{{ __('lang.shop') }}</button>
                    <button class="text-sm font-medium text-gray-500 hover:text-black">{{ __('lang.categories') }}</button>
                    <button class="text-sm font-medium text-gray-500 hover:text-black">{{ __('lang.about') }}</button>
                    @if(app()->getLocale() === 'en')
                        <a href="/lang/km" class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-black">
                            <i data-lucide="globe" class="w-5 h-5"> </i> Khmer 
                        </a>
                    @endif
                    @if(app()->getLocale() === 'km')
                        <a href="/lang/en" class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-black">
                            <i data-lucide="globe" class="w-5 h-5"> </i> English 
                        </a>
                    @endif
                    {{-- <a href="/lang/en">English</a>
                    <a href="/lang/km">Khmer</a> --}}

                </div>

                <!-- Icons -->
                <div class="flex items-center gap-4">
                    <button class="p-2 text-gray-500 hover:text-black hidden sm:block">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                    <button onclick="app.toggleCart(true)" class="p-2 text-gray-500 hover:text-black relative">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <span id="cart-count-badge" class="hidden absolute top-1 right-1 bg-black text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center"></span>
                    </button>
                    <button class="md:hidden p-2 text-gray-500" onclick="app.toggleMenu()">
                        <i id="menu-icon-open" data-lucide="menu" class="w-6 h-6"></i>
                        <i id="menu-icon-close" data-lucide="x" class="w-6 h-6 hidden"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 px-4 py-4 space-y-4">
            <button onclick="app.setTab('home'); app.toggleMenu(false)" class="block w-full text-left text-lg font-medium">Home</button>
            <button onclick="app.setTab('shop'); app.toggleMenu(false)" class="block w-full text-left text-lg font-medium">Shop</button>
            <button class="block w-full text-left text-lg font-medium">Categories</button>
            <button class="block w-full text-left text-lg font-medium">Account</button>
        </div>
    </nav>

    <!-- Cart Drawer -->
    <div id="cart-overlay" class="cart-overlay fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="app.toggleCart(false)"></div>
        <div id="cart-drawer" class="cart-drawer fixed right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl flex flex-col">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold">Shopping Cart (<span id="cart-title-count">0</span>)</h2>
                <button onclick="app.toggleCart(false)" class="p-2 hover:bg-gray-100 rounded-full">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div id="cart-items-container" class="flex-1 overflow-y-auto p-6 space-y-6">
                <!-- Items injected by JS -->
            </div>

            <div id="cart-footer" class="hidden p-6 border-t border-gray-100 space-y-4">
                <div class="flex justify-between text-lg font-bold">
                    <span>Total</span>
                    <span id="cart-total-value">$0.00</span>
                </div>
                <button class="w-full bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition-colors">Checkout Now</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Home View -->
        <div id="view-home" class="view-section space-y-20 pb-20">
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
                            <button onclick="app.setTab('shop')" class="px-8 py-4 bg-black text-white rounded-xl font-bold flex items-center gap-2 hover:bg-gray-800 transition-all transform hover:-translate-y-1">
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
                    @foreach($products->take(3) as $product)
                        <div class="group">
                            <div class="relative aspect-[4/5] bg-gray-50 rounded-[2rem] overflow-hidden cursor-pointer" 
                                 onclick="app.viewProduct({{ Js::from($product) }})">
                                <img src="{{ $product['image'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute top-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                    <button onclick="event.stopPropagation(); app.addToCart({{ Js::from($product) }})" class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-black hover:text-white">
                                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 px-2">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-gray-900 text-lg cursor-pointer" onclick="app.viewProduct({{ Js::from($product) }})">
                                        {{ $product['name'] }}
                                    </h3>
                                    <p class="font-bold text-black">${{ number_format($product['price'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Shop View -->
        <div id="view-shop" class="view-section hidden-section max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-extrabold mb-8">All Products</h1>
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($categories as $cat)
                    <button id="cat-{{ $cat }}" onclick="app.setCategory('{{ $cat }}')" 
                            class="cat-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all {{ $cat === 'All' ? 'bg-black text-white' : 'bg-white text-gray-600 border border-gray-200' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="product-card group" data-category="{{ $product['category'] }}">
                        <div class="relative aspect-[4/5] bg-gray-50 rounded-[2rem] overflow-hidden cursor-pointer" 
                             onclick="app.viewProduct({{ Js::from($product) }})">
                            <img src="{{ $product['image'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                <button onclick="event.stopPropagation(); app.addToCart({{ Js::from($product) }})" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-black hover:text-white">
                                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 px-2">
                            <h3 class="font-bold text-gray-900 cursor-pointer" onclick="app.viewProduct({{ Js::from($product) }})">
                                {{ $product['name'] }}
                            </h3>
                            <p class="font-bold text-black">${{ number_format($product['price'], 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Product Detail View -->
        <div id="view-product-detail" class="view-section hidden-section max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div id="product-detail-container">
                <!-- Injected via JS -->
            </div>
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
            <p class="text-gray-500 text-sm">© 2026 LUXE Store. Built with Laravel 13 and Vanilla JavaScript.</p>
        </div>
    </footer>

    <script>
        const app = {
            state: {
                activeTab: 'home',
                isCartOpen: false,
                isMenuOpen: false,
                selectedCategory: 'All',
                cart: [],
                selectedProduct: null
            },

            init() {
                this.renderCart();
                lucide.createIcons();
            },

            setTab(tab) {
                this.state.activeTab = tab;
                document.querySelectorAll('.view-section').forEach(el => el.classList.add('hidden-section'));
                document.getElementById(`view-${tab}`).classList.remove('hidden-section');
                
                // Update nav styles
                document.querySelectorAll('.nav-btn').forEach(btn => {
                    btn.classList.remove('text-black');
                    btn.classList.add('text-gray-500');
                });
                const activeBtn = document.getElementById(`nav-${tab}`);
                if (activeBtn) {
                    activeBtn.classList.add('text-black');
                    activeBtn.classList.remove('text-gray-500');
                }
                window.scrollTo(0, 0);
            },

            setCategory(cat) {
                this.state.selectedCategory = cat;
                document.querySelectorAll('.cat-btn').forEach(btn => {
                    btn.className = 'cat-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all bg-white text-gray-600 border border-gray-200';
                });
                document.getElementById(`cat-${cat}`).className = 'cat-btn px-6 py-2.5 rounded-full text-sm font-semibold transition-all bg-black text-white';
                
                document.querySelectorAll('.product-card').forEach(card => {
                    if (cat === 'All' || card.dataset.category === cat) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            },

            toggleMenu(force) {
                this.state.isMenuOpen = force !== undefined ? force : !this.state.isMenuOpen;
                const menu = document.getElementById('mobile-menu');
                const openIcon = document.getElementById('menu-icon-open');
                const closeIcon = document.getElementById('menu-icon-close');
                
                if (this.state.isMenuOpen) {
                    menu.classList.remove('hidden');
                    openIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                } else {
                    menu.classList.add('hidden');
                    openIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            },

            toggleCart(open) {
                this.state.isCartOpen = open;
                const overlay = document.getElementById('cart-overlay');
                const drawer = document.getElementById('cart-drawer');
                if (open) {
                    overlay.classList.add('active');
                    drawer.classList.add('active');
                } else {
                    overlay.classList.remove('active');
                    drawer.classList.remove('active');
                }
            },

            addToCart(product) {
                const existing = this.state.cart.find(i => i.id === product.id);
                if (existing) {
                    existing.quantity++;
                } else {
                    this.state.cart.push({ ...product, quantity: 1 });
                }
                this.renderCart();
                this.toggleCart(true);
            },

            updateQuantity(id, delta) {
                const item = this.state.cart.find(i => i.id === id);
                if (item) {
                    item.quantity += delta;
                    if (item.quantity <= 0) {
                        this.state.cart = this.state.cart.filter(i => i.id !== id);
                    }
                }
                this.renderCart();
            },

            viewProduct(product) {
                this.state.selectedProduct = product;
                const container = document.getElementById('product-detail-container');
                container.innerHTML = `
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
                        <div class="aspect-[4/5] bg-gray-50 rounded-[2.5rem] overflow-hidden">
                            <img src="${product.image}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center space-y-8">
                            <div class="flex items-center gap-4">
                                <button onclick="app.setTab('shop')" class="text-sm font-bold flex items-center gap-1 text-gray-400 hover:text-black transition-colors">
                                    <i data-lucide="chevron-left" class="w-4 h-4"></i> Back to Shop
                                </button>
                            </div>
                            <div>
                                <p class="text-gray-500 font-medium uppercase tracking-widest text-xs">${product.category}</p>
                                <h1 class="text-4xl font-extrabold text-gray-900">${product.name}</h1>
                            </div>
                            <p class="text-3xl font-bold text-black">$${product.price.toFixed(2)}</p>
                            <p class="text-lg text-gray-600 leading-relaxed">${product.description}</p>
                            <button onclick='app.addToCart(${JSON.stringify(product)})' class="w-full bg-black text-white py-5 rounded-2xl font-bold text-lg hover:bg-gray-800 transition-all">
                                Add to Shopping Cart
                            </button>
                        </div>
                    </div>
                `;
                this.setTab('product-detail');
                lucide.createIcons();
            },

            renderCart() {
                const container = document.getElementById('cart-items-container');
                const badge = document.getElementById('cart-count-badge');
                const titleCount = document.getElementById('cart-title-count');
                const footer = document.getElementById('cart-footer');
                const totalVal = document.getElementById('cart-total-value');
                
                const count = this.state.cart.reduce((sum, item) => sum + item.quantity, 0);
                const total = this.state.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

                titleCount.innerText = count;
                if (count > 0) {
                    badge.innerText = count;
                    badge.classList.remove('hidden');
                    footer.classList.remove('hidden');
                    totalVal.innerText = `$${total.toFixed(2)}`;
                    
                    container.innerHTML = this.state.cart.map(item => `
                        <div class="flex gap-4">
                            <img src="${item.image}" class="w-20 h-24 object-cover rounded-lg bg-gray-50" />
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-medium text-gray-900 leading-tight">${item.name}</h4>
                                    <p class="font-semibold">$${(item.price * item.quantity).toFixed(2)}</p>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center border rounded-lg">
                                        <button onclick="app.updateQuantity(${item.id}, -1)" class="px-2 py-1 hover:bg-gray-50">-</button>
                                        <span class="px-3 py-1 text-sm border-x">${item.quantity}</span>
                                        <button onclick="app.updateQuantity(${item.id}, 1)" class="px-2 py-1 hover:bg-gray-50">+</button>
                                    </div>
                                    <button onclick="app.updateQuantity(${item.id}, -${item.quantity})" class="text-sm text-red-500 hover:text-red-700 font-medium">Remove</button>
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    badge.classList.add('hidden');
                    footer.classList.add('hidden');
                    container.innerHTML = `
                        <div class="h-full flex flex-col items-center justify-center text-gray-400 space-y-4">
                            <i data-lucide="shopping-bag" class="w-12 h-12 stroke-1"></i>
                            <p>Your cart is empty</p>
                            <button onclick="app.toggleCart(false); app.setTab('shop')" class="text-black font-semibold underline">Start Shopping</button>
                        </div>
                    `;
                }
                lucide.createIcons();
            }
        };

        window.onload = () => app.init();
    </script>
</body>
</html>