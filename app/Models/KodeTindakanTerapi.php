<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KodeTindakanTerapi extends Model
{
    use SoftDeletes;

    protected $table = 'kode_tindakan_terapi';
    protected $primaryKey = 'idkode_tindakan_terapi';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'kode',
        'deskripsi_tindakan_terapi',
        'idkategori',
        'idkategori_klinis',
        'deleted_by'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori')
            ->withTrashed(); // 🔥 WAJIB
    }

    public function kategoriKlinis()
    {
        return $this->belongsTo(KategoriKlinis::class, 'idkategori_klinis', 'idkategori_klinis')
            ->withTrashed(); // 🔥 WAJIB
    }

    public function detail()
    {
        return $this->hasMany(DetailRekamMedis::class, 'idkode_tindakan_terapi', 'idkode_tindakan_terapi');
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class KodeTindakanTerapi extends Model
// {
//     use SoftDeletes;

//     protected $table = 'kode_tindakan_terapi';
//     protected $primaryKey = 'idkode_tindakan_terapi';
//     public $timestamps = false;

//     protected $dates = ['deleted_at'];

//     protected $fillable = [
//         'kode',
//         'deskripsi_tindakan_terapi',
//         'idkategori',
//         'idkategori_klinis',
//         'deleted_at',
//         'deleted_by'
//     ];

//     public function kategori()
//     {
//         return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori');
//     }

//     public function kategoriKlinis()
//     {
//         return $this->belongsTo(KategoriKlinis::class, 'idkategori_klinis', 'idkategori_klinis');
//     }

//     protected static function booted()
// {
//     static::deleting(function ($kode) {

//         if ($kode->detail()->whereNull('deleted_at')->exists()) {
//             throw new \Exception("Tidak bisa menghapus Kode Tindakan karena masih digunakan pada Rekam Medis.");
//         }
//     });
// }

// }
