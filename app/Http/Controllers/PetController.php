<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    public function index()
    {
        // Ambil data pet dengan relasi ke ras hewan dan pemilik
        $pet = Pet::with(['rasHewan', 'pemilik'])->get();

        return view('pagepet.index', compact('pet'));
    }
}
