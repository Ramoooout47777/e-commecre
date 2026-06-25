{{-- Sidebar Navigation Component --}}
{{-- Include inside <aside> in app.blade.php --}}

<div class="flex flex-col h-full">

    {{-- Logo --}}
    <div class="px-5 py-5 border-b border-gray-800 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
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
            <span class="text-white font-bold tracking-tight text-lg leading-none">
                MONACOSHOP. <span class="text-gray-400 font-normal text-sm">Admin</span>
            </span>
        </a>
    </div>

    {{-- Nav Links --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ request()->routeIs('dashboard') ? 'bg-white text-gray-900' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        {{-- ── Admin Management ── --}}
        {{-- <div class="pt-5 pb-1 px-3">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Admin Management</p>
        </div> --}}

        @php
            $adminLinks = [
                ['route' => 'products.index',    'match' => 'products.*',    'label' => 'Products',
                 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
                ['route' => 'categories.index',  'match' => 'categories.*',  'label' => 'Categories',
                 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                ['route' => 'roles.index',       'match' => 'roles.*',       'label' => 'Roles',
                 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['route' => 'permissions.index', 'match' => 'permissions.*', 'label' => 'Permissions',
                 'icon' => 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'],
                ['route' => 'slides.index',      'match' => 'slides.*',      'label' => 'Slides',
                 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ];
        @endphp

        @foreach($adminLinks as $link)
        <a href="{{ route($link['route']) }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ request()->routeIs($link['match']) ? 'bg-white text-gray-900' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/>
            </svg>
            {{ $link['label'] }}
        </a>
        @endforeach

        @can('view Users')
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ request()->routeIs('users.*') ? 'bg-white text-gray-900' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
            </svg>
            Users
        </a>
        @endcan

        {{-- ── Featured Products ── --}}
        <div class="pt-5 pb-1 px-3">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Featured Products</p>
        </div>

        <a href="{{ route('products.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  text-gray-400 hover:text-white hover:bg-gray-800">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            All Products
        </a>

        <a href="{{ route('products.create') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  text-gray-400 hover:text-white hover:bg-gray-800">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Product
        </a>

    </nav>

    {{-- User + Logout --}}
    <div class="px-3 py-4 border-t border-gray-800 shrink-0 space-y-1">
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition-colors">
            <div class="w-7 h-7 bg-white text-gray-900 rounded-full flex items-center justify-center font-bold text-xs uppercase shrink-0">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                           text-gray-500 hover:text-white hover:bg-gray-800 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Log Out
            </button>
        </form>
    </div>

</div>