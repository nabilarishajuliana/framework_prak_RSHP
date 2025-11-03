<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardpemilikcontroller extends Controller
{
     public function index()
    {
        // $totalUsers = User::count();
        // $totalPets = Pet::count();
        // $totalRoles = Role::count();
        return view('pagePemilik.dashboardpemilik', );
    }
}
