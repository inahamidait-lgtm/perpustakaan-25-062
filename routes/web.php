<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Controller Buku
use App\Http\Controllers\BukuController as WebBukuController;
use App\Http\Controllers\BukuCrudController;

// Controller Admin
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeminjamanController;

// Controller Petugas
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporanController;


// ROUTE PENGGUNA YANG SUDAH LOGIN
Route::middleware(['auth', 'verified'])->group(function () {

    // Route pengujian SQL Injection
    Route::get('/buku-cari', [WebBukuController::class, 'cari']);

    Route::get('/', function () {
    return view('home');
    })->name('home');

// ==========================
// ROUTE KELOLA BUKU (GATE)
// ==========================

// Tambah buku
Route::get('/buku/create', [BukuCrudController::class, 'create'])
    ->middleware('can:kelola-buku')
    ->name('admin.buku.create');

Route::post('/buku', [BukuCrudController::class, 'store'])
    ->middleware('can:kelola-buku')
    ->name('admin.buku.store');

    // Edit buku
    Route::get('/buku/{buku}/edit', [BukuCrudController::class, 'edit'])
    ->middleware('can:kelola-buku')
    ->name('admin.buku.edit');

    Route::put('/buku/{buku}', [BukuCrudController::class, 'update'])
    ->middleware('can:kelola-buku')
    ->name('admin.buku.update');

    Route::patch('/buku/{buku}', [BukuCrudController::class, 'update'])
    ->middleware('can:kelola-buku');

    // Hapus buku
    Route::delete('/buku/{buku}', [BukuCrudController::class, 'destroy'])
    ->middleware('can:kelola-buku')
    ->name('admin.buku.destroy');

    Route::get('/peminjaman/{id}', [\App\Http\Controllers\Siswa\PeminjamanController::class, 'show'])
    ->name('peminjaman.show');

    // DASHBOARD BERDASARKAN ROLE
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        if ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        abort(403, 'Role tidak ditemukan.');
    })->name('dashboard');


    // ==========================
    // ROUTE ADMIN
    // ==========================

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function () {

            // Dashboard Admin
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })
                ->middleware('permission:akses dashboard admin')
                ->name('dashboard');

            // Daftar Buku Admin
            Route::get('/buku', [BukuCrudController::class, 'index'])
                ->middleware('permission:kelola data buku')
                ->name('buku.index');

            // Kelola Pengguna
            Route::resource('users', UserController::class)
                ->except(['show'])
                ->middleware('permission:kelola data pengguna');


            // Kelola Role dan Permission
            Route::get('/role-permission', [RolePermissionController::class, 'index'])
                ->middleware('permission:kelola role pengguna')
                ->name('role-permission.index');

            Route::put('/role-permission/{role}', [RolePermissionController::class, 'update'])
                ->middleware('permission:kelola role pengguna')
                ->name('role-permission.update');

            // Peminjaman Admin
            Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])
                ->middleware('permission:kelola peminjaman')
                ->name('peminjaman.index');

            Route::patch('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'returnBook'])
                ->name('peminjaman.return')
                ->middleware('permission:kelola pengembalian');

            // Laporan Admin
            Route::get('/laporan', [AdminLaporanController::class, 'index'])
                ->middleware('permission:lihat laporan perpustakaan')
                ->name('laporan.index');

            Route::patch('/peminjaman/{id}/setujui', [PeminjamanController::class, 'approve'])
                ->name('peminjaman.approve')
                ->middleware('permission:kelola peminjaman');

            Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'reject'])
                ->name('peminjaman.reject')
                ->middleware('permission:kelola peminjaman');
        });


    // ==========================
    // ROUTE PETUGAS
    // ==========================

    Route::prefix('petugas')
        ->name('petugas.')
        ->middleware('role:petugas')
        ->group(function () {

            // Dashboard Petugas
            Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
                ->middleware('permission:akses dashboard petugas')
                ->name('dashboard');

            // Daftar Buku Petugas
            Route::get('/buku', [PetugasBukuController::class, 'index'])
                ->middleware('permission:lihat daftar buku')
                ->name('buku.index');

            Route::get('/peminjaman', [PetugasPeminjamanController::class, 'index'])
                ->name('peminjaman.index')
                ->middleware('permission:kelola peminjaman');

            Route::post('/peminjaman', [PetugasPeminjamanController::class, 'store'])
                ->name('peminjaman.store')
                ->middleware('permission:kelola peminjaman');

            Route::patch('/peminjaman/{id}/setujui', [PetugasPeminjamanController::class, 'approve'])
                ->name('peminjaman.approve')
                ->middleware('permission:kelola peminjaman');

            Route::patch('/peminjaman/{id}/tolak', [PetugasPeminjamanController::class, 'reject'])
                ->name('peminjaman.reject')
                ->middleware('permission:kelola peminjaman');

            // Pengembalian Petugas
            Route::get('/pengembalian', [PetugasPengembalianController::class, 'index'])
                ->name('pengembalian.index')
                ->middleware('permission:kelola pengembalian');

            Route::post('/pengembalian/{id}', [PetugasPengembalianController::class, 'store'])
                ->name('pengembalian.store')
                ->middleware('permission:kelola pengembalian');
            
            Route::patch('/peminjaman/{id}/kembalikan', [PetugasPeminjamanController::class, 'returnBook'])
                ->name('peminjaman.return')
                ->middleware('permission:kelola pengembalian');

            // Laporan Petugas
            Route::get('/laporan', [PetugasLaporanController::class, 'index'])
                ->middleware('permission:lihat laporan perpustakaan')
                ->name('laporan.index');
        });

    // ==========================
    // ROUTE SISWA
    // ==========================

    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })
        ->middleware('permission:akses dashboard siswa')
        ->name('dashboard');

    // Melihat riwayat peminjaman sendiri
    Route::get('/peminjaman', [App\Http\Controllers\Siswa\PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    // Mengajukan peminjaman buku
    Route::post('/peminjaman', [App\Http\Controllers\Siswa\PeminjamanController::class, 'store'])
        ->middleware('permission:mengajukan peminjaman buku')
        ->name('peminjaman.store');

    });

    // ==========================
    // ROUTE DAFTAR BUKU UMUM
    // ==========================

    Route::get('/buku', [WebBukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku')
        ->name('buku.index');

    Route::get('/buku/{id}', [WebBukuController::class, 'show'])
        ->middleware('permission:lihat daftar buku')
        ->name('buku.show');


    // ==========================
    // PROFILE
    // ==========================

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    
});

require __DIR__.'/auth.php';
