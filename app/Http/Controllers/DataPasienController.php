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
            // PET (boleh sudah dihapus)
            'pet' => function ($q) {
                $q->withTrashed()->with([
                    'pemilik' => function ($p) {
                        $p->withTrashed()->with([
                            'user' => function ($u) {
                                $u->withTrashed();
                            }
                        ]);
                    }
                ]);
            },

            // REKAM MEDIS + DETAIL (semua withTrashed)
            'rekamMedis' => function ($q) {
                $q->withTrashed()->with([
                    'detail' => function ($d) {
                        $d->withTrashed()->with([
                            'kodeTindakan' => function ($kt) {
                                $kt->withTrashed();
                            }
                        ]);
                    },
                    'dokterPemeriksa' => function ($dok) {
                        $dok->withTrashed()->with([
                            'user' => function ($u) {
                                $u->withTrashed();
                            }
                        ]);
                    }
                ]);
            },

            // ROLE USER (boleh sudah terhapus)
            'roleUser' => function ($ru) {
                $ru->withTrashed()->with([
                    'user' => function ($u) {
                        $u->withTrashed();
                    }
                ]);
            }

        ])
        ->whereNull('deleted_at')             // TemuDokter harus aktif
        ->whereDate('waktu_daftar', $today)
        ->orderBy('no_urut', 'asc')
        ->get();

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
                            'user' => function ($u) {
                                $u->withTrashed();
                            }
                        ]);
                    }
                ]);
            },

            'rekamMedis' => function ($q) {
                $q->withTrashed()->with([
                    'detail' => function ($d) {
                        $d->withTrashed()->with([
                            'kodeTindakan' => function ($kt) {
                                $kt->withTrashed();
                            }
                        ]);
                    },
                    'dokterPemeriksa' => function ($dok) {
                        $dok->withTrashed()->with([
                            'user' => function ($u) {
                                $u->withTrashed();
                            }
                        ]);
                    }
                ]);
            },

            'roleUser' => function ($ru) {
                $ru->withTrashed()->with([
                    'user' => function ($u) {
                        $u->withTrashed();
                    }
                ]);
            }

        ])
        ->withTrashed()     // detail boleh lihat semua data lampau
        ->findOrFail($id);

        return view('pagePerawat.pagePasien.detail', compact('data'));
    }

}
