<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\DetailRekamMedis;
use App\Models\TemuDokter;

class dashboardPerawatController extends Controller
{
     public function index()
    {
        $totalRekamMedis = RekamMedis::count();
        $totalTemuDokter = TemuDokter::count();
        $totalDetail = DetailRekamMedis::count();

        return view('pageperawat.dashboardperawat', compact('totalRekamMedis', 'totalTemuDokter', 'totalDetail'));
    }
}
