<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemuDokter;
use App\Models\Pet;
use App\Models\Pemilik;

class DashboardDokterController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // Ambil data antrian hari ini
        $todayQueues = TemuDokter::with(['pet.pemilik.user'])
            ->whereDate('waktu_daftar', $today)
            ->orderBy('no_urut')
            ->get();

        // Total data untuk statistik
        $totalAntrianHariIni = $todayQueues->count();
        $totalPasienSelesai = $todayQueues->where('status', 'S')->count();
        $totalBatal = $todayQueues->where('status', 'B')->count();

        // Data umum (optional)
        $totalPet = Pet::count();
        $totalPemilik = Pemilik::count();

        return view('pagedokter.dashboarddokter', compact(
            'todayQueues',
            'totalAntrianHariIni',
            'totalPasienSelesai',
            'totalBatal',
            'totalPet',
            'totalPemilik'
        ));
    }
}
