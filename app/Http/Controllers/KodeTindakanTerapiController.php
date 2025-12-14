<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\KodeTindakanTerapi;
use App\Models\Kategori;
use App\Models\KategoriKlinis;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        // Ambil semua data beserta relasi kategori dan kategori klinis
        $kodeTindakan = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get();

        return view('pageadmin.pagekodetindakan.index', compact('kodeTindakan'));
    }

    /** 🔹 Form tambah data */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $kategoriKlinis = KategoriKlinis::orderBy('nama_kategori_klinis')->get();

        return view('pageadmin.pagekodetindakan.create', compact('kategori', 'kategoriKlinis'));
    }

    /** 🔹 Simpan data baru */
    public function store(Request $request)
    {
        $validated = $this->validateTindakan($request);

        KodeTindakanTerapi::create([
            'kode' => strtoupper(trim($validated['kode'])),
            'deskripsi_tindakan_terapi' => $this->formatDeskripsi($validated['deskripsi_tindakan_terapi']),
            'idkategori' => $validated['idkategori'],
            'idkategori_klinis' => $validated['idkategori_klinis']
        ]);

        return redirect()->route('admin.kode.tindakan')
            ->with('success', 'Kode tindakan terapi berhasil ditambahkan!');
    }

    /** 🔹 Form edit data */
    public function edit($id)
    {
        $tindakan = KodeTindakanTerapi::findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $kategoriKlinis = KategoriKlinis::orderBy('nama_kategori_klinis')->get();

        return view('pageadmin.pagekodetindakan.edit', compact('tindakan', 'kategori', 'kategoriKlinis'));
    }

    /** 🔹 Update data */
    public function update(Request $request, $id)
    {
        $validated = $this->validateTindakan($request, true, $id);


        $tindakan = KodeTindakanTerapi::findOrFail($id);
        $tindakan->update([
            'kode' => strtoupper(trim($validated['kode'])),
            'deskripsi_tindakan_terapi' => $this->formatDeskripsi($validated['deskripsi_tindakan_terapi']),
            'idkategori' => $validated['idkategori'],
            'idkategori_klinis' => $validated['idkategori_klinis']
        ]);

        return redirect()->route('admin.kode.tindakan')
            ->with('success', 'Data tindakan terapi berhasil diperbarui!');
    }

    /** 🔹 Hapus data */
    public function destroy($id)
    {
        $tindakan = KodeTindakanTerapi::findOrFail($id);

        // 🔒 Cegah hapus jika masih dipakai rekam medis
        if ($tindakan->detail()->whereNull('deleted_at')->exists()) {
            return redirect()->route('admin.kode.tindakan')
                ->with('error', 'Kode tindakan tidak bisa dihapus karena masih digunakan pada rekam medis.');
        }

        // 🔥 isi deleted_by
        $tindakan->deleted_by = Auth::id();
        $tindakan->save();

        // soft delete
        $tindakan->delete();

        return redirect()->route('admin.kode.tindakan')
            ->with('success', 'Kode tindakan terapi berhasil dihapus!');
    }


    /* =====================================================
     * 🔒 PRIVATE: Helper & Validation
     * ===================================================== */

    /** ✅ Validasi data input */

    private function validateTindakan(Request $request, $isUpdate = false, $id = null): array
    {
        // kalau update, ambil id yang sedang diubah
        $id = $id ?? $request->idkode_tindakan_terapi;

        // rule unik akan menyesuaikan otomatis
        $uniqueRule = 'unique:kode_tindakan_terapi,kode';
        if ($isUpdate && $id) {
            $uniqueRule .= ',' . $id . ',idkode_tindakan_terapi';
        }

        return $request->validate([
            'kode' => ['required', 'string', 'max:20', $uniqueRule],
            'deskripsi_tindakan_terapi' => ['required', 'string', 'max:255'],
            'idkategori' => ['required', 'exists:kategori,idkategori'],
            'idkategori_klinis' => ['required', 'exists:kategori_klinis,idkategori_klinis'],
        ], [
            'kode.required' => 'Kode wajib diisi.',
            'kode.unique' => 'Kode sudah terdaftar.',
            'deskripsi_tindakan_terapi.required' => 'Deskripsi tindakan wajib diisi.',
            'idkategori.required' => 'Pilih kategori.',
            'idkategori_klinis.required' => 'Pilih kategori klinis.',
        ]);
    }


    /** ✨ Helper format deskripsi */
    private function formatDeskripsi(string $text): string
    {
        return ucfirst(trim($text));
    }
}
