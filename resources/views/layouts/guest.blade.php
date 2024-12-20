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

<body class="font-sans text-gray-900 antialiased bg-white">
    <div class="hero min-h-screen">
        <div class="hero-content flex-col lg:flex-row">
            <div class="text-center lg:text-left">
                <h1 class="text-5xl font-bold mb-3 flex items-center space-x-4">
                    <span>Login ke</span>
                    <x-application-logo
                        class="w-16 h-16 md:w-24 md:h-24 lg:w-32 lg:h-32 rounded-lg fill-current text-gray-500" />
                </h1>
                <p class="py-3 hidden md:block">
                    {{ $tag_line ?? 'Untuk melanjutkan ke Kapays, silahkan login terlebih dahulu menggunakan akun Google Anda.' }}
                </p>
            </div>
            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>