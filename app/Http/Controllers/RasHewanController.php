<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\RasHewan;
use App\Models\JenisHewan;

class RasHewanController extends Controller
{
    public function index()
    {
        // Ambil data ras hewan dan relasi jenis hewan
        $rasHewan = RasHewan::with('jenisHewan')->get();

        return view('pageadmin.pagerashewan.index', compact('rasHewan'));
    }

    /** 🔹 Form tambah ras */
    public function create()
    {
        $jenisHewan = JenisHewan::orderBy('nama_jenis_hewan')->get();
        return view('pageadmin.pagerashewan.create', compact('jenisHewan'));
    }

    /** 🔹 Simpan data baru */
    public function store(Request $request)
    {
        $validated = $this->validateRasHewan($request);

        RasHewan::create([
            'nama_ras' => $this->formatNamaRas($validated['nama_ras']),
            'idjenis_hewan' => $validated['idjenis_hewan'],
        ]);

        return redirect()->route('admin.ras.hewan')
            ->with('success', 'Ras hewan berhasil ditambahkan!');
    }

    /** 🔹 Form edit */
    public function edit($id)
    {
        $rasHewan = RasHewan::findOrFail($id);
        $jenisHewan = JenisHewan::orderBy('nama_jenis_hewan')->get();

        return view('pageadmin.pagerashewan.edit', compact('rasHewan', 'jenisHewan'));
    }

    /** 🔹 Update data */
    public function update(Request $request, $id)
    {
        $validated = $this->validateRasHewan($request);

        $rasHewan = RasHewan::findOrFail($id);
        $rasHewan->update([
            'nama_ras' => $this->formatNamaRas($validated['nama_ras']),
            'idjenis_hewan' => $validated['idjenis_hewan'],
        ]);

        return redirect()->route('admin.ras.hewan')
            ->with('success', 'Data ras berhasil diperbarui!');
    }

    /** 🔹 Hapus data */
    public function destroy($id)
    {
        $rasHewan = RasHewan::findOrFail($id);

        // 🔒 Cegah hapus jika masih dipakai pet
        if ($rasHewan->pet()->whereNull('deleted_at')->exists()) {
            return redirect()->route('admin.ras.hewan')
                ->with('error', 'Ras hewan tidak bisa dihapus karena masih digunakan oleh pet.');
        }

        // 🔥 isi deleted_by
        $rasHewan->deleted_by = Auth::id();
        $rasHewan->save();

        $rasHewan->delete();

        return redirect()->route('admin.ras.hewan')
            ->with('success', 'Ras hewan berhasil dihapus!');
    }


    /* =====================================================
     * 🔒 PRIVATE: Helper & Validation
     * ===================================================== */

    /** ✅ Validasi data */
    private function validateRasHewan(Request $request): array
    {
        return $request->validate([
            'nama_ras' => 'required|string|max:50',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ], [
            'nama_ras.required' => 'Nama ras wajib diisi.',
            'nama_ras.string' => 'Nama ras harus berupa teks.',
            'nama_ras.max' => 'Nama ras maksimal 50 karakter.',
            'idjenis_hewan.required' => 'Pilih jenis hewan.',
            'idjenis_hewan.exists' => 'Jenis hewan tidak ditemukan di database.',
        ]);
    }

    /** ✨ Helper untuk format nama ras */
    private function formatNamaRas(string $nama): string
    {
        return ucwords(trim($nama));
    }
}
