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
        'deleted_at',
        'deleted_by'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori');
    }

    public function kategoriKlinis()
    {
        return $this->belongsTo(KategoriKlinis::class, 'idkategori_klinis', 'idkategori_klinis');
    }

    protected static function booted()
{
    static::deleting(function ($kode) {

        if ($kode->detail()->whereNull('deleted_at')->exists()) {
            throw new \Exception("Tidak bisa menghapus Kode Tindakan karena masih digunakan pada Rekam Medis.");
        }
    });
}

}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class KodeTindakanTerapi extends Model
// {
//     protected $table = 'kode_tindakan_terapi';
//     protected $primaryKey = 'idkode_tindakan_terapi';
//     public $timestamps = false;

//     protected $fillable = ['kode', 'deskripsi_tindakan_terapi', 'idkategori', 'idkategori_klinis'];

//     // Relasi ke tabel kategori
//     public function kategori()
//     {
//         return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori');
//     }

//     // Relasi ke tabel kategori_klinis
//     public function kategoriKlinis()
//     {
//         return $this->belongsTo(KategoriKlinis::class, 'idkategori_klinis', 'idkategori_klinis');
//     }
// }
