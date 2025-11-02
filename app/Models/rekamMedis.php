<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';
    public $timestamps = false;

    protected $fillable = [
        'idReservasi_dokter',
        'anamnesa',
        'temuan_klinis',
        'diagnosa',
        'dokter_pemeriksa',
        'created_at',
    ];

    // Relasi ke temu_dokter
    public function temuDokter()
    {
        return $this->belongsTo(TemuDokter::class, 'idReservasi_dokter', 'idreservasi_dokter')
            ->with(['pet.pemilik.user']);
    }

    // Relasi ke dokter pemeriksa (role_user)
    public function dokter()
    {
        return $this->belongsTo(RoleUser::class, 'dokter_pemeriksa', 'idrole_user')
            ->with(['user']);
    }

    // Relasi ke detail tindakan
    public function detailRekamMedis()
    {
        return $this->hasMany(DetailRekamMedis::class, 'idrekam_medis', 'idrekam_medis')
            ->with('kodeTindakanTerapi');
    }
}
