<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RasHewan extends Model
{
    use SoftDeletes;
    protected $table = 'ras_hewan';
    protected $primaryKey = 'idras_hewan';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nama_ras',
        'idjenis_hewan',
        'deleted_by'
    ];
    public function jenisHewan()
    {
        return $this->belongsTo(JenisHewan::class, 'idjenis_hewan', 'idjenis_hewan')
            ->withTrashed();
    }
    public function pet()
    {
        return $this->hasMany(Pet::class, 'idras_hewan', 'idras_hewan');
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class RasHewan extends Model
// {
//     use SoftDeletes;

//     protected $table = 'ras_hewan';
//     protected $primaryKey = 'idras_hewan';
//     public $timestamps = false;

//     protected $dates = ['deleted_at'];

//     protected $fillable = [
//         'nama_ras',
//         'idjenis_hewan',
//         'deleted_at',
//         'deleted_by'
//     ];

//     public function jenisHewan()
//     {
//         return $this->belongsTo(JenisHewan::class, 'idjenis_hewan', 'idjenis_hewan');
//     }

//     protected static function booted()
// {
//     static::deleting(function ($ras) {

//         if ($ras->pet()->whereNull('deleted_at')->exists()) {
//             throw new \Exception("Tidak bisa menghapus Ras Hewan karena masih dipakai oleh Pet.");
//         }
//     });
// }

// }