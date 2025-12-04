<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TemuDokter;
use App\Models\RekamMedis;
use App\Models\Pet;

class dashboardPerawatController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        /** =======================
         *  TOTAL PASIEN HARI INI
         *  Dari tabel temu_dokter
         * ======================= */
        $totalPasienHariIni = TemuDokter::whereDate('waktu_daftar', $today)
            ->whereNull('deleted_at')
            ->count();

        /** =======================
         *  TOTAL REKAM MEDIS HARI INI
         *  Dari tabel rekam_medis.created_at
         * ======================= */
        $rekamMedisHariIni = RekamMedis::whereDate('created_at', $today)
            ->whereNull('deleted_at')
            ->count();

        /** =======================
         *  TOTAL PET 
         * ======================= */
        $totalPet = Pet::whereNull('deleted_at')->count();

        return view('pageperawat.dashboardPerawat', compact(
            'totalPasienHariIni',
            'rekamMedisHariIni',
            'totalPet'
        ));
    }

    public function coba()
    {
        

        return view('pageperawat.coba' );
    }
}
