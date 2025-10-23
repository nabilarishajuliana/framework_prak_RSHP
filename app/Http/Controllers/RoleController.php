<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
     public function index()
    {
        // Ambil semua role + relasi ke role_user
        $roles = Role::with('users')->get();

        return view('pagerole.index', compact('roles'));
    }
}
