<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisHewan;


class JenisHewanController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel jenis_hewan
        $jenisHewan = JenisHewan::all();

        // Kirim ke view
        return view('pageadmin.pageJenisHewan.index', compact('jenisHewan'));
    }

    /** Menampilkan form create */
    public function create()
    {
        return view('pageadmin.pagejenishewan.create');
    }

     public function store(Request $request)
    {
        // 🔒 Panggil fungsi validasi private
        $validatedData = $this->validateJenisHewan($request);

        // ✨ Simpan data dengan nama yang sudah diformat dari helper
        JenisHewan::create([
            'nama_jenis_hewan' => $this->formatNamaJenisHewan($validatedData['nama_jenis_hewan']),
        ]);

        return redirect()->route('admin.jenis.hewan')
                         ->with('success', 'Jenis hewan berhasil ditambahkan!');
    }

    /** 
     * 🟢 Menampilkan form edit data 
     */
    public function edit($id)
    {
        $jenisHewan = JenisHewan::findOrFail($id);
        return view('pageadmin.pagejenishewan.edit', compact('jenisHewan'));
    }

    /** 
     * 🟢 Menyimpan hasil update data 
     */
    public function update(Request $request, $id)
    {
        $validatedData = $this->validateJenisHewan($request);

        $jenisHewan = JenisHewan::findOrFail($id);
        $jenisHewan->update([
            'nama_jenis_hewan' => $this->formatNamaJenisHewan($validatedData['nama_jenis_hewan']),
        ]);

        return redirect()->route('admin.jenis.hewan')
                         ->with('success', 'Data berhasil diperbarui!');
    }

    /** 
     * 🟢 Menghapus data 
     */
    public function destroy($id)
    {
        $jenisHewan = JenisHewan::findOrFail($id);
        $jenisHewan->delete();

        return redirect()->route('admin.jenis.hewan')
                         ->with('success', 'Data berhasil dihapus!');
    }

    /* =====================================================
     * 🔒 Private Functions (Helper & Validation)
     * ===================================================== */

    /**
     * 🔍 Private function untuk validasi data
     */
    private function validateJenisHewan(Request $request): array
    {
        return $request->validate([
            'nama_jenis_hewan' => 'required|string|max:50',
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.string' => 'Nama jenis hewan harus berupa teks.',
            'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 50 karakter.',
        ]);
    }

    /**
     * ✨ Private helper untuk format nama
     * (Contoh: “anjing kampung” → “Anjing Kampung”)
     */
    private function formatNamaJenisHewan(string $nama): string
    {
        // Hilangkan spasi berlebih & kapital di awal kata
        return ucwords(trim($nama));
    }

    /** Simpan data jenis hewan baru */
    // public function store(Request $request)
    // {
    //     $this->validateJenisHewan($request);

    //     $this->createJenisHewan($request);

    //     return redirect()
    //         ->route('admin.jenis.hewan')
    //         ->with('success', 'Jenis hewan berhasil ditambahkan!');
    // }

    /** 🔹 VALIDASI INPUT */
    // private function validateJenisHewan(Request $request)
    // {
    //     $request->validate([
    //         'nama_jenis_hewan' => 'required|string|max:100|unique:jenis_hewan,nama_jenis_hewan',
    //     ], [
    //         'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
    //         'nama_jenis_hewan.unique' => 'Jenis hewan sudah terdaftar.',
    //     ]);
    // }

    /** 🔹 HELPER: Format nama sebelum disimpan */
    // private function formatNamaJenisHewan($nama)
    // {
    //     return ucwords(strtolower(trim($nama)));
    // }

    /** 🔹 HELPER: Create record */
    // private function createJenisHewan(Request $request)
    // {
    //     JenisHewan::create([
    //         'nama_jenis_hewan' => $this->formatNamaJenisHewan($request->nama_jenis_hewan),
    //     ]);
    // }
}
