<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Career 180')</title>
    <meta name="description" content="@yield('description', 'Career 180 — Sign in or create your free account to start learning today.')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <div class="h-1 bg-teal-600"></div>
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <a href="{{ route('home') }}" class="text-xl font-black tracking-tight">
                Career<span class="text-teal-600">180</span>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center py-12 px-6">
        <div class="w-full max-w-md">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="max-w-7xl mx-auto px-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Career 180. All rights reserved.
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>

</html>
