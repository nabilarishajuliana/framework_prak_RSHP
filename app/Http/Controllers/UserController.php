<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     public function index()
    {
        // Ambil semua user dengan role-nya
        $users = User::with('roles')->get();

        return view('pageuser.index', compact('users'));
    }
}
