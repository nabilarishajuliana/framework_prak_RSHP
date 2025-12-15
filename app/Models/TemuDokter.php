<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemuDokter extends Model
{
    use SoftDeletes;
    protected $table = 'temu_dokter';
    protected $primaryKey = 'idreservasi_dokter';
    public $timestamps = false;
    protected $dates = ['deleted_at', 'waktu_daftar'];

    protected $fillable = [
        'no_urut',
        'waktu_daftar',
        'status',
        'idpet',
        'idrole_user',
        'deleted_by'
    ];
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet')
            ->withTrashed()
            ->with(['pemilik.user', 'rasHewan']);
    }
    public function roleUser()
    {
        return $this->belongsTo(RoleUser::class, 'idrole_user', 'idrole_user')
            ->with('role');
    }
    public function rekamMedis()
    {
        // DEFAULT: rekam medis AKTIF aja (buat logic tombol)
        return $this->hasOne(RekamMedis::class, 'idReservasi_dokter', 'idreservasi_dokter');
    }
    public function rekamMedisAll()
    {
        // Kalau butuh histori (termasuk yang dihapus)
        return $this->hasOne(RekamMedis::class, 'idReservasi_dokter', 'idreservasi_dokter')->withTrashed();
    }
}

 // public function rekamMedis()
    // {
    //     return $this->hasOne(RekamMedis::class, 'idreservasi_dokter', 'idreservasi_dokter')
    //         ->withTrashed();
    // }

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class TemuDokter extends Model
// {
//     use SoftDeletes;

//     protected $table = 'temu_dokter';
//     protected $primaryKey = 'idreservasi_dokter';

//     public $timestamps = false;

//     protected $dates = ['deleted_at', 'waktu_daftar'];

//     protected $fillable = [
//         'no_urut',
//         'waktu_daftar',
//         'status',
//         'idpet',
//         'idrole_user',
//         'deleted_at',
//         'deleted_by'
//     ];

//     /** =============== RELASI =============== */

//     // Setiap temu dokter terhubung ke 1 pet
//     public function pet()
//     {
//         return $this->belongsTo(Pet::class, 'idpet', 'idpet')
//             ->withTrashed() // <<< FIX PENTING
//             ->with(['pemilik.user', 'rasHewan']);
//     }

//     // Role user yang membuat antrian
//     public function roleUser()
//     {
//         return $this->belongsTo(RoleUser::class, 'idrole_user', 'idrole_user')
//             ->with('role');
//     }

//     public function rekamMedis()
//     {
//         return $this->hasOne(RekamMedis::class, 'idReservasi_dokter', 'idreservasi_dokter');
//     }

//     protected static function booted()
// {
//     static::deleting(function ($td) {

//         if ($td->rekamMedis()->whereNull('deleted_at')->exists()) {
//             throw new \Exception("Tidak bisa menghapus Antrian karena sudah memiliki Rekam Medis.");
//         }
//     });
// }

// }
