<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'idrole';
    public $timestamps = false;

    protected $fillable = ['nama_role'];

    // Relasi ke RoleUser (satu role bisa punya banyak user di pivot)
    // public function roleUser()
    // {
    //     return $this->hasMany(RoleUser::class, 'idrole', 'idrole');
    // }

    // Relasi ke User langsung (kalau tabel user juga punya kolom idrole)
    // public function user()
    // {
    //     return $this->hasMany(User::class, 'idrole', 'idrole');
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'idrole', 'iduser');
    }
}
