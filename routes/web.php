<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenfessController;

// Halaman Utama
Route::get('/', [MenfessController::class, 'index'])->name('home');

// Kirim Pesan (Pakai Throttle biar ga disspam: max 5 pesan per 1 menit per IP)
Route::post('/send', [MenfessController::class, 'store'])
    ->middleware('throttle:5,1') 
    ->name('menfess.store');

Route::post('/menfess/{id}/like', [MenfessController::class, 'like'])->name('menfess.like');

// --- AREA ADMIN (RAHASIA) ---
// Kita pakai Basic Auth bawaan Laravel (Username & Password sederhana)
// Nanti login pakai email/pass yang ada di database users
Route::middleware(['auth.basic'])->prefix('admin')->group(function() {
    Route::get('/', [MenfessController::class, 'admin'])->name('admin.index');
    Route::patch('/approve/{id}', [MenfessController::class, 'approve'])->name('admin.approve');
    Route::delete('/reject/{id}', [MenfessController::class, 'reject'])->name('admin.reject');
});
