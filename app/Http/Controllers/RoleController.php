<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
     public function index()
    {
        // Ambil semua role + relasi ke role_user
        $roles = Role::with('users')->get();

        return view('pageadmin.pagerole.index', compact('roles'));
    }

        /** 🔹 Form tambah role */
    public function create()
    {
        return view('pageadmin.pagerole.create');
    }

    /** 🔹 Simpan role baru */
    public function store(Request $request)
    {
        $validated = $this->validateRole($request);
        Role::create($validated);

        return redirect()->route('admin.role')->with('success', 'Role baru berhasil ditambahkan!');
    }

    /** 🔹 Form edit role */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('pageadmin.pagerole.edit', compact('role'));
    }

    /** 🔹 Update role */
    public function update(Request $request, $id)
    {
        $validated = $this->validateRole($request, true, $id);
        $role = Role::findOrFail($id);
        $role->update($validated);

        return redirect()->route('admin.role')->with('success', 'Role berhasil diperbarui!');
    }

    /** 🔹 Hapus role */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.role')->with('error', 'Role tidak bisa dihapus karena masih digunakan oleh user.');
        }

        $role->delete();

        return redirect()->route('admin.role')->with('success', 'Role berhasil dihapus!');
    }

    /* =====================================================
     * 🔒 PRIVATE: Helper & Validation
     * ===================================================== */

    private function validateRole(Request $request, $isUpdate = false, $id = null): array
    {
        $id = $id ?? $request->idrole;
        $uniqueRule = 'unique:role,nama_role';
        if ($isUpdate && $id) {
            $uniqueRule .= ',' . $id . ',idrole';
        }

        return $request->validate([
            'nama_role' => ['required', 'string', 'max:50', $uniqueRule],
        ], [
            'nama_role.required' => 'Nama role wajib diisi.',
            'nama_role.unique' => 'Nama role sudah digunakan.',
        ]);
    }
}
