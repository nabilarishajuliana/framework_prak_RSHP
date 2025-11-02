<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\DetailRekamMedis;

use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    // 📋 Tampilkan daftar semua rekam medis
    public function index()
    {
        $rekamMedis = RekamMedis::with([
                'temuDokter.pet.pemilik.user',
                'dokter.user'
            ])
            ->orderByDesc('created_at')
            ->get();

        return view('pagedokter.pagerekammedis.index', compact('rekamMedis'));
    }

    // 📄 Tampilkan detail satu rekam medis
    public function show($id)
    {
        $rekamMedis = RekamMedis::with([
                'temuDokter.pet.pemilik.user',
                'dokter.user',
                'detailRekamMedis.kodeTindakanTerapi'
            ])
            ->findOrFail($id);

        return view('pagedokter.pagerekammedis.detail', compact('rekamMedis'));
    }

    public function indexPerawat()
{
    $rekamMedis = RekamMedis::with([
        'temuDokter.pet.pemilik.user',
        'dokter.user'
    ])
    ->orderByDesc('created_at')
    ->get();

    return view('pageperawat.pagerekammedis.index', compact('rekamMedis'));
}

public function showPerawat($id)
{
    $rekamMedis = RekamMedis::with([
        'temuDokter.pet.pemilik.user',
        'dokter.user'
    ])->findOrFail($id);

    $details = DetailRekamMedis::with('kodeTindakanTerapi')
        ->where('idrekam_medis', $id)
        ->get();

    return view('pageperawat.pagerekammedis.detail', compact('rekamMedis', 'details'));
}

}
