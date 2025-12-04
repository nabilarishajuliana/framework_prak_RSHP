<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;

    protected $table = 'kategori';
    protected $primaryKey = 'idkategori';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama_kategori',
        'deleted_at',
        'deleted_by'
    ];

    public function kodeTindakanTerapi()
    {
        return $this->hasMany(KodeTindakanTerapi::class, 'idkategori', 'idkategori');
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Kategori extends Model
// {
//      protected $table = 'kategori';
//     protected $primaryKey = 'idkategori';
//     public $timestamps = false;

//     protected $fillable = ['nama_kategori'];

//     public function kodeTindakanTerapi()
// {
//     return $this->hasMany(KodeTindakanTerapi::class, 'idkategori', 'idkategori');
// }
// }
