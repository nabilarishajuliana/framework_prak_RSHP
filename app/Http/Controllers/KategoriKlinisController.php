<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\KategoriKlinis;

class KategoriKlinisController extends Controller
{
    public function index()
    {
        $kategoriKlinis = KategoriKlinis::all();
        return view('pageadmin.pagekategoriklinis.index', compact('kategoriKlinis'));
    }

    /** 🔹 Tampilkan form tambah */
    public function create()
    {
        return view('pageadmin.pagekategoriklinis.create');
    }

    /** 🔹 Simpan data baru */
    public function store(Request $request)
    {
        $validated = $this->validateKategoriKlinis($request);

        KategoriKlinis::create([
            'nama_kategori_klinis' => $this->formatNamaKlinis($validated['nama_kategori_klinis']),
        ]);

        return redirect()->route('admin.kategori.klinis')
            ->with('success', 'Kategori Klinis berhasil ditambahkan!');
    }

    /** 🔹 Form edit */
    public function edit($id)
    {
        $kategoriKlinis = KategoriKlinis::findOrFail($id);
        return view('pageadmin.pagekategoriklinis.edit', compact('kategoriKlinis'));
    }

    /** 🔹 Update data */
    public function update(Request $request, $id)
    {
        $validated = $this->validateKategoriKlinis($request);

        $kategoriKlinis = KategoriKlinis::findOrFail($id);
        $kategoriKlinis->update([
            'nama_kategori_klinis' => $this->formatNamaKlinis($validated['nama_kategori_klinis']),
        ]);

        return redirect()->route('admin.kategori.klinis')
            ->with('success', 'Kategori Klinis berhasil diperbarui!');
    }

    /** 🔹 Hapus data */
    public function destroy($id)
    {
        $kategoriKlinis = KategoriKlinis::findOrFail($id);

        // 🔒 Cegah hapus jika masih dipakai
        if ($kategoriKlinis->kodeTindakanTerapi()->whereNull('deleted_at')->exists()) {
            return redirect()->route('admin.kategori.klinis')
                ->with('error', 'Kategori klinis tidak bisa dihapus karena masih digunakan oleh kode tindakan.');
        }

        // 🔥 isi deleted_by
        $kategoriKlinis->deleted_by = Auth::id();
        $kategoriKlinis->save();

        // soft delete
        $kategoriKlinis->delete();

        return redirect()->route('admin.kategori.klinis')
            ->with('success', 'Kategori klinis berhasil dihapus!');
    }


    /* =====================================================
     * 🔒 PRIVATE: Helper & Validation
     * ===================================================== */

    /** ✅ Validasi input */
    private function validateKategoriKlinis(Request $request): array
    {
        return $request->validate([
            'nama_kategori_klinis' => 'required|string|max:100',
        ], [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi.',
            'nama_kategori_klinis.string' => 'Nama kategori klinis harus berupa teks.',
            'nama_kategori_klinis.max' => 'Nama kategori klinis maksimal 100 karakter.',
        ]);
    }

    /** ✨ Helper format nama klinis */
    private function formatNamaKlinis(string $nama): string
    {
        return ucwords(trim($nama));
    }
}
