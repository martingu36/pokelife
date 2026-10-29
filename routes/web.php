<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WildPokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('wild.index'))->name('dashboard');

    // Zona Salvaje
    Route::get('/wild', [WildPokemonController::class, 'index'])->name('wild.index');
    Route::post('/wild/catch', [WildPokemonController::class, 'catch'])->name('wild.catch');

    // Inventario
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::patch('/inventory/{pokemon}/nickname', [InventoryController::class, 'updateNickname'])->name('inventory.nickname');
    Route::patch('/inventory/{pokemon}/favorite', [InventoryController::class, 'toggleFavorite'])->name('inventory.favorite');
    Route::delete('/inventory/{pokemon}', [InventoryController::class, 'release'])->name('inventory.release');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
