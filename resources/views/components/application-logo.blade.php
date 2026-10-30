<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    <img src="{{ asset('img/logo.png') }}" 
         alt="PokeLife Logo" 
         class="h-10 w-auto object-contain drop-shadow hover:scale-105 transition-transform">
    <span class="font-pixel text-sm font-bold text-slate-900 dark:text-white tracking-tight">
        POKE<span class="text-poke-red">LIFE</span>
    </span>
</div>