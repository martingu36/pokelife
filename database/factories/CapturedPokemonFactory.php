<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CapturedPokemonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'pokeapi_id' => rand(1, 151),
            'name' => fake()->word(),
            'nickname' => fake()->firstName(),
            'types' => 'Electric',
            'sprite_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png',
            'level' => rand(1, 100),
            'pokeball_type' => 'pokeball',
            'is_favorite' => false,
            'captured_at' => now(),
        ];
    }
}
