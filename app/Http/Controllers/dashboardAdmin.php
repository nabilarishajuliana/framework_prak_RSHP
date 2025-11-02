<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pet;
use App\Models\Role;
class dashboardAdmin extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPets = Pet::count();
        $totalRoles = Role::count();
        return view('pageAdmin.dashboardAdmin', compact('totalUsers', 'totalPets', 'totalRoles'));
    }
}
