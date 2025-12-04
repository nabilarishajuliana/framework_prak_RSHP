<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\TemuDokter;
use App\Models\Pet;

class TemuDokterController extends Controller
{
    function isRole($role)
    {
        return strtolower(session('user_role_name')) === strtolower($role);
    }

    /** ========================== INDEX ========================== */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today'); // default: today

        if ($filter === 'all') {
            $antrian = TemuDokter::with('pet')
                ->whereNull('deleted_at')
                ->orderBy('waktu_daftar', 'desc')
                ->get();
        } else {
            // hari ini
            $today = Carbon::today();

            $antrian = TemuDokter::with('pet')
                ->whereNull('deleted_at')
                ->whereDate('waktu_daftar', $today)
                ->orderBy('no_urut', 'asc')
                ->get();
        }

        if ($this->isRole('administrator')) {
            return view('pageadmin.pagetemudokter.index', compact('antrian', 'filter'));
        }
// dd(vars: $antrian);
        return view('pageresepsionis.pagetemudokter.index', compact('antrian', 'filter'));
    }

    /** ========================== CREATE FORM ========================== */
    public function create()
    {
        $pets = Pet::with(['pemilik.user'])->get();

        if ($this->isRole('administrator')) {
            return view('pageadmin.pagetemudokter.create', compact('pets'));
        }

        return view('pageresepsionis.pagetemudokter.create', compact('pets'));
    }

    /** ========================== STORE (AUTO LOGIC) ========================== */
    public function store(Request $request)
    {
        $request->validate([
            'idpet' => 'required|exists:pet,idpet'
        ]);

        // Nomor urut berdasarkan hari ini
        $today = Carbon::today();

        $last = TemuDokter::whereDate('waktu_daftar', $today)
            ->whereNull('deleted_at')
            ->max('no_urut');

        $noUrut = $last ? $last + 1 : 1;

        TemuDokter::create([
            'no_urut'      => $noUrut,
            'waktu_daftar' => Carbon::now(),
            'status'       => 'N',
            'idpet'        => $request->idpet,
            'idrole_user'  => session('idrole_user'),
        ]);

        if ($this->isRole('administrator')) {
            return redirect()->route('admin.temu')->with('success', 'Antrian berhasil ditambahkan!');
        }

        return redirect()->route('resepsionis.temu')->with('success', 'Antrian berhasil ditambahkan!');
    }

    /** ========================== UPDATE STATUS ========================== */
    public function updateStatus($id, $status)
    {
        $valid = ['N', 'S'];
        if (!in_array($status, $valid)) {
            return back()->with('error', 'Status tidak valid!');
        }

        $antrian = TemuDokter::findOrFail($id);
        $antrian->update(['status' => $status]);

        return back()->with('success', 'Status antrian berhasil diperbarui!');
    }

    /** ========================== DELETE (SOFT DELETE) ========================== */
    public function destroy($id)
    {
        $antrian = TemuDokter::findOrFail($id);
        $antrian->deleted_by = Auth::id();
        $antrian->save();
        $antrian->delete();

        return back()->with('success', 'Data antrian berhasil dihapus!');
    }
}
