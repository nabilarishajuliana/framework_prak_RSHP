<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\Pet;

class dashboardResepsionis extends Controller
{
    public function index()
    {
       $totalPemilik = Pemilik::count();
        $totalPet = Pet::count();

        return view('pageresepsionis.dashboardResepsionis', compact('totalPemilik', 'totalPet'));
    
    }
}
