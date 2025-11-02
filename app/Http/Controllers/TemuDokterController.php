<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemuDokter;
use Illuminate\Support\Facades\DB;

class TemuDokterController extends Controller
{
        public function index()
    {
        $today = now()->toDateString();

        $temuDokter = TemuDokter::with(['pet.pemilik.user'])
            ->whereDate('waktu_daftar', $today)
            ->orderByDesc('waktu_daftar')
            ->orderBy('no_urut')
            ->get();

        return view('pageresepsionis.pagetemudokter.index', compact('temuDokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpet' => 'required|integer|exists:pet,idpet',
        ]);

        $idrole_user = session('idrole_user');

        DB::beginTransaction();
        try {
            $next_no = TemuDokter::whereDate('waktu_daftar', now()->toDateString())
                ->max('no_urut') + 1;

            TemuDokter::create([
                'no_urut' => $next_no,
                'waktu_daftar' => now(),
                'status' => 'N',
                'idpet' => $request->idpet,
                'idrole_user' => $idrole_user,
            ]);

            DB::commit();
            return redirect()->route('resepsionis.temu.dokter')->with('success', 'Pendaftaran berhasil!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus($id, $status)
    {
        $valid = ['N', 'S', 'B'];
        if (!in_array($status, $valid)) {
            return back()->with('error', 'Status tidak valid.');
        }

        TemuDokter::where('idreservasi_dokter', $id)->update(['status' => $status]);
        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy($id)
    {
        TemuDokter::findOrFail($id)->delete();
        return back()->with('success', 'Antrian berhasil dihapus.');
    }
}
