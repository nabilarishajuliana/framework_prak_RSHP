<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
      protected $table = 'pet';
    protected $primaryKey = 'idpet';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'idras_hewan',
        'idpemilik'
    ];

    // Relasi ke tabel Ras Hewan
    public function rasHewan()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }

    // Relasi ke tabel Pemilik
    public function pemilik()
{
    return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik')->with('user');
}

}
