<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\TemuDokter;
use App\Models\Pet;

class JadwalController extends Controller
{
    /**
     * Display list of jadwal temu dokter
     */
    public function index()
    {
        $idUser = session('user_id');

        $pemilik = Pemilik::where('iduser', $idUser)->first();

        if (!$pemilik) {
            return redirect()->route('login')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        // Ambil semua jadwal temu dokter dari pet-pet yang dimiliki
        $jadwalTemuDokter = TemuDokter::with(['pet.rasHewan', 'roleUser.role'])
            ->whereHas('pet', function ($query) use ($pemilik) {
                $query->where('idpemilik', $pemilik->idpemilik);
            })
            ->whereNull('temu_dokter.deleted_at')
            ->orderBy('waktu_daftar', 'desc')
            ->get();

        return view('pagePemilik.pageJadwal.index', compact('pemilik', 'jadwalTemuDokter'));
    }

    /**
     * Show create jadwal form
     */
    public function create()
    {
        $idUser = session('user_id');

        $pemilik = Pemilik::where('iduser', $idUser)->first();

        if (!$pemilik) {
            return redirect()->route('login')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        // Ambil semua pet milik pemilik
        $pets = Pet::where('idpemilik', $pemilik->idpemilik)
            ->whereNull('deleted_at')
            ->get();

        return view('pagePemilik.pageJadwal.create', compact('pemilik', 'pets'));
    }

    /**
     * Store new jadwal
     */
    public function store(Request $request)
    {
        // TODO: Implement store logic
        return redirect()->route('pemilik.jadwal.index')
            ->with('success', 'Jadwal temu dokter berhasil dibuat');
    }

    /**
     * Display jadwal detail
     */
    public function show($id)
    {
        $idUser = session('user_id');

        $pemilik = Pemilik::where('iduser', $idUser)->first();

        if (!$pemilik) {
            return redirect()->route('login')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        $jadwal = TemuDokter::with(['pet.rasHewan', 'roleUser.role', 'rekamMedis'])
            ->whereHas('pet', function ($query) use ($pemilik) {
                $query->where('idpemilik', $pemilik->idpemilik);
            })
            ->where('idreservasi_dokter', $id)
            ->whereNull('temu_dokter.deleted_at')
            ->first();

        if (!$jadwal) {
            return redirect()->route('pemilik.jadwal.index')
                ->with('error', 'Jadwal tidak ditemukan');
        }

        return view('pagePemilik.pageJadwal.show', compact('pemilik', 'jadwal'));
    }

    /**
     * Delete jadwal (soft delete)
     */
    public function destroy($id)
    {
        // TODO: Implement delete logic
        return redirect()->route('pemilik.jadwal.index')
            ->with('success', 'Jadwal berhasil dibatalkan');
    }
}
