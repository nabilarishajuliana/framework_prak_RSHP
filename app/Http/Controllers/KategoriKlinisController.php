<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKlinis;

class KategoriKlinisController extends Controller
{
     public function index()
    {
        $kategoriKlinis = KategoriKlinis::all();
        return view('pagekategoriklinis.index', compact('kategoriKlinis'));
    }
}
