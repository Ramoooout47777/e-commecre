<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-900">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $statCards = [
                        ['label' => 'Products',   'value' => $stats['products'],    'sub' => $stats['active_products'].' active', 'route' => 'products.index',   'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                        ['label' => 'Categories', 'value' => $stats['categories'],  'sub' => 'all categories',                    'route' => 'categories.index', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                        ['label' => 'Users',      'value' => $stats['users'],       'sub' => 'registered',                        'route' => 'users.index',      'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0'],
                        ['label' => 'Orders',     'value' => $stats['orders'] ?? 0, 'sub' => 'total orders',                      'route' => null,               'icon' => 'M3 7h18M3 12h18M3 17h18'],
                    ];
                @endphp

                @foreach($statCards as $card)
                    @if($card['route'])
                    <a href="{{ route($card['route']) }}"
                       class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow group">
                    @else
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    @endif
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $card['label'] }}</p>
                                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $card['value'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $card['sub'] }}</p>
                            </div>
                            <div class="bg-gray-900 text-white p-2.5 rounded-xl shrink-0 {{ $card['route'] ? 'group-hover:bg-black transition-colors' : '' }}">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                    @if($card['route'])
                    </a>
                    @else
                    </div>
                    @endif
                @endforeach

                {{-- Low Stock --}}
                <div class="{{ $stats['low_stock'] > 0 ? 'bg-red-50 border-red-200' : 'bg-white border-gray-200' }} rounded-xl border shadow-sm p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold {{ $stats['low_stock'] > 0 ? 'text-red-500' : 'text-gray-500' }} uppercase tracking-wider">Low Stock</p>
                            <p class="text-3xl font-extrabold {{ $stats['low_stock'] > 0 ? 'text-red-600' : 'text-gray-900' }} mt-1">{{ $stats['low_stock'] }}</p>
                            <p class="text-xs {{ $stats['low_stock'] > 0 ? 'text-red-400' : 'text-gray-500' }} mt-1">≤ 5 units left</p>
                        </div>
                        <div class="{{ $stats['low_stock'] > 0 ? 'bg-red-500' : 'bg-gray-900' }} text-white p-2.5 rounded-xl shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Featured Products + Recent Orders --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900">Featured Products</h3>
                        <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">View all →</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recent_products as $product)
                        <div class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-[9px]">IMG</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400">{{ $product->category?->name ?? '—' }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                             {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-10 text-center text-sm text-gray-400">No products yet.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900">Recent Orders</h3>
                        <span class="text-sm text-gray-400">Latest purchases</span>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recent_orders as $order)
                        <div class="flex items-center gap-4 px-6 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 shrink-0">
                                #{{ $order->id }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $order->name }}</p>
                                <p class="text-xs text-gray-400">{{ str_replace('_', ' ', ucfirst($order->payment_method)) }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-bold text-gray-900">${{ number_format($order->total, 2) }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                             {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-10 text-center text-sm text-gray-400">No recent orders yet.</div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Quick Links --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach([
                    ['route' => 'products.create',   'label' => 'Add Product'],
                    ['route' => 'categories.create', 'label' => 'Add Category'],
                    ['route' => 'users.create',      'label' => 'Add User'],
                    ['route' => 'roles.create',      'label' => 'Add Role'],
                    ['route' => 'slides.create',     'label' => 'Add Slide'],
                ] as $action)
                <a href="{{ route($action['route']) }}"
                   class="flex items-center gap-3 bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4
                          hover:shadow-md transition-all hover:-translate-y-0.5">
                    <div class="w-8 h-8 bg-gray-900 text-white rounded-lg flex items-center justify-center text-sm font-bold shrink-0">+</div>
                    <span class="text-sm font-semibold text-gray-900">{{ $action['label'] }}</span>
                </a>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>