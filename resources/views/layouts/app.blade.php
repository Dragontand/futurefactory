<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased text-gray-900 dark:text-gray-300">
        <div class="min-h-screen min-w-fit bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 sm:flex sm:justify-between items-center min-h-[5.5rem]">
                    {{ $header }}
                </div>
            </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="py-6">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        @if (session('success') || session('error'))
                            <div class="fixed top-0 left-0 right-0 z-50 flex justify-center p-4 pointer-events-none">
                                <div class="px-6 py-3 rounded-lg shadow-lg pointer-events-auto {{ session('success') ? 'bg-green-800 text-green-200' : 'bg-red-800 text-red-200' }}">
                                    {{ session('success') ?? session('error') }}
                                </div>
                            </div>
                        @endif
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </body>

</html>