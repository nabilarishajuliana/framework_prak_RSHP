<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\RasHewan;

class PetController extends Controller
{
    function isRole($role)
    {
        return strtolower(session('user_role_name')) === strtolower($role);
    }

    /** ================= INDEX ================= */
    public function index()
    {
        $pets = Pet::with(['rasHewan', 'pemilik'])
                    ->whereNull('deleted_at')
                    ->get();

        if ($this->isRole('administrator')) {
            return view('pageadmin.pagepet.index', compact('pets'));
        }

        return view('pageresepsionis.pagepet.index', compact('pets'));
    }

    /** ================= CREATE ================= */
    public function create()
    {
        $pemilik = Pemilik::with('user')->get();
        $rasHewan = RasHewan::with('jenisHewan')->get();

        if ($this->isRole('administrator')) {
            return view('pageadmin.pagepet.create', compact('pemilik', 'rasHewan'));
        }

        return view('pageresepsionis.pagepet.create', compact('pemilik', 'rasHewan'));
    }

    /** ================= STORE ================= */
    public function store(Request $request)
    {
        $validated = $this->validatePet($request);

        Pet::create([
            'nama' => ucwords(trim($validated['nama'])),
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'warna_tanda' => ucwords(trim($validated['warna_tanda'])),
            'idras_hewan' => $validated['idras_hewan'],
            'idpemilik' => $validated['idpemilik'],
        ]);

        if ($this->isRole('administrator')) {
            return redirect()->route('admin.pet')->with('success', 'Pet berhasil ditambahkan!');
        }

        return redirect()->route('resepsionis.pet')->with('success', 'Pet berhasil ditambahkan!');
    }

    /** ================= EDIT ================= */
    public function edit($id)
    {
        $pet = Pet::with(['pemilik.user', 'rasHewan'])->findOrFail($id);
        $pemilik = Pemilik::with('user')->get();
        $rasHewan = RasHewan::with('jenisHewan')->get();

        if ($this->isRole('administrator')) {
            return view('pageadmin.pagepet.edit', compact('pet', 'pemilik', 'rasHewan'));
        }

        return view('pageresepsionis.pagepet.edit', compact('pet', 'pemilik', 'rasHewan'));
    }

    /** ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);
        $validated = $this->validatePet($request);

        $pet->update([
            'nama' => ucwords(trim($validated['nama'])),
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'warna_tanda' => ucwords(trim($validated['warna_tanda'])),
            'idras_hewan' => $validated['idras_hewan'],
            'idpemilik' => $validated['idpemilik'],
        ]);

        if ($this->isRole('administrator')) {
            return redirect()->route('admin.pet')->with('success', 'Pet berhasil diperbarui!');
        }

        return redirect()->route('resepsionis.pet')->with('success', 'Pet berhasil diperbarui!');
    }

    /** ================= DELETE (soft delete) ================= */
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->deleted_by = Auth::id();
        $pet->save();
        $pet->delete();

        if ($this->isRole('administrator')) {
            return redirect()->route('admin.pet')->with('success', 'Pet berhasil dihapus!');
        }

        return redirect()->route('resepsionis.pet')->with('success', 'Pet berhasil dihapus!');
    }

    /** ================= VALIDATION ================= */
    private function validatePet(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'warna_tanda' => 'nullable|string|max:100',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
        ]);
    }

     public function indexPemilik()
    {
        $idUser = session('user_id');
        
        $pemilik = Pemilik::where('iduser', $idUser)->first();
        
        if (!$pemilik) {
            return redirect()->route('login')
                ->with('error', 'Data pemilik tidak ditemukan');
        }
        
        $pets = Pet::with('rasHewan.jenisHewan')
            ->where('idpemilik', $pemilik->idpemilik)
            ->whereNull('deleted_at')
            ->orderBy('nama', 'asc')
            ->get();
        
        return view('pagePemilik.pagePet.index', compact('pemilik', 'pets'));
    }
}
