<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\GameController;
use App\Models\Game;


Route::get('/', function () {
    $latestGames = Game::latest()->take(3)->get();
    return view('home', compact('latestGames'));
});

Route::get('/games', [GameController::class, 'index'])->name('games.index');

Route::get('/games/create', [GameController::class, 'create'])->name('games.create');

Route::post('/games', [GameController::class, 'store'])->name('games.store');

Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');

Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');

Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

