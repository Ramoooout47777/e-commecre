<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MONACOSHOP. | Modern E-Commerce</title>
    
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
                'stock'       => $prod->stock,
                'rating'      => 4.5, // Placeholder rating
                'reviews'     => 100, // Placeholder reviews count
                'image'       => $prod->image ? asset('storage/' . $prod->image) : 'https://via.placeholder.com/400x500?text=No+image',
                'description' => $prod->description ?? 'No description available.',
            ];
        });
        $categories = $categories->pluck('name');
    @endphp

    <!-- Navigation -->
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2 cursor-pointer" onclick="app.setTab('home')">
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

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center space-x-8">
                    <button onclick="app.setTab('home')" id="nav-home" class="nav-btn text-sm font-medium text-black">{{ __('lang.home') }}</button>
                    <button onclick="app.setTab('shop')" id="nav-shop" class="nav-btn text-sm font-medium text-gray-500 hover:text-black">{{ __('lang.shop') }}</button>
                    <button onclick="app.setTab('categories')" id="nav-categories" class="nav-btn text-sm font-medium text-gray-500 hover:text-black">{{ __('lang.categories') }}</button>
                    <button onclick="app.setTab('about')" id="nav-about" class="nav-btn text-sm font-medium text-gray-500 hover:text-black">{{ __('lang.about') }}</button>
                    <button onclick="app.setTab('slides')" id="nav-about" class="nav-btn text-sm font-medium text-gray-500 hover:text-black">{{ __('lang.slides') }}</button>

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

                <!-- Search + Auth + Icons -->
                <div class="flex items-center gap-4">
                    {{-- <div class="hidden sm:flex items-center bg-gray-100 rounded-lg px-3 py-1">
                        <input type="text" placeholder="Search products" class="bg-transparent outline-none text-sm w-64" />
                        <button class="text-gray-600 hover:text-black">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </button>
                    </div> --}}

                    @auth
                        <div class="hidden sm:flex items-center gap-3">
                            <a href="{{ route('profile.edit') }}" class="text-sm text-gray-700 hover:text-black">{{ auth()->user()->name }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm px-3 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">Logout</button>
                            </form>
                        </div>
                    @else
                        <div class="hidden sm:flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-black">Login</a>
                            <a href="{{ route('register') }}" class="text-sm px-3 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Register</a>
                        </div>
                    @endauth

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
            <button onclick="app.setTab('categories'); app.toggleMenu(false)" class="block w-full text-left text-lg font-medium">Categories</button>
            {{-- <button class="block w-full text-left text-lg font-medium">Categories</button> --}}
            <button onclick="app.setTab('about'); app.toggleMenu(false)" class="block w-full text-left text-lg font-medium">About</button>
            {{-- <button class="block w-full text-left text-lg font-medium">Account</button> --}}
            <button onclick="app.setTab('slides'); app.toggleMenu(false)" class="block w-full text-left text-lg font-medium">Slides</button>
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
                <button onclick="app.checkout()" class="w-full bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition-colors">Checkout Now</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Home View -->
        <div id="view-home" class="view-section space-y-20 pb-20">
            <section class="relative h-[80vh] min-h-[600px] flex items-center overflow-hidden bg-gray-50">
    <!-- Carousel Slides Background -->
    <div id="hero-carousel" class="absolute inset-0 z-0">
        <!-- Slide 1 (Active) -->
        <div class="slide absolute inset-0 opacity-100 transition-opacity duration-1000 ease-in-out">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="Collection View 2">
        </div>
        <!-- Slide 2 -->
        <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out"> 
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="Collection View 1">
        </div>
        <!-- Slide 3 -->
        <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
            <img src="https://images.unsplash.com/photo-1479064555552-3ef4979f8908?auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="Collection View 3">
        </div>
        
        <!-- Ambient Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-white/90 via-white/50 to-transparent z-10"></div>
    </div>

    <!-- Foreground Content -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-xl space-y-6">
            <span class="inline-block px-4 py-1.5 bg-black text-white text-xs font-bold rounded-full uppercase tracking-wider">New Collection 2026</span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 leading-[1.1]">Elevate Your <br><span class="text-gray-500">Everyday</span> Life.</h1>
            <p class="text-lg text-gray-600 leading-relaxed">Curated essentials designed for the modern lifestyle. Quality craftsmanship meets minimalist aesthetic.</p>
            <div class="flex flex-col sm:flex-row gap-4 pt-4 items-start sm:items-center">
                <button onclick="app.setTab('shop')" class="px-8 py-4 bg-black text-white rounded-xl font-bold flex items-center gap-2 hover:bg-gray-800 transition-all transform hover:-translate-y-1">
                    Shop Collection <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
                
                <!-- Carousel Indicators (Visual reference for auto-scroll) -->
                <div class="flex gap-2 ml-2 sm:ml-4 py-4">
                    <span class="indicator w-8 h-1.5 bg-black rounded-full transition-all duration-300"></span>
                    <span class="indicator w-3 h-1.5 bg-gray-300 rounded-full transition-all duration-300"></span>
                    <span class="indicator w-3 h-1.5 bg-gray-300 rounded-full transition-all duration-300"></span>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Auto Scroll JavaScript Logic -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const slides = document.querySelectorAll("#hero-carousel .slide");
                const indicators = document.querySelectorAll(".indicator");
                let currentSlide = 0;
                const slideInterval = 4000; // Time per slide in milliseconds (4 seconds)

                function nextSlide() {
                    // Hide current slide and reset its indicator
                    slides[currentSlide].classList.replace("opacity-100", "opacity-0");
                    indicators[currentSlide].classList.replace("bg-black", "bg-gray-300");
                    indicators[currentSlide].classList.replace("w-8", "w-3");

                    // Move to next slide index
                    currentSlide = (currentSlide + 1) % slides.length;

                    // Show new slide and activate its indicator
                    slides[currentSlide].classList.replace("opacity-0", "opacity-100");
                    indicators[currentSlide].classList.replace("bg-gray-300", "bg-black");
                    indicators[currentSlide].classList.replace("w-3", "w-8");
                }

                // Initialize the auto-scroll timer
                setInterval(nextSlide, slideInterval);
            });
        </script>

            <!-- Featured Products Grid -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold mb-10 text-gray-900">Products</h2>
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

            <!-- Featured Products - Horizontal Scroll -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-3xl font-extrabold text-gray-900">Featured Products</h2>
                    <div class="hidden sm:flex gap-2">
                        <button onclick="document.getElementById('featured-scroll').scrollBy({left: -320, behavior: 'smooth'})"
                                class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-100">
                            <i data-lucide="chevron-left" class="w-5 h-5"></i>
                        </button>
                        <button onclick="document.getElementById('featured-scroll').scrollBy({left: 320, behavior: 'smooth'})"
                                class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-100">
                            <i data-lucide="chevron-right" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div id="featured-scroll"
                    class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 -mx-4 px-4
                            [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    @foreach($products as $product)
                        <div class="group flex-none w-[260px] sm:w-[280px] snap-start">
                            <div class="relative aspect-[4/5] bg-gray-50 rounded-[2rem] overflow-hidden cursor-pointer"
                                onclick="app.viewProduct({{ Js::from($product) }})">
                                <img src="{{ $product['image'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute top-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                    <button onclick="event.stopPropagation(); app.addToCart({{ Js::from($product) }})"
                                            class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-black hover:text-white">
                                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 px-2">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-gray-900 text-lg cursor-pointer"
                                        onclick="app.viewProduct({{ Js::from($product) }})">
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
            <div id="product-detail-container" class="space-y-8">
                <div class="text-center py-20 text-gray-400">
                    <p class="text-xl font-semibold">Select a product to view details.</p>
                    <p class="mt-2">Click any product card to open the detail page.</p>
                </div>
            </div>
        </div>

        <!-- Categories View -->
        <div id="view-categories" class="view-section max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-extrabold mb-8">Categories</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($categories as $cat)
                    <div class="category-card bg-gray-100 rounded-lg p-6 text-center cursor-pointer hover:bg-gray-200" 
                        data-category="{{ $cat }}">
                        <h3 class="font-bold text-gray-900">{{ $cat }}</h3>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Replace your current script below the categories view with this: -->
        <script>
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const selectedCategory = this.getAttribute('data-category');
                
                // 1. Set the filtering state and update category buttons
                app.setCategory(selectedCategory);
                
                // 2. Route the view smoothly using your existing tab switcher
                app.setTab('shop');
            });
        });
        </script>
        <!-- About View -->
        <div id="view-about" class="view-section hidden-section max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
            <h1 class="text-4xl font-extrabold mb-6">About MONACOSHOP.</h1>
            <p class="text-lg text-gray-600 leading-relaxed mb-6">MONACOSHOP. is a modern e-commerce platform built with Laravel 13 and Vanilla JavaScript. We are passionate about delivering high-quality products that blend style and functionality. Our mission is to elevate your everyday life with curated essentials designed for the modern lifestyle.</p>
            <p class="text-lg text-gray-600 leading-relaxed">From premium wireless headphones to minimalist leather watches, we offer a carefully selected range of products that embody quality craftsmanship and a minimalist aesthetic. Thank you for choosing LUXE. We hope you enjoy shopping with us!</p>
        </div>
        <!-- Slides View -->
        <div id="view-slides" class="view-section hidden-section max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-extrabold mb-8 text-center">Featured Collection</h1>
            
            <!-- Slides Carousel Container -->
            <div class="relative">
                <!-- Main Slides Wrapper -->
                <div class="overflow-hidden rounded-2xl shadow-xl">
                    <div class="slides-container flex transition-transform duration-500 ease-out" id="slidesContainer">
                        <!-- Slide 1 -->
                        <div class="slide-item w-full flex-shrink-0">
                            <div class="relative bg-gradient-to-br from-gray-900 to-gray-700 text-white">
                                <img src="https://placehold.co/1920x800/1a1a2e/ffffff?text=LUXE.+Wireless+Headphones" alt="LUXE Headphones" class="w-full h-96 object-cover mix-blend-overlay">
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 bg-black/30">
                                    <h2 class="text-4xl md:text-5xl font-bold mb-4">Premium Sound</h2>
                                    <p class="text-lg md:text-xl max-w-2xl mb-6">Experience crystal-clear audio with our flagship wireless headphones.</p>
                                    <button class="bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">Shop Now →</button>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="slide-item w-full flex-shrink-0">
                            <div class="relative bg-gradient-to-br from-amber-800 to-amber-950 text-white">
                                <img src="https://placehold.co/1920x800/2d2a26/f5f0e6?text=LUXE.+Minimalist+Watch" alt="LUXE Watch" class="w-full h-96 object-cover mix-blend-overlay">
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 bg-black/30">
                                    <h2 class="text-4xl md:text-5xl font-bold mb-4">Timeless Elegance</h2>
                                    <p class="text-lg md:text-xl max-w-2xl mb-6">Sleek leather watches crafted for the modern minimalist.</p>
                                    <button class="bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">Discover →</button>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="slide-item w-full flex-shrink-0">
                            <div class="relative bg-gradient-to-br from-slate-800 to-slate-950 text-white">
                                <img src="https://placehold.co/1920x800/1e293b/94a3b8?text=LUXE.+Smart+Essentials" alt="LUXE Essentials" class="w-full h-96 object-cover mix-blend-overlay">
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 bg-black/30">
                                    <h2 class="text-4xl md:text-5xl font-bold mb-4">Everyday Luxury</h2>
                                    <p class="text-lg md:text-xl max-w-2xl mb-6">Elevate your lifestyle with curated premium essentials.</p>
                                    <button class="bg-white text-gray-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">Explore Collection →</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button id="prevSlide" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-lg transition-all duration-200 focus:outline-none">
                    <i class="fas fa-chevron-left text-xl w-6 h-6 flex items-center justify-center"></i>
                </button>
                <button id="nextSlide" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-lg transition-all duration-200 focus:outline-none">
                    <i class="fas fa-chevron-right text-xl w-6 h-6 flex items-center justify-center"></i>
                </button>

                <!-- Dots Indicators -->
                <div class="flex justify-center mt-6 space-x-3" id="dotsContainer">
                    <button class="dot w-3 h-3 rounded-full bg-gray-400 transition-all duration-200" data-index="0"></button>
                    <button class="dot w-3 h-3 rounded-full bg-gray-400 transition-all duration-200" data-index="1"></button>
                    <button class="dot w-3 h-3 rounded-full bg-gray-400 transition-all duration-200" data-index="2"></button>
                </div>
            </div>
        </div>
        <!-- Slides Carousel JavaScript -->
            <script>
                (function() {
                    function initSlideshow() {
                        const slidesContainer = document.getElementById('slidesContainer');
                        const prevBtn = document.getElementById('prevSlide');
                        const nextBtn = document.getElementById('nextSlide');
                        const dots = document.querySelectorAll('.dot');
                        
                        if (!slidesContainer) return;
                        
                        let currentIndex = 0;
                        const totalSlides = document.querySelectorAll('.slide-item').length;
                        let autoPlayInterval;
                        const AUTO_PLAY_DELAY = 5000;

                        function updateSlidePosition() {
                            // Using percentage-based transform - works consistently regardless of container width
                            slidesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
                            dots.forEach((dot, idx) => {
                                if (idx === currentIndex) {
                                    dot.classList.remove('bg-gray-400');
                                    dot.classList.add('bg-gray-900', 'scale-125');
                                } else {
                                    dot.classList.remove('bg-gray-900', 'scale-125');
                                    dot.classList.add('bg-gray-400');
                                }
                            });
                        }

                        function nextSlide() {
                            currentIndex = (currentIndex + 1) % totalSlides;
                            updateSlidePosition();
                            resetAutoPlay();
                        }

                        function prevSlide() {
                            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                            updateSlidePosition();
                            resetAutoPlay();
                        }

                        function goToSlide(index) {
                            if (index >= 0 && index < totalSlides) {
                                currentIndex = index;
                                updateSlidePosition();
                                resetAutoPlay();
                            }
                        }

                        function resetAutoPlay() {
                            if (autoPlayInterval) clearInterval(autoPlayInterval);
                            autoPlayInterval = setInterval(() => nextSlide(), AUTO_PLAY_DELAY);
                        }

                        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
                        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
                        
                        dots.forEach(dot => {
                            dot.addEventListener('click', (e) => {
                                const index = parseInt(dot.getAttribute('data-index'), 10);
                                if (!isNaN(index)) goToSlide(index);
                            });
                        });
                        
                        updateSlidePosition();
                        resetAutoPlay();
                        
                        const carouselWrapper = document.querySelector('#view-slides .relative');
                        if (carouselWrapper) {
                            carouselWrapper.addEventListener('mouseenter', () => {
                                if (autoPlayInterval) clearInterval(autoPlayInterval);
                            });
                            carouselWrapper.addEventListener('mouseleave', () => {
                                resetAutoPlay();
                            });
                        }
                        
                        window.slideshowController = {
                            refresh: updateSlidePosition,
                            goTo: goToSlide
                        };
                    }
                    
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initSlideshow);
                    } else {
                        initSlideshow();
                    }
                })();
            </script>

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
                    if (existing.quantity >= product.stock) {
                        alert(`Only ${product.stock} unit(s) left in stock for ${product.name}.`);
                        return;
                    }
                    existing.quantity++;
                } else {
                    if (product.stock <= 0) {
                        alert(`${product.name} is out of stock.`);
                        return;
                    }
                    this.state.cart.push({ ...product, quantity: 1 });
                }
                this.renderCart();
                this.toggleCart(true);
            },

            updateQuantity(id, delta) {
                const item = this.state.cart.find(i => i.id === id);
                if (item) {
                    if (delta > 0 && item.quantity + delta > item.stock) {
                        alert(`Only ${item.stock} unit(s) left in stock for ${item.name}.`);
                        return;
                    }
                    item.quantity += delta;
                    if (item.quantity <= 0) {
                        this.state.cart = this.state.cart.filter(i => i.id !== id);
                    }
                }
                this.renderCart();
            },

            viewProduct(product) {
                this.state.selectedProduct = product;
                const isOutOfStock = product.stock <= 0;
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
                            <p class="text-sm text-gray-500">${product.stock > 0 ? `${product.stock} in stock` : 'Out of stock'}</p>
                            <p class="text-lg text-gray-600 leading-relaxed">${product.description}</p>
                            <button onclick='app.addToCart(${JSON.stringify(product)})' ${isOutOfStock ? 'disabled' : ''} class="w-full ${isOutOfStock ? 'bg-gray-300 cursor-not-allowed' : 'bg-black hover:bg-gray-800'} text-white py-5 rounded-2xl font-bold text-lg transition-all">
                                ${isOutOfStock ? 'Out of Stock' : 'Add to Shopping Cart'}
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
            },

            checkout() {
                if (this.state.cart.length === 0) {
                    alert('Your cart is empty');
                    return;
                }
                const cartData = JSON.stringify(this.state.cart);
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/payment/checkout';

                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = '{{ csrf_token() }}';
                form.appendChild(token);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cart';
                input.value = cartData;
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();
            }
        };

        window.onload = () => app.init();
    </script>
</body>
</html>