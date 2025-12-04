<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemuDokter extends Model
{
    use SoftDeletes;

    protected $table = 'temu_dokter';
    protected $primaryKey = 'idreservasi_dokter';

    public $timestamps = false;

    protected $dates = ['deleted_at', 'waktu_daftar'];

    protected $fillable = [
        'no_urut',
        'waktu_daftar',
        'status',
        'idpet',
        'idrole_user',
        'deleted_at',
        'deleted_by'
    ];

    /** =============== RELASI =============== */

    // Setiap temu dokter terhubung ke 1 pet
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet')
            ->withTrashed() // <<< FIX PENTING
            ->with(['pemilik.user', 'rasHewan']);
    }

    // Role user yang membuat antrian
    public function roleUser()
    {
        return $this->belongsTo(RoleUser::class, 'idrole_user', 'idrole_user')
            ->with('role');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'idReservasi_dokter', 'idreservasi_dokter');
    }

    protected static function booted()
{
    static::deleting(function ($td) {

        if ($td->rekamMedis()->whereNull('deleted_at')->exists()) {
            throw new \Exception("Tidak bisa menghapus Antrian karena sudah memiliki Rekam Medis.");
        }
    });
}

}
