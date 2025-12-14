<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\JenisHewan;
use Illuminate\Support\Facades\DB; // ✅ pakai Query Builder, bukan Eloquent


class JenisHewanController extends Controller
{
    public function index()
    {
        $jenisHewan = JenisHewan::all();

        return view('pageadmin.pagejenishewan.index', compact('jenisHewan'));
    }


// // INI PAKAI QUERY BUILDER
//     public function index()
//     {
//         $jenisHewan = DB::table('jenis_hewan')->select('idjenis_hewan', 'nama_jenis_hewan')->get();

//         return view('pageadmin.pagejenishewan.index', compact('jenisHewan'));
        
//     }

    /** Menampilkan form create */
    public function create()
    {
        return view('pageadmin.pagejenishewan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateJenisHewan($request);

        JenisHewan::create([
            'nama_jenis_hewan' => $this->formatNamaJenisHewan($validatedData['nama_jenis_hewan']),
        ]);

        return redirect()->route('admin.jenis.hewan')
            ->with('success', 'Jenis hewan berhasil ditambahkan!');
    }


// INI STORE PAKAI QUERY BUILDER
    //  public function store(Request $request)
    // {
        

    //      $validatedData = $this->validateJenisHewan($request);

    //     // Insert data pakai Query Builder
    //     DB::table('jenis_hewan')->insert([
    //         'nama_jenis_hewan' => $this->formatNamaJenisHewan($validatedData['nama_jenis_hewan']),
    //     ]);

    //     return redirect()->route('admin.jenis.hewan')
    //                      ->with('success', 'Jenis hewan berhasil ditambahkan!');
    // }

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

        // 🔒 Cegah hapus jika masih ada ras aktif
        if ($jenisHewan->rasHewan()->whereNull('deleted_at')->exists()) {
            return redirect()->route('admin.jenis.hewan')
                ->with('error', 'Jenis hewan tidak bisa dihapus karena masih memiliki ras.');
        }

        // 🔥 isi deleted_by
        $jenisHewan->deleted_by = Auth::id();
        $jenisHewan->save();

        // soft delete
        $jenisHewan->delete();

        return redirect()->route('admin.jenis.hewan')
            ->with('success', 'Jenis hewan berhasil dihapus!');
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
}
