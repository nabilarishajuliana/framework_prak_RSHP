<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisHewan extends Model
{
    use SoftDeletes;

    protected $table = 'jenis_hewan';
    protected $primaryKey = 'idjenis_hewan';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama_jenis_hewan',
        'deleted_by'
    ];

    public function rasHewan()
    {
        return $this->hasMany(RasHewan::class, 'idjenis_hewan', 'idjenis_hewan');
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class JenisHewan extends Model
// {
//     use SoftDeletes;

//     protected $table = 'jenis_hewan';
//     protected $primaryKey = 'idjenis_hewan';
//     public $timestamps = false;

//     protected $dates = ['deleted_at'];

//     protected $fillable = [
//         'nama_jenis_hewan',
//         'deleted_at',
//         'deleted_by'
//     ];

//     public function rasHewan()
//     {
//         return $this->hasMany(RasHewan::class, 'idjenis_hewan', 'idjenis_hewan');
//     }

//     protected static function booted()
// {
//     static::deleting(function ($jenis) {

//         if ($jenis->rasHewan()->whereNull('deleted_at')->exists()) {
//             throw new \Exception("Tidak bisa menghapus Jenis Hewan karena masih memiliki Ras.");
//         }
//     });
// }

// }
