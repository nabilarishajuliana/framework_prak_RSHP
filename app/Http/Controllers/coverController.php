<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class coverController extends Controller
{
    public function index()
    {
        return view('pagecover.home',);
    }

    public function layanan()
    {
        return view('pageCover.layanan',);
    }

    public function kontak()
    {
        return view('pageCover.kontak');
    }
}
