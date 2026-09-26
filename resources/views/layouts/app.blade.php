<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
            <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

                       <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

                        <footer class="mt-auto bg-white border-t border-gray-200">
                <!-- Harvest-gold accent line -->
                <div class="h-1 bg-gradient-to-r from-primary-600 via-accent-500 to-primary-600"></div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center">

                    <!-- Partnership line -->
                    <p class="text-sm text-gray-500">In partnership with the</p>
                    <p class="text-base font-semibold text-primary-700">
                        Office of the Municipal Agriculturist
                    </p>
                    <p class="text-sm text-gray-500">San Jose, Camarines Sur</p>

                    <!-- Contact details -->
                    <div class="mt-5 flex flex-wrap justify-center gap-x-8 gap-y-3 text-sm text-gray-600">

                        <!-- Address -->
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Municipal Hall, San Jose, Camarines Sur
                        </span>

                        <!-- Phone (TODO: replace XXX with real number) -->
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            XXX
                        </span>

                        <!-- Email (TODO: replace sample email with the real one) -->
                        <a href="mailto:mao.sanjose@example.com" class="inline-flex items-center gap-2 hover:text-primary-700">
                            <svg class="h-4 w-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            mao.sanjose@example.com
                        </a>

                        <!-- Office hours -->
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Monday–Friday, 8:00 AM – 5:00 PM
                        </span>
                    </div>

                    <!-- Divider + copyright -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-400">
                            &copy; {{ date('Y') }} TERESA — San Jose, Camarines Sur. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
