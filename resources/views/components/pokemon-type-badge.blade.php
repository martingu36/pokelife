@props(['type'])

@php
$typeName = strtolower(trim((string)$type));

// Mapeo oficial de IDs en PokeAPI
$typeIds = [
    'normal'   => 1,
    'fighting' => 2,
    'flying'   => 3,
    'poison'   => 4,
    'ground'   => 5,
    'rock'     => 6,
    'bug'      => 7,
    'ghost'    => 8,
    'steel'    => 9,
    'fire'     => 10,
    'water'    => 11,
    'grass'    => 12,
    'electric' => 13,
    'psychic'  => 14,
    'ice'      => 15,
    'dragon'   => 16,
    'dark'     => 17,
    'fairy'    => 18,
];

$translations = [
    'normal' => 'Normal', 'fire' => 'Fuego', 'water' => 'Agua', 'grass' => 'Planta',
    'electric' => 'Eléctrico', 'ice' => 'Hielo', 'fighting' => 'Lucha', 'poison' => 'Veneno',
    'ground' => 'Tierra', 'flying' => 'Volador', 'psychic' => 'Psíquico', 'bug' => 'Bicho',
    'rock' => 'Roca', 'ghost' => 'Fantasma', 'dragon' => 'Dragón', 'dark' => 'Siniestro',
    'steel' => 'Acero', 'fairy' => 'Hada'
];

$typeId = $typeIds[$typeName] ?? 1;
$displayName = $translations[$typeName] ?? ucfirst($typeName);

// Sprite oficial Generación V (Blanco y Negro)
$iconUrl = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/types/generation-v/black-white/{$typeId}.png";
@endphp

<span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-900/60 border border-slate-700/60 shadow-sm backdrop-blur-sm">
    <img 
        src="{{ $iconUrl }}" 
        alt="{{ $displayName }}" 
        class="h-5 w-auto object-contain [image-rendering:pixelated] filter drop-shadow" 
        onerror="this.style.display='none'"
    >
    <span class="text-slate-200 font-pixel text-[9px]">{{ $displayName }}</span>
</span>