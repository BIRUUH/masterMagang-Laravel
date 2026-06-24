<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\DudiController;
use App\Http\Controllers\Admin\MagangController;
use App\Http\Controllers\Admin\PengaturanController;

// Redirect root URL langsung ke beranda admin
Route::redirect('/', '/admin/beranda');

// Route Group untuk Admin
Route::prefix('admin')->name('admin.')->group(function () {

    // Route Dashboard / Beranda
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    // Route Master Data - Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/data', [SiswaController::class, 'getData'])->name('siswa.data');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy'); // route parameter

    // Route Master Data - Guru
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::get('/guru/data', [GuruController::class, 'getData'])->name('guru.data');
    Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
    Route::put('/guru/{id}', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');

    // Route Master Data - Dudi
    Route::get('/dudi', [DudiController::class, 'index'])->name('dudi.index');
    Route::get('/dudi/data', [DudiController::class, 'getData'])->name('dudi.data');
    Route::post('/dudi', [DudiController::class, 'store'])->name('dudi.store');
    Route::put('/dudi/{id}', [DudiController::class, 'update'])->name('dudi.update');
    Route::delete('/dudi/{id}', [DudiController::class, 'destroy'])->name('dudi.destroy');

    // Route Master Data - Magang
    Route::get('/magang', [MagangController::class, 'index'])->name('magang.index');

    // Route Pengaturan Sekolah
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
});
