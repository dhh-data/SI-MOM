<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\RapatAkbarController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Departemen & Anggota
    Route::prefix('departemen')->name('departemen.')->group(function () {
        Route::get('/', [DepartemenController::class, 'index'])->name('index');
        Route::get('/anggota', [DepartemenController::class, 'anggota'])->name('anggota');
        Route::get('/proker', [DepartemenController::class, 'programKerja'])->name('proker');

        Route::middleware('role:admin')->group(function () {
            Route::get('/anggota/create', [DepartemenController::class, 'createAnggota'])->name('anggota.create');
            Route::post('/anggota', [DepartemenController::class, 'storeAnggota'])->name('anggota.store');
            Route::get('/anggota/{anggota}/edit', [DepartemenController::class, 'editAnggota'])->name('anggota.edit');
            Route::put('/anggota/{anggota}', [DepartemenController::class, 'updateAnggota'])->name('anggota.update');
            Route::delete('/anggota/{anggota}', [DepartemenController::class, 'destroyAnggota'])->name('anggota.destroy');
        });

        Route::middleware('role:admin,kepala_departemen,kepala_inventaris')->group(function () {
            Route::post('/proker', [DepartemenController::class, 'storeProker'])->name('proker.store');
            Route::put('/proker/{proker}', [DepartemenController::class, 'updateProker'])->name('proker.update');
            Route::delete('/proker/{proker}', [DepartemenController::class, 'destroyProker'])->name('proker.destroy');
        });
    });

    // Rapat Akbar
    Route::prefix('rapat')->name('rapat.')->group(function () {
        Route::get('/', [RapatAkbarController::class, 'index'])->name('index');

        // create & store HARUS di atas /{rapat}
        Route::middleware('role:admin')->group(function () {
            Route::get('/create', [RapatAkbarController::class, 'create'])->name('create');
            Route::post('/', [RapatAkbarController::class, 'store'])->name('store');
        });

        // Route dengan parameter di bawah
        Route::get('/{rapat}', [RapatAkbarController::class, 'show'])->name('show');
        Route::get('/{rapat}/presensi', [RapatAkbarController::class, 'presensi'])->name('presensi');
        Route::post('/{rapat}/presensi', [RapatAkbarController::class, 'isiPresensi'])->name('presensi.isi');
        Route::get('/{rapat}/notulensi', [RapatAkbarController::class, 'notulensi'])->name('notulensi');
        Route::post('/{rapat}/notulensi', [RapatAkbarController::class, 'storeNotulensi'])->name('notulensi.store');
        Route::post('/{rapat}/dokumentasi', [RapatAkbarController::class, 'storeDokumentasi'])->name('dokumentasi.store');

        Route::middleware('role:admin')->group(function () {
            Route::get('/{rapat}/edit', [RapatAkbarController::class, 'edit'])->name('edit');
            Route::put('/{rapat}', [RapatAkbarController::class, 'update'])->name('update');
            Route::delete('/{rapat}', [RapatAkbarController::class, 'destroy'])->name('destroy');
            Route::patch('/{rapat}/presensi/{presensi}', [RapatAkbarController::class, 'updatePresensiAdmin'])->name('presensi.update');
        });
    });

    // Inventaris
    Route::prefix('inventaris')->name('inventaris.')->group(function () {
        Route::get('/', [InventarisController::class, 'index'])->name('index');
        Route::get('/peminjaman', [InventarisController::class, 'peminjaman'])->name('peminjaman');

        Route::middleware('role:admin,kepala_departemen,kepala_inventaris')->group(function () {
            Route::get('/ajukan', [InventarisController::class, 'ajukanPeminjaman'])->name('ajukan');
            Route::post('/peminjaman', [InventarisController::class, 'storePeminjaman'])->name('peminjaman.store');
        });

        Route::middleware('role:admin,kepala_inventaris')->group(function () {
            Route::get('/create', [InventarisController::class, 'create'])->name('create');
            Route::post('/', [InventarisController::class, 'store'])->name('store');
            Route::post('/peminjaman/{peminjaman}/approval', [InventarisController::class, 'approvalPeminjaman'])->name('peminjaman.approval');
            Route::get('/{inventaris}/edit', [InventarisController::class, 'edit'])->name('edit');
            Route::put('/{inventaris}', [InventarisController::class, 'update'])->name('update');
            Route::delete('/{inventaris}', [InventarisController::class, 'destroy'])->name('destroy');
        });
    });

    // Berkas
    Route::prefix('berkas')->name('berkas.')->group(function () {
        Route::get('/', [BerkasController::class, 'index'])->name('index');

        // create HARUS di atas /{berkas}
        Route::middleware('role:admin')->group(function () {
            Route::get('/create', [BerkasController::class, 'create'])->name('create');
            Route::post('/', [BerkasController::class, 'store'])->name('store');
            Route::delete('/{berkas}', [BerkasController::class, 'destroy'])->name('destroy');
        });

        // Route dengan parameter di bawah
        Route::get('/{berkas}', [BerkasController::class, 'show'])->name('show');
        Route::get('/{berkas}/download', [BerkasController::class, 'download'])->name('download');
    });

});

require __DIR__ . '/auth.php';