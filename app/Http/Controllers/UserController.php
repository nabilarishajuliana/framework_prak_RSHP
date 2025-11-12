<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /** 🔹 Tampilkan semua user */
    public function index()
    {
        $users = User::with(['roles', 'pemilik'])->get();
        $roles = Role::all();
        return view('pageadmin.pageuser.index', compact('users', 'roles'));
    }

    /** 🔹 Form create user */
    public function create()
    {
        $roles = Role::all();
        return view('pageadmin.pageuser.create', compact('roles'));
    }

    /** 🔹 Simpan user baru + role */
    public function store(Request $request)
    {
        $validated = $this->validateUser($request);

        try {
            // Simpan ke tabel user
            $user = User::create([
                'nama' => ucwords(trim($validated['nama'])),
                'email' => strtolower(trim($validated['email'])),
                'password' => Hash::make($validated['password']),
            ]);

            // Kalau ada role dipilih → masuk ke pivot role_user
            if ($request->filled('role')) {
                $user->roles()->attach($request->role, ['status' => 1]);
            }

            return redirect()->route('admin.user')->with('success', 'User baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user')->with('error', 'Terjadi kesalahan saat menambahkan user.');
        }
    }

    /** 🔹 Form edit user */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('pageadmin.pageuser.edit', compact('user', 'roles'));
    }

    /** 🔹 Update data user */
    public function update(Request $request, $id)
    {
        $validated = $this->validateUserUpdate($request, $id);
        $user = User::findOrFail($id);

        $user->update([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower(trim($validated['email'])),
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $user->password,
        ]);

        return redirect()->route('admin.user')->with('success', 'Data user berhasil diperbarui!');
    }

    /** 🔹 Hapus user */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->roles()->detach();

            if ($user->pemilik) {
                $user->pemilik()->delete();
            }

            $user->delete();

            return redirect()->route('admin.user')->with('success', 'User berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect()->route('admin.user')
                ->with('error', 'Gagal menghapus user. Pastikan user tidak terhubung dengan data lain.');
        }
    }

    /** 🔹 Ganti role aktif */
    public function switchRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:role,idrole',
        ], [
            'role_id.required' => 'Pilih role yang ingin diaktifkan terlebih dahulu.',
        ]);

        $user = User::findOrFail($id);
        $user->setActiveRole($request->role_id);

        return redirect()->route('admin.user')->with('success', 'Role aktif user berhasil diubah!');
    }

    /* ===================================================
     * 🔒 VALIDATION
     * =================================================== */

    private function validateUser(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:5',
            'role' => 'nullable|exists:role,idrole',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);
    }

    private function validateUserUpdate(Request $request, $id): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email,' . $id . ',iduser',
            'password' => 'nullable|min:5',
        ]);
    }
}
