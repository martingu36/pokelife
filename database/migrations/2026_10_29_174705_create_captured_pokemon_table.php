<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('captured_pokemons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('pokeapi_id');
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('types');
            $table->string('sprite_url');
            $table->integer('level');
            $table->string('pokeball_type');
            $table->boolean('is_favorite')->default(false);
            $table->timestamp('captured_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captured_pokemon');
    }
};
