<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $table = 'role';
    protected $primaryKey = 'idrole';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nama_role',
        'deleted_by'
    ];
    public function roleUser()
    {
        return $this->hasMany(RoleUser::class, 'idrole', 'idrole');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'idrole', 'iduser')
            ->withPivot('status')
            ->withTrashed(); // 🔥 PENTING
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Role extends Model
// {
//     protected $table = 'role';
//     protected $primaryKey = 'idrole';
//     public $timestamps = false;

//     protected $fillable = ['nama_role'];

//     // Relasi ke RoleUser (satu role bisa punya banyak user di pivot)
//     public function roleUser()
//     {
//         return $this->hasMany(RoleUser::class, 'idrole', 'idrole');
//     }

    

//     //many to many
//     public function users()
//     {
//         return $this->belongsToMany(User::class, 'role_user', 'idrole', 'iduser')
//         ->withPivot('status');
//     }
// }
