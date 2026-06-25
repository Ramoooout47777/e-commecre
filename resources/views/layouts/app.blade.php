<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="flex h-screen overflow-hidden">

    {{-- ── SIDEBAR ── --}}
    <aside class="w-64 shrink-0 bg-gray-900 border-r border-gray-800 flex flex-col h-screen sticky top-0">
        @include('layouts.navigation')
    </aside>

    {{-- ── MAIN ── --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        {{-- Page Header --}}
        @if(isset($header))
        <header class="bg-white border-b border-gray-200 px-8 py-4 shrink-0 flex items-center justify-between">
            {{ $header }}
            <span class="text-sm text-gray-400">
                Welcome back, <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span>
            </span>
        </header>
        @endif

        {{-- Page Content --}}
        <main class="flex-1">
            {{ $slot }}
        </main>

    </div>
</div>

</body>
</html>