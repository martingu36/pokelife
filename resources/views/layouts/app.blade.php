<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PokeLife') }}</title>
    <link rel="icon" type="image/png" href="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Press+Start+2P&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-900 text-slate-100 min-h-screen flex flex-col">
    <!-- Navbar Rojo -->
    @include('layouts.navigation')

    <!-- Encabezado opcional de página -->
    @isset($header)
        <header class="bg-slate-800/80 border-b border-slate-700 shadow-md">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Contenido Principal -->
    <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>
</body>
</html>