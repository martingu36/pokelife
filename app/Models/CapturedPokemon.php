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
        'types',
        'sprite_url',
        'level',
        'pokeball_type',
        'is_favorite',
        'captured_at',
    ];

    protected function casts(): array
    {
        return [
            'is_favorite' => 'boolean',
            'captured_at' => 'datetime',
            'level' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
