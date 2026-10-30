<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2.5 bg-poke-red hover:bg-poke-darkred border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-poke-red focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition duration-150']) }}>
    {{ $slot }}
</button>