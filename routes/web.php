<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WildPokemonController;
use Illuminate\Support\Facades\Route;

// Vista de Bienvenida pública
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', HomeController::class)->name('home');
    Route::get('/dashboard', fn () => redirect()->route('home'))->name('dashboard');

    // Zona Salvaje
    Route::get('/wild', [WildPokemonController::class, 'index'])->name('wild.index');
    Route::post('/wild/catch', [WildPokemonController::class, 'catch'])->name('wild.catch');

    // Inventario y Captura Exitosa
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/{pokemon}/success', [InventoryController::class, 'captured'])->name('inventory.success');
    Route::patch('/inventory/{pokemon}/nickname', [InventoryController::class, 'updateNickname'])->name('inventory.nickname');
    Route::patch('/inventory/{pokemon}/favorite', [InventoryController::class, 'toggleFavorite'])->name('inventory.favorite');
    Route::delete('/inventory/{pokemon}', [InventoryController::class, 'release'])->name('inventory.release');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
