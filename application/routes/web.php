<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\DrawController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('player.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::any('/player/delete/{id}', [PlayerController::class, 'delete'])->name('player.delete');
Route::resource('player', PlayerController::class);

Route::any('/draw/delete/{id}', [DrawController::class, 'delete'])->name('draw.delete');
Route::resource('draw', DrawController::class);
Route::any('/draw/store', [DrawController::class, 'store'])->name('draw.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
