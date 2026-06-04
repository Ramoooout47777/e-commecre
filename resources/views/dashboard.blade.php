<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-900">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('products.index') }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Products</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['products'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $stats['active_products'] }} active</p>
                        </div>
                        <div class="bg-gray-900 text-white p-2.5 rounded-xl group-hover:bg-black transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('categories.index') }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Categories</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['categories'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">all categories</p>
                        </div>
                        <div class="bg-gray-900 text-white p-2.5 rounded-xl group-hover:bg-black transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('users.index') }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Users</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['users'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">registered</p>
                        </div>
                        <div class="bg-gray-900 text-white p-2.5 rounded-xl group-hover:bg-black transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                        </div>
                    </div>
                </a>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Orders</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['orders'] ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-1">total orders</p>
                        </div>
                        <div class="bg-gray-900 text-white p-2.5 rounded-xl group-hover:bg-black transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>
                        </div>
                    </div>
                </div>

                <div class="{{ $stats['low_stock'] > 0 ? 'bg-red-50 border-red-200' : 'bg-white border-gray-200' }} rounded-xl border shadow-sm p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold {{ $stats['low_stock'] > 0 ? 'text-red-500' : 'text-gray-500' }} uppercase tracking-wider">Low Stock</p>
                            <p class="text-3xl font-extrabold {{ $stats['low_stock'] > 0 ? 'text-red-600' : 'text-gray-900' }} mt-1">{{ $stats['low_stock'] }}</p>
                            <p class="text-xs {{ $stats['low_stock'] > 0 ? 'text-red-400' : 'text-gray-500' }} mt-1">≤ 5 units left</p>
                        </div>
                        <div class="{{ $stats['low_stock'] > 0 ? 'bg-red-500' : 'bg-gray-900' }} text-white p-2.5 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900">Recent Products</h3>
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">View all →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recent_products as $product)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                                                @if($product->image)
                                                    <img src="{{ Storage::url($product->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-[9px] font-medium">IMG</div>
                                                @endif
                                            </div>
                                            <span class="font-semibold text-sm text-gray-900">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category?->name ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">${{ number_format($product->price, 2) }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($product->stock <= 5)
                                            <span class="text-red-600 font-medium">{{ $product->stock }}</span>
                                        @else
                                            <span class="text-gray-600">{{ $product->stock }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">No products yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900">Recent Orders</h3>
                    <span class="text-sm font-medium text-gray-500">Latest customer purchases</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Method</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recent_orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-900">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->name }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">${{ number_format($order->total, 2) }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ str_replace('_', ' ', ucfirst($order->payment_method)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">No recent orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('products.create') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4 hover:shadow-md transition-all hover:-translate-y-0.5">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600">+</div>
                    <span class="text-sm font-semibold text-gray-900">Add Product</span>
                </a>
                <a href="{{ route('categories.create') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4 hover:shadow-md transition-all hover:-translate-y-0.5">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600">+</div>
                    <span class="text-sm font-semibold text-gray-900">Add Category</span>
                </a>
                <a href="{{ route('users.create') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4 hover:shadow-md transition-all hover:-translate-y-0.5">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600">+</div>
                    <span class="text-sm font-semibold text-gray-900">Add User</span>
                </a>
                <a href="{{ route('roles.create') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-200 shadow-sm px-5 py-4 hover:shadow-md transition-all hover:-translate-y-0.5">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600">+</div>
                    <span class="text-sm font-semibold text-gray-900">Add Role</span>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
