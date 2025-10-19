<?php

use App\Http\Controllers\coverController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', function () {
//     return view('pageCover.home');
// });

Route::get('/home', [coverController::class, 'index']);

Route::get('/layanan', [coverController::class, 'layanan']);

Route::get('/kontak', [coverController::class, 'kontak']);
