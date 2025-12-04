<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RekamMedis;
use App\Models\DetailRekamMedis;
use App\Models\TemuDokter;
use App\Models\RoleUser;
use App\Models\KodeTindakanTerapi;

class RekamMedisController extends Controller
{
    public function create($reservasiId = null)
    {
        $selectedReservasi = null;

    if ($reservasiId) {
        $selectedReservasi = TemuDokter::whereNull('deleted_at')->find($reservasiId);
    }
        // ===================== ANTRIAN HARI INI (tanpa soft delete) =====================
        $antrian = TemuDokter::with([
            'pet' => function ($p) {
                $p->with(['pemilik.user'])   // pet masih aktif, jadi ga butuh withTrashed
                    ->whereNull('deleted_at');
            }
        ])
            ->where('status', 'N')
            ->whereDate('waktu_daftar', Carbon::today())
            ->whereNull('deleted_at') // temu_dokter harus aktif
            ->whereHas('pet', function ($q) {
                $q->whereNull('deleted_at'); // pet aktif
            })
            ->get();


        // ===================== DOKTER (RoleUser + User aktif) =====================
        $dokter = RoleUser::with([
            'user' => function ($u) {
                $u->whereNull('deleted_at'); // user aktif
            }
        ])
            ->where('idrole', 2)   // dokter
            ->where('status', 1)   // role aktif
            ->whereNull('deleted_at') // role_user aktif
            ->get()
            ->filter(fn($d) => $d->user !== null); // jaga-jaga user empty


        // ===================== KODE TINDAKAN TERAPI (aktif) =====================
        $tindakan = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])
            ->whereNull('deleted_at')
            ->get();


        return view('pagePerawat.pageRekamMedis.create', compact('antrian', 'dokter', 'tindakan', 'selectedReservasi'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idreservasi'   => 'required|exists:temu_dokter,idreservasi_dokter',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa'      => 'required|string',
            'temuan_klinis' => 'required|string',
            'diagnosa'      => 'required|string',
            'idkode_tindakan_terapi' => 'required|array|min:1',
            'idkode_tindakan_terapi.*' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'required|array|min:1',
            'detail.*' => 'required|string'
        ], [
            'idkode_tindakan_terapi.required' => 'Minimal harus ada 1 tindakan terapi',
            'idkode_tindakan_terapi.*.exists' => 'Kode tindakan tidak valid',
            'detail.required' => 'Detail tindakan harus diisi',
            'detail.*.required' => 'Setiap detail tindakan harus diisi'
        ]);

        // Gunakan database transaction untuk memastikan semua data tersimpan atau gagal semua
        DB::beginTransaction();

        try {
            // 1. Create rekam medis utama
            $rekam = RekamMedis::create([
                'created_at' => Carbon::now(),
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
                'idReservasi_dokter' => $request->idreservasi
            ]);

            // 2. Create detail rekam medis (multiple tindakan)
            foreach ($request->idkode_tindakan_terapi as $index => $kodeTindakan) {
                DetailRekamMedis::create([
                    'idrekam_medis' => $rekam->idrekam_medis,
                    'idkode_tindakan_terapi' => $kodeTindakan,
                    'detail' => $request->detail[$index]
                ]);
            }

            // 3. Update status antrian menjadi 'S' (Selesai)
            $reservasi = TemuDokter::findOrFail($request->idreservasi);
            $reservasi->status = 'S';
            $reservasi->save();

            // Commit transaction jika semua berhasil
            DB::commit();

            return redirect()
                ->route('perawat.rekammedis')
                ->with('success', 'Rekam medis berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan rekam medis: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $rekam = RekamMedis::with([
            'reservasi' => function ($q) {
                $q->withTrashed()->with([
                    'pet' => function ($p) {
                        $p->withTrashed()->with(['pemilik.user']);
                    }
                ]);
            },
            'dokterPemeriksa.user',
            'detail'
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pagePerawat.pageRekamMedis.index', compact('rekam'));
    }

    public function show($id)
    {
        $rekam = RekamMedis::with([
            'reservasi' => function ($q) {
                $q->withTrashed()->with([
                    'pet' => function ($p) {
                        $p->withTrashed()->with([
                            'pemilik.user',
                            'rasHewan.jenisHewan'
                        ]);
                    }
                ]);
            },
            'dokterPemeriksa.user',
            'detail.kodeTindakan' => function ($q) {
                $q->with(['kategori', 'kategoriKlinis']);
            }
        ])->findOrFail($id);

        return view('pagePerawat.pageRekamMedis.detail', compact('rekam'));
    }

    public function edit($id)
    {
        // Ambil rekam medis yang akan diedit
        $rekam = RekamMedis::with([
            'reservasi' => function ($q) {
                $q->withTrashed()->with([
                    'pet' => function ($p) {
                        $p->withTrashed()->with(['pemilik.user', 'rasHewan.jenisHewan']);
                    }
                ]);
            },
            'dokterPemeriksa.user',
            'detail.kodeTindakan'
        ])->findOrFail($id);

        // ===================== DOKTER (RoleUser + User aktif) =====================
        $dokter = RoleUser::with([
            'user' => function ($u) {
                $u->whereNull('deleted_at'); // user aktif
            }
        ])
            ->where('idrole', 2)   // dokter
            ->where('status', 1)   // role aktif
            ->whereNull('deleted_at') // role_user aktif
            ->get()
            ->filter(fn($d) => $d->user !== null); // jaga-jaga user empty

        // Ambil semua kode tindakan terapi
        $tindakan = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])
            ->whereNull('deleted_at')
            ->get();


        return view('pagePerawat.pageRekamMedis.edit', compact('rekam', 'dokter', 'tindakan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'anamnesa'      => 'required|string',
            'temuan_klinis' => 'required|string',
            'diagnosa'      => 'required|string',
            'idkode_tindakan_terapi' => 'required|array|min:1',
            'idkode_tindakan_terapi.*' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'required|array|min:1',
            'detail.*' => 'required|string'
        ], [
            'idkode_tindakan_terapi.required' => 'Minimal harus ada 1 tindakan terapi',
            'idkode_tindakan_terapi.*.exists' => 'Kode tindakan tidak valid',
            'detail.required' => 'Detail tindakan harus diisi',
            'detail.*.required' => 'Setiap detail tindakan harus diisi'
        ]);

        DB::beginTransaction();

        try {
            // 1. Cari rekam medis yang akan diupdate
            $rekam = RekamMedis::findOrFail($id);

            // 2. Update data rekam medis utama
            $rekam->update([
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'diagnosa' => $request->diagnosa,
                'dokter_pemeriksa' => $request->dokter_pemeriksa
            ]);

            // 3. Soft delete semua detail rekam medis yang lama
            DetailRekamMedis::where('idrekam_medis', $id)->delete();

            // 4. Insert detail rekam medis yang baru
            foreach ($request->idkode_tindakan_terapi as $index => $kodeTindakan) {
                DetailRekamMedis::create([
                    'idrekam_medis' => $rekam->idrekam_medis,
                    'idkode_tindakan_terapi' => $kodeTindakan,
                    'detail' => $request->detail[$index]
                ]);
            }

            DB::commit();

            return redirect()
                ->route('perawat.rekammedis')
                ->with('success', 'Rekam medis berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate rekam medis: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $rekam = RekamMedis::findOrFail($id);

            // Soft delete detail rekam medis
            DetailRekamMedis::where('idrekam_medis', $id)->delete();

            // Soft delete rekam medis utama
            $rekam->delete();

            DB::commit();

            return redirect()
                ->route('perawat.rekammedis')
                ->with('success', 'Rekam medis berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus rekam medis: ' . $e->getMessage());
        }
    }
}
