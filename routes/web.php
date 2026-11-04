<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WildPokemonController;
use Illuminate\Support\Facades\Route; // Importar ProfileController

Route::get('/', function () {
    return redirect()->route('wild.index');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Aliases de compatibilidad
    Route::get('/dashboard', function () {
        return redirect()->route('wild.index');
    })->name('dashboard');

    Route::get('/home', function () {
        return redirect()->route('wild.index');
    })->name('home');

    // --- Gestión de Perfil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Zona Salvaje ---
    Route::get('/wild', [WildPokemonController::class, 'index'])->name('wild.index');
    Route::post('/wild/encounter', [WildPokemonController::class, 'encounter'])->name('wild.encounter');
    Route::post('/wild/catch', [WildPokemonController::class, 'catch'])->name('wild.catch');

    // --- Inventario / Colección ---
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::patch('/inventory/{pokemon}/nickname', [InventoryController::class, 'updateNickname'])->name('inventory.nickname');
    Route::patch('/inventory/{pokemon}/favorite', [InventoryController::class, 'toggleFavorite'])->name('inventory.favorite');
    Route::delete('/inventory/{pokemon}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

});

require __DIR__.'/auth.php';
