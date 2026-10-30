@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 focus:border-poke-yellow dark:focus:border-poke-yellow focus:ring-poke-yellow dark:focus:ring-poke-yellow rounded-xl shadow-sm text-sm']) !!}>