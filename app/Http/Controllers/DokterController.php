<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    /** INDEX */
    public function index()
    {
        $dokter = Dokter::with('user')->get(); // Soft delete sudah otomatis

        return view('pageadmin.pagedokter.index', compact('dokter'));
    }


    /** CREATE */
    public function create()
    {
        return view('pageadmin.pagedokter.create');
    }

    /** STORE */
    public function store(Request $request)
    {
        $validated = $this->validateDokterCreate($request);

        // 1. Create user terlebih dahulu
        $user = User::create([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
        ]);

        /** 🔥 OTOMATIS DAFTAR KE ROLE_USER
         *  idrole = 2 → Role Dokter
         *  status = 1 → Aktif
         */
        $user->roles()->attach(2, [
            'status' => 1
        ]);

        // 2. Insert ke tabel dokter
        Dokter::create([
            'iduser' => $user->iduser,
            'jenis_kelamin' => strtoupper($validated['jenis_kelamin']),
            'alamat' => ucwords(trim($validated['alamat'])),
            'no_hp' => $validated['no_hp'],
            'bidang_dokter' => ucwords(trim($validated['bidang_dokter'])),
        ]);

        return redirect()->route('admin.dokter')->with('success', 'Dokter baru berhasil ditambahkan!');
    }

    /** EDIT */
    public function edit($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('pageadmin.pagedokter.edit', compact('dokter'));
    }

    /** UPDATE */
    public function update(Request $request, $id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);

        $validated = $this->validateDokterUpdate($request, $dokter->iduser);

        // Update user
        $dokter->user->update([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower($validated['email']),
            'password' => $validated['password'] ? Hash::make($validated['password']) : $dokter->user->password,
        ]);

        // Update dokter
        $dokter->update([
            'jenis_kelamin' => strtoupper($validated['jenis_kelamin']),
            'alamat' => ucwords(trim($validated['alamat'])),
            'no_hp' => $validated['no_hp'],
            'bidang_dokter' => ucwords(trim($validated['bidang_dokter'])),
        ]);

        return redirect()->route('admin.dokter')->with('success', 'Data dokter berhasil diperbarui!');
    }

    /** DELETE (Soft Delete) */
    public function destroy($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);

        // 🔥 delete USER (cascade ke dokter, role_user, dll)
        $dokter->user->deleted_by = Auth::id();
        $dokter->user->save();
        $dokter->user->delete();

        return redirect()->route('admin.dokter')
            ->with('success', 'Dokter dan akun user berhasil dihapus.');
    }

    

    /* ============================================================
     * VALIDATION
     * ============================================================ */

    private function validateDokterCreate($request)
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:5',

            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'bidang_dokter' => 'required|string|max:100'
        ]);
    }

    private function validateDokterUpdate($request, $userId)
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => "required|email|unique:user,email,$userId,iduser",
            'password' => 'nullable|min:5',

            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'bidang_dokter' => 'required|string|max:100'
        ]);
    }
}
