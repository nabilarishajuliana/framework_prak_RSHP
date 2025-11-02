<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisHewan;


class JenisHewanController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel jenis_hewan
        $jenisHewan = JenisHewan::all();

        // Kirim ke view
        return view('pageadmin.pageJenisHewan.index', compact('jenisHewan'));
    }
}
