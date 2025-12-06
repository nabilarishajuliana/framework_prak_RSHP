<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perawat;

use App\Models\User;

class PerawatProfileController extends Controller
{
    /** =========================
     * SHOW PROFILE
     * ========================== */
    public function indexPerawat()
    {
        $userId = session('user_id');

        $user = User::withTrashed()->findOrFail($userId);

        $perawat = Perawat::withTrashed()
            ->where('iduser', $userId)
            ->first();

        return view('pagePerawat.pageProfile.index', compact('user', 'perawat'));
    }

    public function indexDokter()
    {
        $userId = session('user_id');

        $user = User::withTrashed()->findOrFail($userId);

        $dokter = Dokter::withTrashed()
            ->where('iduser', $userId)
            ->first();

        return view('pageDokter.pageProfile.index', compact('user', 'dokter'));
    }


    // /** =========================
    //  * EDIT PROFILE
    //  * ========================== */
    // public function edit()
    // {
    //     $userId = session('user_id');

    //     $user = User::withTrashed()->findOrFail($userId);

    //     $perawat = Perawat::withTrashed()
    //         ->where('iduser', $userId)
    //         ->first();

    //     return view('pagePerawat.pageProfile.edit', compact('user', 'perawat'));
    // }


    // /** =========================
    //  * UPDATE PROFILE
    //  * ========================== */
    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'nama'          => 'required|string|max:100',
    //         'email'         => 'required|email',
    //         'jenis_kelamin' => 'required|in:L,P',
    //         'alamat'        => 'nullable|string',
    //         'no_hp'         => 'nullable|string|max:15',
    //         'pendidikan'    => 'nullable|string',
    //     ]);

    //     $user = User::findOrFail(session('user_id'));
    //     $perawat = Perawat::where('iduser', session('user_id'))->first();

    //     // update user table
    //     $user->update([
    //         'nama'  => $request->nama,
    //         'email' => $request->email,
    //     ]);

    //     // update perawat table
    //     $perawat->update([
    //         'jenis_kelamin' => $request->jenis_kelamin,
    //         'alamat'        => $request->alamat,
    //         'no_hp'         => $request->no_hp,
    //         'pendidikan'    => $request->pendidikan,
    //     ]);

    //     return redirect()
    //         ->route('perawat.profile')
    //         ->with('success', 'Profil berhasil diperbarui!');
    // }
}
