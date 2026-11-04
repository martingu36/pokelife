<?php

namespace App\Http\Controllers;

use App\Models\CapturedPokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WildPokemonController extends Controller
{
    public function index()
    {
        if (! session()->has('wild_pokemon')) {
            session(['wild_pokemon' => $this->generateWildPokemon()]);
        }

        $wildPokemon = session('wild_pokemon');

        return view('wild.index', compact('wildPokemon'));
    }

    public function encounter()
    {
        session()->forget('wild_pokemon');
        session(['wild_pokemon' => $this->generateWildPokemon()]);
        session()->save();

        return redirect()->route('wild.index');
    }

    public function catch(Request $request)
    {
        $wild = session('wild_pokemon');
        if (! $wild) {
            return redirect()->route('wild.index');
        }

        $ballType = $request->input('ball_type', 'pokeball');
        $rates = [
            'pokeball' => 50,
            'greatball' => 70,
            'ultraball' => 85,
            'masterball' => 100,
        ];

        $chance = $rates[$ballType] ?? 50;
        $success = rand(1, 100) <= $chance;

        if ($success) {
            $captured = CapturedPokemon::create([
                'user_id' => auth()->id(),
                'pokeapi_id' => $wild['pokeapi_id'],
                'name' => $wild['name'],
                'nickname' => null,
                'level' => $wild['level'],
                'category' => $wild['category'],
                'gender' => $wild['gender'],
                'height' => $wild['height'],
                'weight' => $wild['weight'],
                'sprite_url' => $wild['sprite_url'],
                'types' => $wild['types'],
                'weaknesses' => $wild['weaknesses'],
                'hp' => $wild['hp'],
                'attack' => $wild['attack'],
                'defense' => $wild['defense'],
                'special_attack' => $wild['special_attack'],
                'special_defense' => $wild['special_defense'],
                'speed' => $wild['speed'],
                'pokeball_type' => $ballType,
                'is_favorite' => false,
                'is_shiny' => $wild['is_shiny'] ?? false,
            ]);

            session()->forget('wild_pokemon');

            return redirect()->route('wild.index')->with([
                'capture_success' => true,
                'captured_pokemon' => $captured,
            ]);
        }

        return redirect()->route('wild.index')->with('capture_failed', true);
    }

    private function generateWildPokemon(): array
    {
        $randomId = rand(1, 151);

        try {
            $response = Http::timeout(5)->get("https://pokeapi.co/api/v2/pokemon/{$randomId}");
            $data = $response->json();

            $speciesResponse = Http::timeout(5)->get("https://pokeapi.co/api/v2/pokemon-species/{$randomId}");
            $speciesData = $speciesResponse->json();

            $category = 'Desconocida';
            foreach ($speciesData['genera'] ?? [] as $genera) {
                if (($genera['language']['name'] ?? '') === 'es') {
                    $category = $genera['genus'];
                    break;
                }
            }

            $genderRate = $speciesData['gender_rate'] ?? -1;
            if ($genderRate === -1) {
                $gender = 'genderless';
            } else {
                $gender = (rand(1, 8) <= $genderRate) ? 'female' : 'male';
            }

            $types = [];
            foreach ($data['types'] ?? [] as $t) {
                if (isset($t['type']['name'])) {
                    $types[] = strtolower($t['type']['name']);
                }
            }

            $weaknesses = $this->calculateWeaknesses($types);
            $isShiny = rand(1, 100) === 1; // 1% de probabilidad Shiny

            $spriteUrl = $isShiny
                ? ($data['sprites']['other']['official-artwork']['front_shiny'] ?? $data['sprites']['front_shiny'] ?? '')
                : ($data['sprites']['other']['official-artwork']['front_default'] ?? $data['sprites']['front_default'] ?? '');

            return [
                'pokeapi_id' => $data['id'],
                'name' => ucfirst($data['name']),
                'level' => rand(3, 40),
                'category' => $category,
                'gender' => $gender,
                'height' => ($data['height'] ?? 10) / 10,
                'weight' => ($data['weight'] ?? 100) / 10,
                'sprite_url' => $spriteUrl,
                'types' => $types,
                'weaknesses' => $weaknesses,
                'hp' => $data['stats'][0]['base_stat'] ?? 50,
                'attack' => $data['stats'][1]['base_stat'] ?? 50,
                'defense' => $data['stats'][2]['base_stat'] ?? 50,
                'special_attack' => $data['stats'][3]['base_stat'] ?? 50,
                'special_defense' => $data['stats'][4]['base_stat'] ?? 50,
                'speed' => $data['stats'][5]['base_stat'] ?? 50,
                'is_shiny' => $isShiny,
            ];
        } catch (\Exception $e) {
            return [
                'pokeapi_id' => 25,
                'name' => 'Pikachu',
                'level' => 15,
                'category' => 'Pokémon Ratón',
                'gender' => 'male',
                'height' => 0.4,
                'weight' => 6.0,
                'sprite_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png',
                'types' => ['electric'],
                'weaknesses' => ['ground'],
                'hp' => 35,
                'attack' => 55,
                'defense' => 40,
                'special_attack' => 50,
                'special_defense' => 50,
                'speed' => 90,
                'is_shiny' => false,
            ];
        }
    }

    private function calculateWeaknesses(array $types): array
    {
        $weaknessMap = [
            'fire' => ['water', 'ground', 'rock'],
            'water' => ['electric', 'grass'],
            'grass' => ['fire', 'ice', 'poison', 'flying', 'bug'],
            'electric' => ['ground'],
            'normal' => ['fighting'],
            'ice' => ['fire', 'fighting', 'rock', 'steel'],
            'fighting' => ['flying', 'psychic', 'fairy'],
            'poison' => ['ground', 'psychic'],
            'ground' => ['water', 'grass', 'ice'],
            'flying' => ['electric', 'ice', 'rock'],
            'psychic' => ['bug', 'ghost', 'dark'],
            'bug' => ['fire', 'flying', 'rock'],
            'rock' => ['water', 'grass', 'fighting', 'ground', 'steel'],
            'ghost' => ['ghost', 'dark'],
            'dragon' => ['ice', 'dragon', 'fairy'],
            'steel' => ['fire', 'fighting', 'ground'],
            'fairy' => ['poison', 'steel'],
        ];

        $results = [];
        foreach ($types as $t) {
            if (isset($weaknessMap[$t])) {
                $results = array_merge($results, $weaknessMap[$t]);
            }
        }

        return array_values(array_unique($results));
    }
}
