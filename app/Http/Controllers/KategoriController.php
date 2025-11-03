<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
     public function index()
    {
        $kategori = Kategori::all();
        return view('pageadmin.pagekategori.index', compact('kategori'));
    }

    /** 🔹 Form tambah kategori */
    public function create()
    {
        return view('pageadmin.pagekategori.create');
    }

    /** 🔹 Simpan data baru */
    public function store(Request $request)
    {
        $validated = $this->validateKategori($request);

        Kategori::create([
            'nama_kategori' => $this->formatNamaKategori($validated['nama_kategori'])
            
        ]);

        return redirect()->route('admin.kategori')
                         ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /** 🔹 Form edit kategori */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('pageadmin.pagekategori.edit', compact('kategori'));
    }

    /** 🔹 Update kategori */
    public function update(Request $request, $id)
    {
        $validated = $this->validateKategori($request);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $this->formatNamaKategori($validated['nama_kategori'])
            
        ]);

        return redirect()->route('admin.kategori')
                         ->with('success', 'Kategori berhasil diperbarui!');
    }

    /** 🔹 Hapus kategori */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori')
                         ->with('success', 'Kategori berhasil dihapus!');
    }

    /* =====================================================
     * 🔒 PRIVATE: Helper & Validation
     * ===================================================== */

    /** ✅ Validasi data */
    private function validateKategori(Request $request): array
    {
        return $request->validate([
            'nama_kategori' => 'required|string|max:50',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
            'nama_kategori.max' => 'Nama kategori maksimal 50 karakter.',
        ]);
    }

    /** ✨ Helper format nama kategori */
    private function formatNamaKategori(string $nama): string
    {
        return ucwords(trim($nama));
    }
}
