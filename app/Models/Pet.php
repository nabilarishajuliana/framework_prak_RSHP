<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use SoftDeletes;

    protected $table = 'pet';
    protected $primaryKey = 'idpet';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'warna_tanda',
        'idras_hewan',
        'idpemilik',
        'deleted_at',
        'deleted_by'
    ];

    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik')->with('user');
    }

    public function rasHewan()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }

    public function temuDokter()
    {
        return $this->hasMany(TemuDokter::class, 'idpet', 'idpet');
    }
}
