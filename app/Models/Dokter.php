<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
      protected $table = 'dokter';
    protected $primaryKey = 'iddokter';
    public $timestamps = false;

    protected $fillable = ['jenis_kelamin', 'alamat', 'no_hp','bidang_dokter','deleted_at','deleted_by','iduser'];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}
