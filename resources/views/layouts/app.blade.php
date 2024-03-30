<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Windowlight') }} - {{ $title ?? 'Beautiful Code Screenshots' }}</title>

        <link rel="canonical" href="{{ $canonical }}" />
        <meta name="description" content="Windowlight is a simple wrapper for Torchlight, helping you to create beautiful code screenshots. Because your code screenshots deserve the same love as your documentation." />
        <meta name="author" content="Caen De Silva" />
        <meta name="robots" content="index, follow" />
        <meta name="keywords" content="Torchlight, Laravel, TailwindCSS, JavaScript, Code, Syntax Highlighting, Code Screenshot, Windowlight" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@CodeWithCaen" />
        <meta name="twitter:creator" content="@CodeWithCaen" />
        <meta name="twitter:title" content="Windowlight - Beautiful Code Screenshots" />
        <meta name="twitter:description" content="Windowlight is a simple wrapper for Torchlight, helping you to create beautiful code screenshots. Because your code screenshots deserve the same love as your documentation." />
        <meta name="twitter:image" content="{{ asset('og-image.png') }}" />
        <meta property="og:url" content="{{ $canonical }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Windowlight - Beautiful Code Screenshots" />
        <meta property="og:description" content="Windowlight is a simple wrapper for Torchlight, helping you to create beautiful code screenshots. Because your code screenshots deserve the same love as your documentation." />
        <meta property="og:image" content="{{ asset('og-image.png') }}" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:site_name" content="Windowlight" />
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
        <meta property="og:locale:alternate" content="en_US" />
        <meta property="og:locale:alternate" content="en_GB" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
