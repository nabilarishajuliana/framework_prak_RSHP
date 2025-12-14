<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perawat extends Model
{
    use SoftDeletes;

    protected $table = 'perawat';
    protected $primaryKey = 'idperawat';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'pendidikan',
        'deleted_by',
        'iduser'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser')
            ->withTrashed(); // 🔥 WAJIB biar aman kalau user kehapus
    }
}


// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class Perawat extends Model
// {
//     use SoftDeletes;

//     protected $table = 'perawat';
//     protected $primaryKey = 'idperawat';
//     public $timestamps = false;

//     protected $dates = ['deleted_at'];

//     protected $fillable = [
//         'jenis_kelamin',
//         'alamat',
//         'no_hp',
//         'pendidikan',
//         'deleted_at',
//         'deleted_by',
//         'iduser'
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class, 'iduser', 'iduser');
//     }
// }
