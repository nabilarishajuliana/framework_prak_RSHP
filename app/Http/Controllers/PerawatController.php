<?php

namespace App\Http\Controllers;

use App\Models\Perawat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerawatController extends Controller
{
    /** INDEX */
    public function index()
    {
        $perawat = Perawat::with('user')
            ->whereNull('deleted_at')
            ->get();

        return view('pageadmin.pageperawat.index', compact('perawat'));
    }

    /** CREATE */
    public function create()
    {
        return view('pageadmin.pageperawat.create');
    }

    /** STORE */
    public function store(Request $request)
    {
        $validated = $this->validatePerawatCreate($request);

        // 1️⃣ Create User dulu
        $user = User::create([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        // 2️⃣ Tambahkan role perawat (idrole = 3)
        $user->roles()->attach(3, ['status' => 1]);

        // 3️⃣ Insert ke tabel perawat
        Perawat::create([
            'iduser' => $user->iduser,
            'jenis_kelamin' => strtoupper($validated['jenis_kelamin']),
            'alamat' => ucwords(trim($validated['alamat'])),
            'no_hp' => $validated['no_hp'],
            'pendidikan' => ucwords(trim($validated['pendidikan'])),
        ]);

        return redirect()->route('admin.perawat')->with('success', 'Perawat baru berhasil ditambahkan!');
    }

    /** EDIT */
    public function edit($id)
    {
        $perawat = Perawat::with('user')->findOrFail($id);
        return view('pageadmin.pageperawat.edit', compact('perawat'));
    }

    /** UPDATE */
    public function update(Request $request, $id)
    {
        $perawat = Perawat::with('user')->findOrFail($id);

        $validated = $this->validatePerawatUpdate($request, $perawat->iduser);

        // Update user
        $perawat->user->update([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower(trim($validated['email'])),
            'password' => $validated['password'] ? Hash::make($validated['password']) : $perawat->user->password,
        ]);

        // Update perawat
        $perawat->update([
            'jenis_kelamin' => strtoupper($validated['jenis_kelamin']),
            'alamat' => ucwords(trim($validated['alamat'])),
            'no_hp' => $validated['no_hp'],
            'pendidikan' => ucwords(trim($validated['pendidikan'])),
        ]);

        return redirect()->route('admin.perawat')->with('success', 'Data perawat berhasil diperbarui!');
    }

    /** DESTROY (Soft Delete) */
    public function destroy($id)
    {
        $perawat = Perawat::findOrFail($id);
        $idUser = $perawat->iduser;

        $perawat->update([
            'deleted_at' => now(),
            'deleted_by' => session('user_id'),
        ]);

        $user = User::find($idUser);
        if ($user) {
            $user->update([
                'deleted_at' => now(),
                'deleted_by' => session('user_id'),
            ]);
        }

        return redirect()->route('admin.perawat')->with('success', 'Data perawat berhasil dihapus (soft delete)!');
    }

    /* ============================
       VALIDATION
    ============================ */

    private function validatePerawatCreate($request)
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:5',

            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'pendidikan' => 'required|string|max:100',
        ]);
    }

    private function validatePerawatUpdate($request, $userId)
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => "required|email|unique:user,email,$userId,iduser",
            'password' => 'nullable|min:5',

            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'pendidikan' => 'required|string|max:100',
        ]);
    }
}
