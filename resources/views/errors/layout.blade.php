<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? $exception->getStatusCode() }} - Career 180</title>
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=bricolage-grotesque:400,500,600,700,800&family=dm-sans:300,400,500,600,700&display=swap"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="public-body bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                    @switch($exception->getStatusCode())
                        @case(401)
                            <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            @break
                        @case(403)
                            <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @break
                        @case(404)
                            <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @break
                        @case(419)
                            <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            @break
                        @default
                            <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                    @endswitch
                </div>
            </div>

            <h1 class="text-6xl font-bold text-gray-900 mb-4 font-[Bricolage-Grotesque]">{{ $exception->getStatusCode() }}</h1>

            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                @switch($exception->getStatusCode())
                    @case(401)
                        Unauthorized
                    @break
                    @case(403)
                        Access Denied
                    @break
                    @case(404)
                        Page Not Found
                    @break
                    @case(419)
                        Page Expired
                    @break
                    @case(429)
                        Too Many Requests
                    @break
                    @case(500)
                        Server Error
                    @break
                    @default
                        Something Went Wrong
                @endswitch
            </h2>

            <p class="text-gray-500 mb-8">
                @switch($exception->getStatusCode())
                    @case(401)
                        Please log in to access this page.
                    @break
                    @case(403)
                        @if(isset($exception) && method_exists($exception, 'getMessage') && $exception->getMessage())
                            {{ $exception->getMessage() }}
                        @else
                            You don't have permission to access this page.
                        @endif
                    @break
                    @case(404)
                        The page you're looking for doesn't exist or has been moved.
                    @break
                    @case(419)
                        Your session has expired. Please refresh the page and try again.
                    @break
                    @case(429)
                        Too many requests. Please wait a moment and try again.
                    @break
                    @case(500)
                        Something went wrong on our end. Please try again later.
                    @break
                    @default
                        An unexpected error occurred.
                @endswitch
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Go Back
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-500 hover:bg-indigo-600 transition-colors">
                    Go Home
                </a>
            </div>
        </div>
    </div>
</body>

</html>
