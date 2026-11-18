<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

// Semua pengguna yang sudah login boleh melihat daftar dan detail buku
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/buku', [BukuController::class, 'index']);
    Route::get('/buku/{buku}', [BukuController::class, 'show']);

    // Hanya pengguna yang memiliki izin kelola data buku
    // yaitu Admin dan Petugas
    Route::middleware('permission:kelola data buku')->group(function () {

        Route::post('/buku', [BukuController::class, 'store']);
        Route::put('/buku/{buku}', [BukuController::class, 'update']);
        Route::patch('/buku/{buku}', [BukuController::class, 'update']);
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy']);

    });

    // Endpoint rekap
    Route::get(
        '/rekap/buku-per-kategori',
        [RekapController::class, 'bukuPerKategori']
    );

    Route::get(
        '/rekap/peminjaman-per-buku',
        [RekapController::class, 'peminjamanPerBuku']
    );

});