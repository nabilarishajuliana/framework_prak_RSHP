<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik';
    protected $primaryKey = 'idpemilik';
    public $timestamps = false;

    protected $fillable = ['alamat', 'no_wa', 'iduser'];

    // Relasi ke tabel Pet
    public function pet()
    {
        return $this->hasMany(Pet::class, 'idpemilik', 'idpemilik');
    }

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}
