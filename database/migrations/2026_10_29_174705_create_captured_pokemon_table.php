<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('captured_pokemons');

        Schema::create('captured_pokemons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Identificación y datos estéticos
            $table->unsignedInteger('pokeapi_id')->index();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->unsignedInteger('level')->default(1);
            $table->string('category')->nullable();
            $table->string('gender')->nullable(); // male, female, genderless
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 6, 2)->nullable();
            $table->string('sprite_url');

            // Listas estructuradas
            $table->json('types');
            $table->json('weaknesses');

            // Estadísticas Base desglosadas
            $table->unsignedSmallInteger('hp')->default(1);
            $table->unsignedSmallInteger('attack')->default(1);
            $table->unsignedSmallInteger('defense')->default(1);
            $table->unsignedSmallInteger('special_attack')->default(1);
            $table->unsignedSmallInteger('special_defense')->default(1);
            $table->unsignedSmallInteger('speed')->default(1);

            // Estado dentro del juego
            $table->string('pokeball_type')->default('pokeball');
            $table->boolean('is_favorite')->default(false);
            $table->boolean('is_shiny')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('captured_pokemons');
    }
};
