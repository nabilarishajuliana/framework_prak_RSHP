<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
     public function index()
    {
        $kategori = Kategori::all();
        return view('pagekategori.index', compact('kategori'));
    }
}
