<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/shorten', [LinkController::class, 'store'])
    ->name('shorten')
    ->middleware(['throttle:6,1']);
    
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [LinkController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/{short_code}', [LinkController::class, 'shortenLink'])->name('link.redirect');