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
    // Route::get('/user', [UserController::class, 'index'])->name('admin.user');
    // Route::get(uri: '/role', [RoleController::class, 'index'])->name('admin.role');
    // Route::get('/pemilik', [PemilikController::class, 'index'])->name('admin.pemilik');
    // Route::get('/pet', [PetController::class, 'index'])->name('admin.pet');

    //JENIS HEWAN
    Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('admin.jenis.hewan');
    Route::get('/jenis-hewan/create', [App\Http\Controllers\JenisHewanController::class, 'create'])->name('admin.jenis.hewan.create');
    Route::post('/jenis-hewan/store', [App\Http\Controllers\JenisHewanController::class, 'store'])->name('admin.jenis.hewan.store'); // menyimpan data ke database
    Route::get('/jenis-hewan/{id}/edit', [JenisHewanController::class, 'edit'])->name('admin.jenis.hewan.edit');
    Route::put('/jenis-hewan/{id}', [JenisHewanController::class, 'update'])->name('admin.jenis.hewan.update');
    Route::delete('/jenis-hewan/{id}', [JenisHewanController::class, 'destroy'])->name('admin.jenis.hewan.destroy');

    //RASH HEWAN
    Route::get('/ras-hewan', [RasHewanController::class, 'index'])->name('admin.ras.hewan');
    Route::get('/ras-hewan/create', [RasHewanController::class, 'create'])->name('admin.ras.hewan.create');
    Route::post('/ras-hewan/store', [RasHewanController::class, 'store'])->name('admin.ras.hewan.store');
    Route::get('/ras-hewan/{id}/edit', [RasHewanController::class, 'edit'])->name('admin.ras.hewan.edit');
    Route::put('/ras-hewan/{id}', [RasHewanController::class, 'update'])->name('admin.ras.hewan.update');
    Route::delete('/ras-hewan/{id}', [RasHewanController::class, 'destroy'])->name('admin.ras.hewan.destroy');

    //KATEGORI
    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    //KATEGORI KLINIS
    Route::get('/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('admin.kategori.klinis');
    Route::get('/kategori-klinis/create', [KategoriKlinisController::class, 'create'])->name('admin.kategori.klinis.create');
    Route::post('/kategori-klinis/store', [KategoriKlinisController::class, 'store'])->name('admin.kategori.klinis.store');
    Route::get('/kategori-klinis/{id}/edit', [KategoriKlinisController::class, 'edit'])->name('admin.kategori.klinis.edit');
    Route::put('/kategori-klinis/{id}', [KategoriKlinisController::class, 'update'])->name('admin.kategori.klinis.update');
    Route::delete('/kategori-klinis/{id}', [KategoriKlinisController::class, 'destroy'])->name('admin.kategori.klinis.destroy');

    //KODE TINDAKAN
    Route::get('/kode-tindakan', [KodeTindakanTerapiController::class, 'index'])->name('admin.kode.tindakan');
    Route::get('/kode-tindakan/create', [KodeTindakanTerapiController::class, 'create'])->name('admin.kode.tindakan.create');
    Route::post('/kode-tindakan/store', [KodeTindakanTerapiController::class, 'store'])->name('admin.kode.tindakan.store');
    Route::get('/kode-tindakan/{id}/edit', [KodeTindakanTerapiController::class, 'edit'])->name('admin.kode.tindakan.edit');
    Route::put('/kode-tindakan/{id}', [KodeTindakanTerapiController::class, 'update'])->name('admin.kode.tindakan.update');
    Route::delete('/kode-tindakan/{id}', [KodeTindakanTerapiController::class, 'destroy'])->name('admin.kode.tindakan.destroy');

    //PEMILIK
        Route::get('/pemilik', [PemilikController::class, 'index'])->name('admin.pemilik');
        Route::get('/pemilik/create', [PemilikController::class, 'create'])->name('admin.pemilik.create');
        Route::post('/pemilik', [PemilikController::class, 'store'])->name('admin.pemilik.store');
        Route::get('/pemilik/{id}/edit', [PemilikController::class, 'edit'])->name('admin.pemilik.edit');
        Route::put('/pemilik/{id}', [PemilikController::class, 'update'])->name('admin.pemilik.update');
        Route::delete('/pemilik/{id}', [PemilikController::class, 'destroy'])->name('admin.pemilik.destroy');


    // ROLE
        Route::get('/role', [RoleController::class, 'index'])->name('admin.role');
        Route::get('/role/create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('/role', [RoleController::class, 'store'])->name('admin.role.store');
        Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('admin.role.edit');
        Route::put('/role/{id}', [RoleController::class, 'update'])->name('admin.role.update');
        Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('admin.role.destroy');

        //USER
        Route::get('/user', [UserController::class, 'index'])->name('admin.user');
        Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/user/{id}/update', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/user/{id}/delete', [UserController::class, 'destroy'])->name('admin.user.destroy');
        Route::put('/user/{id}/switch-role', [UserController::class, 'switchRole'])->name('admin.user.switchRole');

        //PET
    Route::get('/pet', [App\Http\Controllers\PetController::class, 'index'])->name('admin.pet');
    Route::get('/pet/create', [App\Http\Controllers\PetController::class, 'create'])->name('admin.pet.create');
    Route::post('/pet/store', [App\Http\Controllers\PetController::class, 'store'])->name('admin.pet.store');
    Route::get('/pet/{id}/edit', [App\Http\Controllers\PetController::class, 'edit'])->name('admin.pet.edit');
    Route::put('/pet/{id}', [App\Http\Controllers\PetController::class, 'update'])->name('admin.pet.update');
    Route::delete('/pet/{id}', [App\Http\Controllers\PetController::class, 'destroy'])->name('admin.pet.destroy');


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

Route::middleware(['auth', 'isPemilik'])->prefix('pemilik')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\dashboardPemilikController::class, 'index'])->name('pemilik.dashboard');


    // Route::get('/pemilik', [PemilikController::class, 'pemilikResepsionis'])->name('resepsionis.pemilik');
    // Route::get('/pet', [PetController::class, 'petResepsionis'])->name('resepsionis.pet');

});

// Route::middleware(['auth', 'isResepsionis'])->group(function () {
//     Route::get('/resepsionis/dashboard', [App\Http\Controllers\dashboardResepsionis::class, 'index'])->name('resepsionis.dashboard');

// });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
