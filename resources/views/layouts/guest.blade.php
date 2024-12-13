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

<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col md:justify-center md:items-center mx-10 pt-6">
        <div>
            <a href="/">
                <x-application-logo class="w-16 h-16 rounded-lg fill-current text-gray-500" />
            </a>
            <h1 class="text-5xl font-bold pt-4">Kapays</h1>
            <p class="py-6 text-center mt-5">
                {{ $tag_line ?? '' }}
            </p>
        </div>

        {{$slot}}
    </div>
</body>

</html>