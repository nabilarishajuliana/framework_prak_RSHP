<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\RekamMedis;
use App\Models\DetailRekamMedis;
use App\Models\TemuDokter;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\KodeTindakanTerapi;

class RekamMedisController extends Controller
{

    function isRole($role)
    {
        return strtolower(session('user_role_name')) === strtolower($role);
    }

    /** ======================== INDEX ======================== */
    public function index()
    {
        $rekam = RekamMedis::with([
    'reservasi' => function($q){
        $q->withTrashed()->with([
            'pet' => function($p){
                $p->withTrashed()->with(['pemilik.user']);
            }
        ]);
    },
    'dokterPemeriksa.user',  // ✨ ini relasi baru yang benar
])->get();



        // dd($rekam->where(key: 'idreservasi_dokter', null));


        return view('pageperawat.pagerekammedis.index', compact('rekam'));
    }

    /** ======================== DETAIL ======================== */
    public function show($id)
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
        'detail.kodeTindakan'
    ])->findOrFail($id);

    return view('pagePerawat.pageRekamMedis.detail', compact('rekam'));
}

public function create()
{
    // Ambil antrian hari ini yg masih N
    $antrian = TemuDokter::with([
        'pet' => function ($p) {
            $p->withTrashed()->with(['pemilik.user']);
        }
    ])
    ->where('status', 'N')
    ->whereNull('deleted_at')
    ->get();

    // Ambil semua dokter aktif dari role_user
    $dokter = RoleUser::with('user')
        ->where('idrole', 2)   // role = dokter
        ->where('status', 1)   // yang aktif
        ->get();

    // Kode tindakan
    $tindakan = KodeTindakanTerapi::all();

    return view('pageperawat.pageRekamMedis.create', compact('antrian', 'dokter', 'tindakan'));
}


