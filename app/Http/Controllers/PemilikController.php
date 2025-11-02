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

        return view('pageadmin.pagepemilik.index', compact('pemilik'));
    }

    public function pemilikResepsionis()
    {
        // Ambil semua data pemilik, lengkap dengan user & pet
        $pemilik = Pemilik::with(['user', 'pet'])->get();

        return view('pageresepsionis.pagepemilik.index', compact('pemilik'));
    }
}
