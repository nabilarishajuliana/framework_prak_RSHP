<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\coverController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisHewanController;
use App\Http\Controllers\RasHewanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriKlinisController;
use App\Http\Controllers\KodeTindakanTerapiController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PemilikController;
// use App\Http\Controllers\admin\dashboardAdmin;
// use App\Http\Controllers\resepsionis\dashboardResepsionis;


//page cover
Route::get('/', [coverController::class, 'index'])->name('home');
Route::get('/layanan', [coverController::class, 'layanan'])->name('layanan');
Route::get('/kontak', [coverController::class, 'kontak'])->name(name: 'kontak');

//cek koneksi
Route::get('/cek-koneksi', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Koneksi database berhasil!";
    } catch (\Exception $e) {
        return "❌ Koneksi database gagal: " . $e->getMessage();
    }
});


Auth::routes(); // isinya ini routes nya login,logout,registration,password/reset

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\dashboardAdmin::class, 'index'])->name('admin.dashboard');

    // Data Master
    Route::get('/user', [UserController::class, 'index'])->name('admin.user');
    Route::get('/role', [RoleController::class, 'index'])->name('admin.role');
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('admin.pemilik');
    Route::get('/pet', [PetController::class, 'index'])->name('admin.pet');
    Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('admin.jenis.hewan');
    Route::get('/ras-hewan', [RasHewanController::class, 'index'])->name('admin.ras.hewan');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori');
    Route::get('/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('admin.kategori.klinis');
    Route::get('/kode-tindakan', [KodeTindakanTerapiController::class, 'index'])->name('admin.kode.tindakan');
});

Route::middleware(['auth', 'isResepsionis'])->prefix('resepsionis')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\dashboardResepsionis::class, 'index'])->name('resepsionis.dashboard');

    // Data Master

    Route::get('/pemilik', [PemilikController::class, 'pemilikResepsionis'])->name('resepsionis.pemilik');
    Route::get('/pet', [PetController::class, 'petResepsionis'])->name('resepsionis.pet');

    Route::get('/temu-dokter', [App\Http\Controllers\TemuDokterController::class, 'index'])->name('resepsionis.temu.dokter');
    Route::post('/temu-dokter', [App\Http\Controllers\TemuDokterController::class, 'store'])->name('resepsionis.temu.dokter.store');
    Route::get('/temu-dokter/{id}/status/{status}', [App\Http\Controllers\TemuDokterController::class, 'updateStatus'])->name('resepsionis.temu.dokter.status');
    Route::delete('/temu-dokter/{id}', [App\Http\Controllers\TemuDokterController::class, 'destroy'])->name('resepsionis.temu.dokter.delete');
});

Route::middleware(['auth', 'isDokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\dashboarddoktercontroller::class, 'index'])->name('dokter.dashboard');

    Route::get('/rekam-medis', [App\Http\Controllers\RekamMedisController::class, 'index'])
        ->name('dokter.rekammedis');
    Route::get('/rekam-medis/{id}', [App\Http\Controllers\RekamMedisController::class, 'show'])
        ->name('dokter.rekammedis.detail');
    

});

Route::middleware(['auth', 'isPerawat'])->prefix('perawat')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\dashboardPerawatController::class, 'index'])->name('perawat.dashboard');
     Route::get('/rekam-medis', [App\Http\Controllers\RekamMedisController::class, 'indexPerawat'])->name('perawat.rekammedis');
    Route::get('/rekam-medis/{id}', [App\Http\Controllers\RekamMedisController::class, 'showPerawat'])->name('perawat.rekammedis.detail');
    // Data Master

    // Route::get('/pemilik', [PemilikController::class, 'pemilikResepsionis'])->name('resepsionis.pemilik');
    // Route::get('/pet', [PetController::class, 'petResepsionis'])->name('resepsionis.pet');

});

// Route::middleware(['auth', 'isResepsionis'])->group(function () {
//     Route::get('/resepsionis/dashboard', [App\Http\Controllers\dashboardResepsionis::class, 'index'])->name('resepsionis.dashboard');

// });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
