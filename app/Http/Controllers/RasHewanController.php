<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RasHewan;
use App\Models\JenisHewan;
class RasHewanController extends Controller
{
    public function index()
    {
        // Ambil data ras hewan dan relasi jenis hewan
        $rasHewan = RasHewan::with('jenisHewan')->get();

        return view('pagerashewan.index', compact('rasHewan'));
    }
}
