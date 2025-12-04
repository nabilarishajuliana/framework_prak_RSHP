<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemilik extends Model
{
    use SoftDeletes;

    protected $table = 'pemilik';
    protected $primaryKey = 'idpemilik';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'alamat',
        'no_wa',
        'iduser',
        'deleted_at',
        'deleted_by'
    ];

    protected $hidden = ['deleted_at', 'deleted_by'];

    // Relasi ke Pet
    public function pet()
    {
        return $this->hasMany(Pet::class, 'idpemilik', 'idpemilik');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}
