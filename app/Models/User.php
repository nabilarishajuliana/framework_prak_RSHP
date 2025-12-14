<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'user';
    protected $primaryKey = 'iduser';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telp',
        'deleted_by'
    ];

    public function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'iduser', 'iduser');
    }

    public function perawat()
    {
        return $this->hasOne(Perawat::class, 'iduser', 'iduser');
    }

    public function roleUser()
    {
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
            ->withPivot(['status', 'idrole_user'])
            ->withTrashed(); // 🔥 PENTING
    }

    public function activeRole()
    {
        return $this->roles()->wherePivot('status', 1)->first();
    }

    public function setActiveRole(int $roleId): void
    {
        // 1️⃣ nonaktifkan semua role
        $this->roles()->update(['status' => 0]);

        // 2️⃣ cek apakah role sudah pernah ada di pivot
        $existing = $this->roles()->where('role.idrole', $roleId)->first();

        if ($existing) {
            // kalau sudah ada → update
            $this->roles()->updateExistingPivot($roleId, ['status' => 1]);
        } else {
            // kalau belum ada → insert baru
            $this->roles()->attach($roleId, ['status' => 1]);
        }
    }
    /* ============== CASCADE SOFT DELETE ============== */

    protected static function booted()
    {
        static::deleting(function ($user) {

            $deletedBy = Auth::id();

            // 🔥 PEMILIK
            if ($user->pemilik) {
                $user->pemilik->deleted_by = $deletedBy;
                $user->pemilik->save();
                $user->pemilik->delete();
            }

            // 🔥 DOKTER
            if ($user->dokter) {
                $user->dokter->deleted_by = $deletedBy;
                $user->dokter->save();
                $user->dokter->delete();
            }

            // 🔥 PERAWAT
            if ($user->perawat) {
                $user->perawat->deleted_by = $deletedBy;
                $user->perawat->save();
                $user->perawat->delete();
            }

            // 🔥 ROLE USER (hasMany)
            foreach ($user->roleUser as $ru) {
                $ru->deleted_by = $deletedBy;
                $ru->save();
                $ru->delete();
            }
        });
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class User extends Authenticatable
// {
//     use HasFactory, Notifiable, SoftDeletes;

//     protected $table = 'user';
//     protected $primaryKey = 'iduser';
//     public $timestamps = false;

//     protected $dates = ['deleted_at'];

//     protected $fillable = [
//         'nama',
//         'email',
//         'password',
//         'no_telp',
//         'deleted_at',
//         'deleted_by'
//     ];

//     public function pemilik()
//     {
//         return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
//     }

//     public function dokter()
//     {
//         return $this->hasOne(Dokter::class, 'iduser', 'iduser');
//     }

//     public function perawat()
//     {
//         return $this->hasOne(Perawat::class, 'iduser', 'iduser');
//     }

//     public function roleUser()
//     {
//         return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
//     }

//     public function roles()
//     {
//         return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
//                     ->withPivot(['status', 'idrole_user']);
//     }

//     public function activeRole()
//     {
//         return $this->roles()->wherePivot('status', 1)->first();
//     }

//     public function setActiveRole($roleId)
//     {
//         $this->roles()->update(['status' => 0]);

//         $existing = $this->roles()->where('role.idrole', $roleId)->first();

//         if ($existing) {
//             $this->roles()->updateExistingPivot($roleId, ['status' => 1]);
//         } else {
//             $this->roles()->attach($roleId, ['status' => 1]);
//         }
//     }

//     protected static function booted()
// {
//     static::deleting(function ($user) {

//         // Tidak boleh hapus jika masih punya role aktif
//         if ($user->roleUser()->where('status', 1)->exists()) {
//             throw new \Exception("Tidak bisa menghapus User karena masih memiliki role aktif.");
//         }

//         // Tidak boleh hapus jika masih pemilik
//         if ($user->pemilik()->whereNull('deleted_at')->exists()) {
//             throw new \Exception("Tidak bisa menghapus User karena masih terdaftar sebagai Pemilik.");
//         }

//         // Tidak boleh hapus jika masih dokter aktif
//         if ($user->dokter()->whereNull('deleted_at')->exists()) {
//             throw new \Exception("Tidak bisa menghapus User karena masih terdaftar sebagai Dokter.");
//         }

//         // Tidak boleh hapus jika masih perawat aktif
//         if ($user->perawat()->whereNull('deleted_at')->exists()) {
//             throw new \Exception("Tidak bisa menghapus User karena masih terdaftar sebagai Perawat.");
//         }
//     });
// }

// }
