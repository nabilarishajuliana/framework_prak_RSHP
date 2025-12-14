<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemuDokter;
use Carbon\Carbon;
use App\Models\Pet;

class DataPasienController extends Controller
{
    private function isRole($roleName)
    {
        return strtolower(session('user_role_name')) === strtolower($roleName);
    }

    /** =====================================
     *  INDEX (list semua pasien)
     * ====================================== */
    public function index()
    {
        $today = Carbon::today();


        $pasien = TemuDokter::with([
            'pet' => function ($q) {
                $q->withTrashed()->with([
                    'pemilik' => function ($p) {
                        $p->withTrashed()->with([
                            'user' => fn($u) => $u->withTrashed()
                        ]);
                    },
                    'rasHewan'
                ]);
            },

            // ✅ hanya rekam medis AKTIF untuk cek tombol & tampil dokter/tanggal
            'rekamMedis' => function ($q) {
                $q->with([
                    'dokterPemeriksa' => function ($dok) {
                        $dok->withTrashed()->with([
                            'user' => fn($u) => $u->withTrashed()
                        ]);
                    }
                ]);
            }
        ])
            ->whereNull('deleted_at')
            ->whereDate('waktu_daftar', $today)
            ->orderBy('no_urut', 'asc')
            ->get();

        if ($this->isRole('dokter')) {
            return view('pageDokter.pagePasien.index', compact('pasien'));
        }

        // default perawat
        return view('pagePerawat.pagePasien.index', compact('pasien'));
    }


    /** =====================================
     *  DETAIL PASIEN
     * ====================================== */
    public function detail($id)
    {
        $data = TemuDokter::with([
            'pet' => function ($q) {
                $q->withTrashed()->with([
                    'pemilik' => function ($p) {
                        $p->withTrashed()->with([
                            'user' => fn($u) => $u->withTrashed()
                        ]);
                    },
                    'rasHewan'
                ]);
            },

            // ✅ di detail baru load lengkap (aktif + trashed kalau mau histori)
            'rekamMedisAll' => function ($q) {
                $q->withTrashed()->with([
                    'detail' => function ($d) {
                        $d->withTrashed()->with([
                            'kodeTindakan' => fn($kt) => $kt->withTrashed()
                        ]);
                    },
                    'dokterPemeriksa' => function ($dok) {
                        $dok->withTrashed()->with([
                            'user' => fn($u) => $u->withTrashed()
                        ]);
                    }
                ]);
            }
        ])
            ->withTrashed()
            ->findOrFail($id);


        if ($this->isRole('dokter')) {
            return view('pageDokter.pagePasien.detail', compact('data'));
        }

        return view('pagePerawat.pagePasien.detail', compact('data'));
    }
}
