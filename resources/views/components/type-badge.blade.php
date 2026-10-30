@props(['types'])

@php
    $typeList = array_map('trim', explode('/', strtolower($types)));
    $colors = [
        'normal' => 'bg-neutral-500 text-white',
        'fire' => 'bg-orange-600 text-white',
        'fuego' => 'bg-orange-600 text-white',
        'water' => 'bg-blue-600 text-white',
        'agua' => 'bg-blue-600 text-white',
        'grass' => 'bg-emerald-600 text-white',
        'planta' => 'bg-emerald-600 text-white',
        'electric' => 'bg-amber-400 text-slate-900',
        'eléctrico' => 'bg-amber-400 text-slate-900',
        'ice' => 'bg-cyan-400 text-slate-900',
        'hielo' => 'bg-cyan-400 text-slate-900',
        'fighting' => 'bg-red-700 text-white',
        'lucha' => 'bg-red-700 text-white',
        'poison' => 'bg-purple-600 text-white',
        'veneno' => 'bg-purple-600 text-white',
        'ground' => 'bg-amber-700 text-white',
        'tierra' => 'bg-amber-700 text-white',
        'flying' => 'bg-indigo-400 text-white',
        'volador' => 'bg-indigo-400 text-white',
        'psychic' => 'bg-pink-600 text-white',
        'psíquico' => 'bg-pink-600 text-white',
        'bug' => 'bg-lime-600 text-white',
        'bicho' => 'bg-lime-600 text-white',
        'rock' => 'bg-stone-600 text-white',
        'roca' => 'bg-stone-600 text-white',
        'ghost' => 'bg-purple-800 text-white',
        'fantasma' => 'bg-purple-800 text-white',
        'dragon' => 'bg-violet-700 text-white',
        'dragón' => 'bg-violet-700 text-white',
        'steel' => 'bg-slate-500 text-white',
        'acero' => 'bg-slate-500 text-white',
        'fairy' => 'bg-pink-400 text-slate-900',
        'hada' => 'bg-pink-400 text-slate-900',
    ];
@endphp

<div class="flex gap-1 flex-wrap">
    @foreach($typeList as $type)
        @php
            $bg = $colors[$type] ?? 'bg-slate-600 text-white';
        @endphp
        <span class="inline-flex items-center text-[10px] uppercase tracking-wider font-extrabold px-2.5 py-0.5 rounded-full {{ $bg }} shadow-sm">
            {{ $type }}
        </span>
    @endforeach
</div>