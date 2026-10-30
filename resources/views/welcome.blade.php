<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PokeLife - ¡Conviértete en el mejor Entrenador!</title>
    <link rel="icon" type="image/png" href="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Press+Start+2P&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between font-sans antialiased">

    <!-- Header Rojo -->
    <header class="bg-poke-red border-b-4 border-slate-950 shadow-lg py-4 px-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <x-application-logo />
            <div>
                @auth
                    <a href="{{ route('wild.index') }}" class="font-pixel text-xs bg-poke-yellow text-slate-900 px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition shadow">
                        Ir a la Zona Salvaje
                    </a>
                @else
                    <a href="{{ route('login') }}" class="font-pixel text-xs text-white hover:underline mr-4">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="font-pixel text-xs bg-slate-900 text-white px-3 py-2 rounded border border-slate-700 hover:bg-slate-800 transition">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Content -->
    <main class="flex-1 flex flex-col items-center justify-center text-center px-4 py-12">
        <div class="max-w-3xl space-y-6">
            <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/ultra-ball.png" alt="Ultra Ball" class="w-24 h-24 mx-auto drop-shadow-xl hover:rotate-12 transition">
            
            <h1 class="font-pixel text-2xl sm:text-4xl text-poke-yellow leading-relaxed drop-shadow">
                ¡BIENVENIDO A POKELIFE!
            </h1>
            
            <p class="text-slate-300 text-base sm:text-lg max-w-xl mx-auto">
                Explora la zona salvaje, descubre especímenes únicos con PokeAPI y prueba tu suerte capturándolos con Pokéballs, Superballs, Ultraballs o Masterballs.
            </p>

            <div class="pt-6 flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('wild.index') }}" class="font-pixel text-xs bg-poke-red hover:bg-poke-darkred text-white px-6 py-4 rounded-xl font-bold shadow-lg transition">
                        🌲 EXPEDICIÓN SALVAJE
                    </a>
                    <a href="{{ route('inventory.index') }}" class="font-pixel text-xs bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 px-6 py-4 rounded-xl font-bold shadow-lg transition">
                        🎒 VER INVENTARIO
                    </a>
                @else
                    <a href="{{ route('register') }}" class="font-pixel text-xs bg-poke-red hover:bg-poke-darkred text-white px-6 py-4 rounded-xl font-bold shadow-lg transition">
                        🎮 CREAR CUENTA
                    </a>
                    <a href="{{ route('login') }}" class="font-pixel text-xs bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 px-6 py-4 rounded-xl font-bold shadow-lg transition">
                        🔑 INICIAR SESIÓN
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800 py-4 text-center text-xs text-slate-500 font-pixel">
        PokeLife &copy; {{ date('Y') }} - CI/CD Proyecto DAW
    </footer>
</body>
</html>