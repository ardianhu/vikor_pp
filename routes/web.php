<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesantrenController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VikorController;
use App\Livewire\PesantrenDetail;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/pesantren/{id}', [PesantrenController::class, 'show'])->name('pesantren.show');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/pesantren', [PesantrenController::class, 'index'])->name('pesantrens.index');
Route::get('/rekomendasi', [VikorController::class, 'index'])->name('vikor.index');

require __DIR__ . '/auth.php';
