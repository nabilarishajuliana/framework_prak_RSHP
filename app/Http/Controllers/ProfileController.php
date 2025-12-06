<?php

namespace App\Http\Controllers;
use App\Models\Pemilik;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use App\Models\Perawat;

class ProfileController extends Controller
{
     /** =========================
     * SHOW PROFILE
     * ========================== */
    public function index()
    {
        $userId = session('user_id');

        $user = User::withTrashed()->findOrFail($userId);

        $perawat = Perawat::withTrashed()
            ->where('iduser', $userId)
            ->first()?? new Perawat();

        return view('pagePerawat.pageProfile.index', compact('user', 'perawat'));
    }

    public function indexDokter()
    {
        $userId = session('user_id');

        $user = User::withTrashed()->findOrFail($userId);

        $dokter = Dokter::withTrashed()
            ->where('iduser', $userId)
            ->first()?? new Dokter();;

        return view('pageDokter.pageProfile.index', compact('user', 'dokter'));
    }

    public function indexPemilik()
    {
        $idUser = session('user_id');
        
        $pemilik = Pemilik::with('user')
            ->where('iduser', $idUser)
            ->first();
            
        if (!$pemilik) {
            return redirect()->route('login')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        return view('pagePemilik.pageProfile.index', compact('pemilik'));
    }
}
