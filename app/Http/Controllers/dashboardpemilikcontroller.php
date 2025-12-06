<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\Pet;
use App\Models\TemuDokter;

class dashboardPemilikController extends Controller
{
    /**
     * Display dashboard pemilik (simple version)
     * Hanya menampilkan jumlah pet dan temu dokter
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil iduser dari session
        $idUser = session('user_id');
        
        // Ambil data pemilik berdasarkan iduser yang login
        $pemilik = Pemilik::with('user')
            ->where('iduser', $idUser)
            ->first();
            
        // Jika pemilik tidak ditemukan, redirect ke login
        if (!$pemilik) {
            return redirect()->route('login')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        // 1. Hitung total pet yang dimiliki
        $totalPets = Pet::where('idpemilik', $pemilik->idpemilik)
            ->whereNull('deleted_at')
            ->count();
        
        // 2. Hitung total temu dokter (semua status, yang belum dihapus)
        // Melalui relasi pet
        $totalTemuDokter = TemuDokter::whereHas('pet', function($query) use ($pemilik) {
                $query->where('idpemilik', $pemilik->idpemilik);
            })
            ->whereNull('temu_dokter.deleted_at')
            ->count();
        
        // Return view dengan data
        return view('pagePemilik.dashboardpemilik', compact(
            'pemilik',
            'totalPets',
            'totalTemuDokter'
        ));
    }
}