<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'iduser';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telp',
    ];

    /** 🔹 Relasi ke tabel Pemilik */
    public function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    /** 🔹 Relasi ke RoleUser pivot */
    public function roleUser()
    {
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }

    /** 🔹 Relasi Many to Many ke Role */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
                    ->withPivot('status');
    }

    /** 🔹 Ambil role aktif */
    public function activeRole()
    {
        return $this->roles()->wherePivot('status', 1)->first();
    }

    /** 🔹 Ganti atau set role aktif */
    public function setActiveRole($roleId)
    {
        // Nonaktifkan semua role aktif sebelumnya
        $this->roles()->update(['status' => 0]);

        // Cek apakah user sudah punya role tersebut
        $existing = $this->roles()->where('role.idrole', $roleId)->first();

        if ($existing) {
            // Kalau sudah punya → update pivot status ke aktif
            $this->roles()->updateExistingPivot($roleId, ['status' => 1]);
        } else {
            // Kalau belum punya → attach role baru & aktifkan
            $this->roles()->attach($roleId, ['status' => 1]);
        }
    }
}
