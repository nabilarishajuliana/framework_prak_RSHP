<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\RasHewan;

class PetController extends Controller
{
    public function index()
    {
        // Ambil data pet dengan relasi ke ras hewan dan pemilik
        $pets = Pet::with(['rasHewan', 'pemilik'])->get();

        return view('pageadmin.pagepet.index', compact('pets'));
    }

    public function petResepsionis()
    {
        // Ambil data pet dengan relasi ke ras hewan dan pemilik
        $pet = Pet::with(['rasHewan', 'pemilik'])->get();

        return view('pageresepsionis.pagepet.index', compact('pet'));
    }

    /** 🟢 CREATE */
    public function create()
    {
        $pemilik = Pemilik::with('user')->get();
        $rasHewan = RasHewan::with('jenisHewan')->get();
        return view('pageadmin.pagepet.create', compact('pemilik', 'rasHewan'));
    }

    /** 🟢 STORE */
    // public function store(Request $request)
    // {
    //     $validated = $this->validatePet($request);

    //     // ubah "jantan"/"betina" jadi L/P
    //     $gender = $validated['jenis_kelamin'] === 'L' ? 'L' : 'P';

    //     Pet::create([
    //         'nama' => ucwords(trim($validated['nama'])),
    //         'tanggal_lahir' => $validated['tanggal_lahir'],
    //         'jenis_kelamin' => $gender,
    //         'warna_tanda' => ucwords(trim($validated['warna_tanda'])),
    //         'idras_hewan' => $validated['idras_hewan'],
    //         'idpemilik' => $validated['idpemilik'],
    //     ]);

    //     return redirect()->route('admin.pet')
    //                      ->with('success', 'Data hewan baru berhasil ditambahkan!');
    // }

    public function store(Request $request)
    {
        $validated = $this->validatePet($request);

        Pet::create([
            'nama' => ucwords(trim($validated['nama'])),
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'], // langsung isi L/P
            'warna_tanda' => ucwords(trim($validated['warna_tanda'])),
            'idras_hewan' => $validated['idras_hewan'],
            'idpemilik' => $validated['idpemilik'],
        ]);

        return redirect()->route('admin.pet')
            ->with('success', 'Data hewan baru berhasil ditambahkan!');
    }

    /** 🟢 EDIT */
    public function edit($id)
    {
        $pet = Pet::with(['pemilik.user', 'rasHewan'])->findOrFail($id);
        $pemilik = Pemilik::with('user')->get();
        $rasHewan = RasHewan::with('jenisHewan')->get();

        return view('pageadmin.pagepet.edit', compact('pet', 'pemilik', 'rasHewan'));
    }

    /** 🟢 UPDATE */
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);
        $validated = $this->validatePet($request);


        $pet->update([
            'nama' => ucwords(trim($validated['nama'])),
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'], // langsung isi L/P
            'warna_tanda' => ucwords(trim($validated['warna_tanda'])),
            'idras_hewan' => $validated['idras_hewan'],
            'idpemilik' => $validated['idpemilik'],
        ]);

        return redirect()->route('admin.pet')->with('success', 'Data hewan berhasil diperbarui!');
    }

    /** 🟢 DESTROY */
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();

        return redirect()->route('admin.pet')->with('success', 'Data hewan berhasil dihapus!');
    }

    /** 🔒 VALIDATION */
    private function validatePet(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P', // ✅ ubah jadi L/P
            'warna_tanda' => 'nullable|string|max:100',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
        ], [
            'nama.required' => 'Nama hewan wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus dipilih dengan benar.',
            'idras_hewan.required' => 'Pilih ras hewan.',
            'idpemilik.required' => 'Pilih pemilik hewan.',
        ]);
    }
}
