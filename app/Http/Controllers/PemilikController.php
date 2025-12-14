<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PemilikController extends Controller
{
    function isRole($roleName)
    {
        return strtolower(session('user_role_name')) === strtolower($roleName);
    }

    /** ======================= INDEX ======================= */
    public function index()
    {
        $pemilik = Pemilik::with(['user', 'pet'])->get();

        if ($this->isRole('administrator')) {
            return view('pageadmin.pagepemilik.index', compact('pemilik'));
        }

        if ($this->isRole('resepsionis')) {
            return view('pageresepsionis.pagepemilik.index', compact('pemilik'));
        }
    }

    /** ======================= CREATE ======================= */
    public function create()
    {
        $user = User::orderBy('nama')->get();

        if ($this->isRole('administrator')) {
            return view('pageadmin.pagepemilik.create', compact('user'));
        }

        if ($this->isRole('resepsionis')) {
            return view('pageresepsionis.pagepemilik.create', compact('user'));
        }
    }

    /** ======================= STORE ======================= */
    public function store(Request $request)
    {
        $validated = $this->validatePemilikGabung($request);

        $user = User::create([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower(trim($validated['email'])),
            'password' => bcrypt($validated['password']),
        ]);

        Pemilik::create([
            'alamat' => ucwords(trim($validated['alamat'])),
            'no_wa' => $validated['no_wa'],
            'iduser' => $user->iduser,
        ]);

        if ($this->isRole('administrator')) {
            return redirect()->route('admin.pemilik')->with('success', 'Pemilik berhasil dibuat!');
        }

        return redirect()->route('resepsionis.pemilik')->with('success', 'Pemilik berhasil dibuat!');
    }

    /** ======================= EDIT ======================= */
    public function edit($id)
    {
        $pemilik = Pemilik::with('user')->findOrFail($id);

        if ($this->isRole('administrator')) {
            return view('pageadmin.pagepemilik.edit', compact('pemilik'));
        }

        if ($this->isRole('resepsionis')) {
            return view('pageresepsionis.pagepemilik.edit', compact('pemilik'));
        }
    }

    /** ======================= UPDATE ======================= */
    public function update(Request $request, $id)
    {
        $pemilik = Pemilik::with('user')->findOrFail($id);

        $validated = $this->validatePemilikGabungUpdate($request, $pemilik->user->iduser);

        $pemilik->user->update([
            'nama' => ucwords(trim($validated['nama'])),
            'email' => strtolower(trim($validated['email'])),
            'password' => $validated['password'] ? bcrypt($validated['password']) : $pemilik->user->password,
        ]);

        $pemilik->update([
            'alamat' => ucwords(trim($validated['alamat'])),
            'no_wa' => $validated['no_wa'],
        ]);

        if ($this->isRole('administrator')) {
            return redirect()->route('admin.pemilik')->with('success', 'Data berhasil diperbarui!');
        }

        return redirect()->route('resepsionis.pemilik')->with('success', 'Data berhasil diperbarui!');
    }

    /** ======================= DELETE (SoftDelete) ======================= */
    public function destroy($id)
    {
        $pemilik = Pemilik::with('user')->findOrFail($id);

        // 🔥 delete USER (User model yg akan cascade delete pemilik + role_user)
        $pemilik->user->deleted_by = Auth::id();
        $pemilik->user->save();
        $pemilik->user->delete();

        if ($this->isRole('administrator')) {
            return redirect()->route('admin.pemilik')->with('success', 'Pemilik dan akun user berhasil dihapus.');
        }

        return redirect()->route('resepsionis.pemilik')->with('success', 'Pemilik dan akun user berhasil dihapus.');
    }

    /** ======================= VALIDATION ======================= */

    private function validatePemilikGabung(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:5',
            'alamat' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15|regex:/^[0-9]+$/',
        ]);
    }

    private function validatePemilikGabungUpdate(Request $request, $userId): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email,' . $userId . ',iduser',
            'password' => 'nullable|min:5',
            'alamat' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15|regex:/^[0-9]+$/',
        ]);
    }
}
