@props(['type'])

@php
$typeName = strtolower(trim((string)$type));

$typeStyles = [
    'normal'   => ['name' => 'NORMAL',   'bg' => 'bg-[#A8A878]', 'border' => 'border-[#6D6D4E]'],
    'fire'     => ['name' => 'FUEGO',    'bg' => 'bg-[#F08030]', 'border' => 'border-[#9C521F]'],
    'water'    => ['name' => 'AGUA',     'bg' => 'bg-[#6890F0]', 'border' => 'border-[#445E9C]'],
    'grass'    => ['name' => 'PLANTA',   'bg' => 'bg-[#78C850]', 'border' => 'border-[#4E8234]'],
    'electric' => ['name' => 'ELÉCTRICO','bg' => 'bg-[#F8D030]', 'border' => 'border-[#A1871F]'],
    'ice'      => ['name' => 'HIELO',    'bg' => 'bg-[#98D8D8]', 'border' => 'border-[#638D8D]'],
    'fighting' => ['name' => 'LUCHA',    'bg' => 'bg-[#C03028]', 'border' => 'border-[#7D1F1A]'],
    'poison'   => ['name' => 'VENENO',   'bg' => 'bg-[#A040A0]', 'border' => 'border-[#682968]'],
    'ground'   => ['name' => 'TIERRA',   'bg' => 'bg-[#E0C068]', 'border' => 'border-[#927D44]'],
    'flying'   => ['name' => 'VOLADOR',  'bg' => 'bg-[#A890F0]', 'border' => 'border-[#6D5E9C]'],
    'psychic'  => ['name' => 'PSÍQUICO', 'bg' => 'bg-[#F85888]', 'border' => 'border-[#A13959]'],
    'bug'      => ['name' => 'BICHO',    'bg' => 'bg-[#A8B820]', 'border' => 'border-[#6D7815]'],
    'rock'     => ['name' => 'ROCA',     'bg' => 'bg-[#B8A038]', 'border' => 'border-[#786824]'],
    'ghost'    => ['name' => 'FANTASMA', 'bg' => 'bg-[#705898]', 'border' => 'border-[#493963]'],
    'dragon'   => ['name' => 'DRAGÓN',   'bg' => 'bg-[#7038F8]', 'border' => 'border-[#4924A1]'],
    'dark'     => ['name' => 'SINIESTRO','bg' => 'bg-[#705848]', 'border' => 'border-[#49392F]'],
    'steel'    => ['name' => 'ACERO',    'bg' => 'bg-[#B8B8D0]', 'border' => 'border-[#787888]'],
    'fairy'    => ['name' => 'HADA',     'bg' => 'bg-[#EE99AC]', 'border' => 'border-[#9B6470]'],
];

$style = $typeStyles[$typeName] ?? ['name' => strtoupper($typeName), 'bg' => 'bg-slate-600', 'border' => 'border-slate-800'];
@endphp

<span class="inline-block px-2 py-0.5 rounded text-[9px] font-pixel text-white uppercase tracking-wider border shadow-sm drop-shadow-sm {{ $style['bg'] }} {{ $style['border'] }}">
    {{ $style['name'] }}
</span>