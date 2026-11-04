<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CapturedPokemon extends Model
{
    use HasFactory;

    protected $table = 'captured_pokemons';

    protected $fillable = [
        'user_id',
        'pokeapi_id',
        'name',
        'nickname',
        'level',
        'category',
        'gender',
        'height',
        'weight',
        'sprite_url',
        'types',
        'weaknesses',
        'hp',
        'attack',
        'defense',
        'special_attack',
        'special_defense',
        'speed',
        'pokeball_type',
        'is_favorite',
        'is_shiny',
    ];

    protected $casts = [
        'types' => 'array',
        'weaknesses' => 'array',
        'is_favorite' => 'boolean',
        'is_shiny' => 'boolean',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'hp' => 'integer',
        'attack' => 'integer',
        'defense' => 'integer',
        'special_attack' => 'integer',
        'special_defense' => 'integer',
        'speed' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
