<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KodeTindakanTerapi;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        // Ambil semua data beserta relasi kategori dan kategori klinis
        $kodeTindakan = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get();

        return view('pagekodetindakan.index', compact('kodeTindakan'));
    }
}
