<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // route khusus Admin: CRUD users, tahun akademik, level, kelas, guru, siswa, reading coaching
});

Route::middleware(['auth', 'role:admin,operator'])->prefix('operator')->group(function () {
    // route yang boleh diakses Admin & Operator: CRUD level, kelas, reading coaching
});

Route::middleware(['auth', 'role:admin,operator,teacher'])->group(function () {
    // route yang boleh diakses semua role: Read data siswa, CRUD reading coaching
});
