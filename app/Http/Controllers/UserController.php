<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     public function index()
    {
        // Ambil semua user beserta role & role_user-nya
        $user = User::with(['roleUser.role'])->get();

        return view('pageuser.index', compact('user'));
    }
}
