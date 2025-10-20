<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', function () {
//     return view('pageCover.home');
// });

//user
Route::get('/user', [UserController::class, 'index'])->name('user');

//role
Route::get('/role', [RoleController::class, 'index'])->name('role');

//pet
Route::get('/pet', [PetController::class, 'index'])->name('pet');

//kode tindakan
Route::get('/kode-tindakan', [KodeTindakanTerapiController::class, 'index'])->name('kode.tindakan');

//kategori klinis
Route::get('/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('kategori.klinis');

//kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');

//ras hewan
Route::get('/ras-hewan', [RasHewanController::class, 'index'])->name('ras.hewan');

//jenis hewan
Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis.hewan');

//page cover
Route::get('/', [coverController::class, 'index']) ->name('home');
Route::get('/layanan', [coverController::class, 'layanan']) ->name('layanan');
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
