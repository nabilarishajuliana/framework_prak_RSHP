<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;


class LoginController extends Controller
{


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     $this->middleware('auth')->only('logout');
    // }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 🔹 Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 🔹 Cari user berdasarkan email + relasi role aktif
        $user = User::with(['roles' => function ($query) {
            $query->where('status', 1); // misalnya kolom 'status' menunjukkan role aktif
        }])->where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // 🔹 Cek password pakai Hash (karena Laravel simpan password dalam bentuk hash)
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Password salah.']);
        }

        // 🔹 Login user
        Auth::login($user);

        $activeRole = $user->roles()->wherePivot('status', 1)->first();

        // 🔹 Simpan info penting ke session (opsional)
        $request->session()->put([
            'user_id' => $user->iduser,
            'user_name' => $user->nama,
            'user_email' => $user->email,
            'user_role'      => $activeRole->idrole ?? 5, // idrole dari tabel role
            'user_role_name' => $activeRole->nama_role ?? 'pemilik', // nama_role dari tabel role
            'user_status'    => $activeRole->pivot->status ?? 1, // status dari tabel pivot role_user
            'idrole_user'    => $activeRole->pivot->idrole_user ?? null, // id dari tabel pivot role_user

        ]);

        // return redirect()->intended('/home')->with('success', 'Login berhasil!');


        // if (!$activeRole) {
        //     Auth::logout();
        //     return redirect('/login')->with('error', 'Tidak ada role aktif untuk akun ini.');
        // }

        // 🔹 Redirect berdasarkan role
        $idrole = session('user_role');

        switch ($idrole) {
            case '1':
                return redirect()->route('admin.dashboard')-> with('success', 'Selamat datang Administrator!');
            case '2':
                return redirect()->route('dokter.dashboard')->with('success', 'Selamat datang Dokter!');
            case '3':
                return redirect()->route('perawat.dashboard')->with('success', 'Selamat datang Perawat!');
            case '4':
                return redirect()->route('resepsionis.dashboard')->with('success', 'Selamat datang Resepsionis!');
               
            // case 'Pemilik':
            //     return redirect('/pemilik/dashboard')->with('success', 'Selamat datang Pemilik!');
            default:
                return redirect()->route('pemilik.dashboard')->with('success', 'Login berhasil!');
        }


        // 🔹 Ambil daftar role user
        // $roles = $user->roles->pluck('nama_role')->toArray();

        // // 🔹 Redirect sesuai role
        // if (in_array('Admin', $roles)) {
        //     return redirect('/admin')->with('success', 'Selamat datang Admin!');
        // } elseif (in_array('Dokter', $roles)) {
        //     return redirect('/dokter')->with('success', 'Selamat datang Dokter!');
        // } elseif (in_array('Pemilik', $roles)) {
        //     return redirect('/pemilik')->with('success', 'Selamat datang Pemilik!');
        // } else {
        //     return redirect('/home')->with('success', 'Login berhasil!');
        // }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
