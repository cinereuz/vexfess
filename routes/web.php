<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenfessController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController; // 👈 TAMBAHKAN INI

// --- GUEST ROUTES (Belum Login) ---
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- AUTH ROUTES (Sudah Login) ---
Route::middleware('auth')->group(function() {
    // Halaman Utama Menfess
    Route::get('/', [MenfessController::class, 'index'])->name('home');
    
    // Aksi Menfess
    Route::post('/send', [MenfessController::class, 'store'])
        ->middleware('throttle:5,1') 
        ->name('menfess.store');
        
    Route::post('/menfess/{id}/like', [MenfessController::class, 'like'])->name('menfess.like');

    // 👇 Profile Routes (Sekarang lebih bersih)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});



// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    Route::get('/', [MenfessController::class, 'admin'])->name('admin.index');
    Route::patch('/approve/{id}', [MenfessController::class, 'approve'])->name('admin.approve');
    Route::delete('/reject/{id}', [MenfessController::class, 'reject'])->name('admin.reject');
});