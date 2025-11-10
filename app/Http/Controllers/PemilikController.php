<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\User;

class PemilikController extends Controller
{
    public function index()
    {
        // Ambil semua data pemilik, lengkap dengan user & pet
        $pemilik = Pemilik::with(['user', 'pet'])->get();

        return view('pageadmin.pagepemilik.index', compact('pemilik'));
    }

    public function pemilikResepsionis()
    {
        // Ambil semua data pemilik, lengkap dengan user & pet
        $pemilik = Pemilik::with(['user', 'pet'])->get();

        return view('pageresepsionis.pagepemilik.index', compact('pemilik'));
    }

    /** 🔹 Form tambah data */
    public function create()
    {
        $user = User::orderBy('nama')->get();
        return view('pageadmin.pagepemilik.create', compact('user'));
    }

    /** 🔹 Simpan data baru */
    public function store(Request $request)
    {
        // Validasi gabungan user + pemilik
        $validated = $this->validatePemilikGabung($request);

        // Simpan data ke tabel user dulu
        $user = User::create([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower(trim($validated['email'])),
            'password' => bcrypt($validated['password']), // disimpan hash
        ]);

        // Simpan data ke tabel pemilik, pakai iduser dari user yang baru dibuat
        Pemilik::create([
            'alamat' => ucwords(trim($validated['alamat'])),
            'no_wa' => $validated['no_wa'],
            'iduser' => $user->iduser,
        ]);

        return redirect()->route('admin.pemilik')->with('success', 'Pemilik & user baru berhasil ditambahkan!');
    }


    /** 🔹 Form edit */
    public function edit($id)
    {
        $pemilik = Pemilik::with('user')->findOrFail($id);
        return view('pageadmin.pagepemilik.edit', compact('pemilik'));
    }

    public function update(Request $request, $id)
    {
        $pemilik = Pemilik::with('user')->findOrFail($id);
        $validated = $this->validatePemilikGabungUpdate($request, $pemilik->user->iduser);

        // 🔹 Update data user
        $pemilik->user->update([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower(trim($validated['email'])),
            // password hanya diubah jika diisi baru
            'password' => $validated['password'] ? bcrypt($validated['password']) : $pemilik->user->password,
        ]);

        // 🔹 Update data pemilik
        $pemilik->update([
            'alamat' => ucwords(trim($validated['alamat'])),
            'no_wa' => $validated['no_wa'],
        ]);

        return redirect()->route('admin.pemilik')
            ->with('success', 'Data pemilik & user berhasil diperbarui!');
    }


    /** 🔹 Hapus data */
    public function destroy($id)
    {
        $pemilik = Pemilik::findOrFail($id);
        $iduser=$pemilik->iduser;
        $pemilik->delete();
        $user = user::findOrFail($iduser);
        $user->delete();

        return redirect()->route('admin.pemilik')->with('success', 'Data pemilik berhasil dihapus!');
    }

    /* =====================================================
     * 🔒 PRIVATE: Helper & Validation
     * ===================================================== */

    /** ✅ Validasi input */
    private function validatePemilik(Request $request): array
    {
        return $request->validate([
            'alamat' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15|regex:/^[0-9]+$/',
            'iduser' => 'required|exists:user,iduser',
        ], [
            'alamat.required' => 'Alamat wajib diisi.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'iduser.required' => 'Pilih user pemilik.',
        ]);
    }

    /** ✨ Helper format alamat */
    private function formatAlamat(string $alamat): string
    {
        return ucwords(trim($alamat));
    }

    private function validatePemilikGabung(Request $request): array
    {
        return $request->validate([
            // data user
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:5',
            // data pemilik
            'alamat' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15|regex:/^[0-9]+$/',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'email.email' => 'Format email tidak valid',
        ]);
    }

    private function validatePemilikGabungUpdate(Request $request, $userId): array
{
    return $request->validate([
        // data user
        'nama' => 'required|string|max:100',
        'email' => 'required|email|unique:user,email,' . $userId . ',iduser',
        'password' => 'nullable|min:5',
        // data pemilik
        'alamat' => 'required|string|max:255',
        'no_wa' => 'required|string|max:15|regex:/^[0-9]+$/',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.unique' => 'Email sudah digunakan oleh user lain.',
        'alamat.required' => 'Alamat wajib diisi.',
        'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
    ]);
}

}
