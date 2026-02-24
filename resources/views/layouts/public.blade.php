<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Career 180 — The Developer Learning Platform' }}</title>
    <meta name="description"
        content="{{ $description ?? 'Career 180 is the developer learning platform built to ship. Structured courses, HD screencasts, and progress tracking — go from curious to confident.' }}">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=bricolage-grotesque:400,500,600,700,800&family=dm-sans:300,400,500,600,700&display=swap"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    @yield('head')
</head>

<body x-data class="public-body">
    @include('partials.public.header')

    <main>
        @yield('content')
    </main>

    @include('partials.public.footer')

    @livewireScripts
    @stack('scripts')
</body>

</html>
