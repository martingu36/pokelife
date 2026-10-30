<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PokeLife - ¡Comienza tu Aventura Pokémon!</title>

    <!-- Favicon con tu nuevo logo -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Press+Start+2P&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between font-sans antialiased">

    <!-- Header Rojo -->
    <header class="bg-poke-red border-b-4 border-slate-950 shadow-lg py-4 px-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <x-application-logo />
        </div>
    </header>

    <!-- Contenido Principal con Logo Hero -->
    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 py-10 max-w-4xl mx-auto space-y-8">

        <!-- Tarjeta Hero con Logo Ajustado -->
        <div class="relative group">
            <div
                class="absolute -inset-1 bg-gradient-to-r from-poke-red via-poke-yellow to-poke-red rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500">
            </div>

            <div
                class="relative bg-slate-800/90 border-2 border-poke-red/60 rounded-2xl p-5 sm:p-6 shadow-2xl flex flex-col items-center backdrop-blur-sm">
                <img src="{{ asset('img/logo.png') }}" alt="PokeLife Hero Logo"
                    class="h-16 sm:h-24 w-auto max-w-xs object-contain drop-shadow-[0_8px_16px_rgba(238,21,21,0.3)] group-hover:scale-105 transition duration-300">
            </div>
        </div>

        <div class="space-y-4">
            <h1 class="font-pixel text-2xl sm:text-4xl text-poke-yellow leading-relaxed drop-shadow-lg">
                ¡TU AVENTURA POKÉMON EMPIEZA AQUÍ!
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
    ¡Acepta el desafío y adéntrate en la zona salvaje! Captura criaturas únicas, pon a prueba tu estrategia con distintas Pokéballs, personaliza a tus compañeros y construye el equipo de 6 favoritos que te llevará a la cima.
</p>
        </div>

        <!-- Botones de Acción -->
        <div class="flex flex-col sm:flex-row gap-4 w-full max-w-sm justify-center pt-2">
            <a href="{{ route('register') }}"
                class="font-pixel text-xs bg-poke-red hover:bg-poke-darkred text-white py-4 px-6 rounded-2xl font-bold shadow-xl transition text-center border-2 border-red-500">
                CREAR CUENTA
            </a>
            <a href="{{ route('login') }}"
                class="font-pixel text-xs bg-slate-800 hover:bg-slate-700 text-slate-200 py-4 px-6 rounded-2xl font-bold shadow-xl transition text-center border border-slate-700">
                INICIAR SESIÓN
            </a>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800 py-4 text-center text-[10px] text-slate-500 font-pixel">
        PokeLife &copy; {{ date('Y') }} - CI/CD
    </footer>
</body>

</html>
