@props(['tag_line'])

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

<body class="font-sans text-gray-900 antialiased bg-blue-50">
<div class="hero min-h-screen">
    <div class="hero-content flex-col lg:flex-row">
        <div class="text-center lg:text-left -mt-32 md:mt-0 lg:mt-0">
            <x-application-logo class="w-32 h-32 md:w-32 md:h-32 lg:w-32 lg:h-32 rounded-lg fill-current text-gray-500 md:-ml-2 lg:-ml-2 mx-auto" />
            <h1 class="text-5xl font-bold mb-3 -mt-3">Login Kapays!</h1>
            <p class="py-3 mx-16 md:mx-0 lg:mx-0">
                {{ $tag_line ?? 'Untuk melanjutkan Kapays, silahkan login terlebih dahulu menggunakan akun Google Anda.' }}
            </p>
        </div>
        <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
            {{ $slot }}
        </div>
    </div>
</div>
</body>

</html>