public function store(Request $request)
{
    $request->validate([
        'idreservasi'   => 'required|exists:temu_dokter,idreservasi_dokter',
        'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
        'anamnesa'      => 'required|string',
        'temuan_klinis' => 'required|string',
        'diagnosa'      => 'required|string',
        'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
        'detail' => 'required|string'
    ]);

    // Create rekam medis utama
    $rekam = RekamMedis::create([
        'created_at' => now(),
        'anamnesa' => $request->anamnesa,
        'temuan_klinis' => $request->temuan_klinis,
        'diagnosa' => $request->diagnosa,
        'dokter_pemeriksa' => $request->dokter_pemeriksa,
        'idReservasi_dokter' => $request->idreservasi
    ]);

    // Create detail tindakan pertama
    DetailRekamMedis::create([
        'idrekam_medis' => $rekam->idrekam_medis,
        'idkode_tindakan_terapi' => $request->idkode_tindakan_terapi,
        'detail' => $request->detail
    ]);

    // Update status antrian jadi selesai
    $reservasi = TemuDokter::find($request->idreservasi);
    $reservasi->status = 'S';
    $reservasi->save();

    return redirect()->route('perawat.rekammedis')
        ->with('success', 'Rekam medis berhasil ditambahkan!');
}



    // /** LIST ALL REKAM MEDIS */
    // public function index()
    // {
    //     $rekam = RekamMedis::with(['reservasi.pet', 'dokter'])
    //         ->whereNull('deleted_at')
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return view('pageperawat.pagerekammedis.index', compact('rekam'));
    // }

    // /** CREATE FORM */
    // public function create($idReservasi)
    // {
    //     $reservasi = TemuDokter::with('pet.pemilik.user')->findOrFail($idReservasi);

    //     // Ambil semua dokter aktif
    //     $dokter = User::whereHas('roles', function ($q) {
    //         $q->where('role.idrole', 2)->where('role_user.status', 1);
    //     })->get();

    //     $tindakan = KodeTindakanTerapi::all();

    //     return view('pageperawat.pagerekammedis.create', compact('reservasi', 'dokter', 'tindakan'));
    // }

    // /** STORE REKAM MEDIS + DETAIL */
    // public function store(Request $request, $idReservasi)
    // {
    //     $request->validate([
    //         'anamnesa' => 'required|string',
    //         'temuan_klinis' => 'required|string',
    //         'diagnosa' => 'required|string',
    //         'dokter_pemeriksa' => 'required|exists:user,iduser',
    //         'idkode_tindakan_terapi' => 'required|array',
    //         'detail_tindakan' => 'required|array',
    //     ]);

    //     /** INSERT REKAM MEDIS */
    //     $rekamMedis = RekamMedis::create([
    //         'created_at' => Carbon::now(),
    //         'anamnesa' => $request->anamnesa,
    //         'temuan_klinis' => $request->temuan_klinis,
    //         'diagnosa' => $request->diagnosa,
    //         'dokter_pemeriksa' => $request->dokter_pemeriksa,
    //         'idreservasi_dokter' => $idReservasi,
    //     ]);

    //     /** INSERT DETAIL */
    //     foreach ($request->idkode_tindakan_terapi as $idx => $tindakanId) {
    //         DetailRekamMedis::create([
    //             'idrekam_medis' => $rekamMedis->idrekam_medis,
    //             'idkode_tindakan_terapi' => $tindakanId,
    //             'detail' => $request->detail_tindakan[$idx],
    //         ]);
    //     }

    //     /** SET RESERVASI STATUS DONE */
    //     $reservasi = TemuDokter::find($idReservasi);
    //     $reservasi->update(['status' => 'S']);

    //     return redirect()->route('perawat.rekammedis')->with('success', 'Rekam medis berhasil dibuat!');
    // }

    // /** SHOW DETAIL */
    // public function show($id)
    // {
    //     $rekamMedis = RekamMedis::with(['detail.tindakan', 'dokter', 'reservasi.pet'])
    //         ->findOrFail($id);

    //     return view('pageperawat.rekammedis.show', compact('rekamMedis'));
    // }

    // /** ========================== EDIT FORM ========================== */
    // public function edit($id)
    // {
    //     $rekamMedis = RekamMedis::with(['detail.tindakan', 'reservasi.pet.pemilik.user'])
    //         ->findOrFail($id);

    //     // daftar dokter aktif
    //     $dokter = User::whereHas('roles', function ($q) {
    //         $q->where('role.idrole', 2)->where('role_user.status', 1);
    //     })->get();

    //     // daftar tindakan
    //     $tindakan = KodeTindakanTerapi::all();

    //     return view('pageperawat.pagerekammedis.edit', compact('rekamMedis', 'dokter', 'tindakan'));
    // }

    // /** ========================== UPDATE ========================== */
    // public function update(Request $request, $id)
    // {
    //     $rekam = RekamMedis::findOrFail($id);

    //     $request->validate([
    //         'anamnesa' => 'required|string',
    //         'temuan_klinis' => 'required|string',
    //         'diagnosa' => 'required|string',
    //         'dokter_pemeriksa' => 'required|exists:user,iduser',

    //         // detail rekam medis
    //         'idkode_tindakan_terapi' => 'required|array',
    //         'idkode_tindakan_terapi.*' => 'exists:kode_tindakan_terapi,idkode_tindakan_terapi',

    //         'detail_tindakan' => 'required|array',
    //         'detail_tindakan.*' => 'string',
    //     ]);

    //     /** ===================== 
    //      *  UPDATE REKAM MEDIS 
    //      * ===================== */
    //     $rekam->update([
    //         'anamnesa' => $request->anamnesa,
    //         'temuan_klinis' => $request->temuan_klinis,
    //         'diagnosa' => $request->diagnosa,
    //         'dokter_pemeriksa' => $request->dokter_pemeriksa,
    //     ]);

    //     /** ==============================
    //      *  UPDATE DETAIL REKAM MEDIS
    //      *  HAPUS - EDIT - TAMBAH
    //      * ============================== */

    //     // hapus semua detail lama
    //     DetailRekamMedis::where('idrekam_medis', $rekam->idrekam_medis)->delete();

    //     // tambahkan detail yang baru
    //     foreach ($request->idkode_tindakan_terapi as $i => $idTindakan) {
    //         DetailRekamMedis::create([
    //             'idrekam_medis' => $rekam->idrekam_medis,
    //             'idkode_tindakan_terapi' => $idTindakan,
    //             'detail' => $request->detail_tindakan[$i],
    //         ]);
    //     }

    //     return redirect()->route('perawat.rekammedis.detail', $rekam->idrekam_medis)
    //         ->with('success', 'Rekam medis berhasil diperbarui!');
    // }


    // /** SOFT DELETE */
    // public function destroy($id)
    // {
    //     $rekam = RekamMedis::findOrFail($id);
    //     $rekam->deleted_by = Auth::id();
    //     $rekam->save();
    //     $rekam->delete();

    //     return back()->with('success', 'Rekam medis berhasil dihapus!');
    // }
}
