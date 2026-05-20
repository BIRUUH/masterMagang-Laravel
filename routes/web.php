<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BerandaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\DudiController;
use App\Http\Controllers\Admin\MagangController;

// Redirect root URL langsung ke beranda admin (sementara)
Route::redirect('/', '/admin/beranda');

// Route Group untuk area Admin
Route::prefix('admin')->name('admin.')->group(function () {

    // Route Dashboard / Beranda
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    // Route Master Data
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::get('/dudi', [DudiController::class, 'index'])->name('dudi.index');
    Route::get('/magang', [MagangController::class, 'index'])->name('magang.index');
});
