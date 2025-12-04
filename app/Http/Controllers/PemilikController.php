<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;

class PemilikController extends Controller
{
    public function index()
    {
        // Ambil semua data pemilik, lengkap dengan user & pet
        $pemilik = Pemilik::with(['user', 'pet'])->get();

        return view('pagepemilik.index', compact('pemilik'));
    }
}
