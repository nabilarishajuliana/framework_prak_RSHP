<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokter extends Model
{
    use SoftDeletes;

    protected $table = 'dokter';
    protected $primaryKey = 'iddokter';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'bidang_dokter',
        'deleted_by',
        'iduser'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser')
            ->withTrashed(); // 🔥 WAJIB
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class Dokter extends Model
// {
//     use SoftDeletes;

//     protected $table = 'dokter';
//     protected $primaryKey = 'iddokter';
//     public $timestamps = false;

//     protected $dates = ['deleted_at'];

//     protected $fillable = [
//         'jenis_kelamin',
//         'alamat',
//         'no_hp',
//         'bidang_dokter',
//         'deleted_at',
//         'deleted_by',
//         'iduser'
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class, 'iduser', 'iduser');
//     }
// }
