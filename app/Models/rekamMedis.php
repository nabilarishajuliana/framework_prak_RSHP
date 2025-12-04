<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    use SoftDeletes;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';
    public $timestamps = false;

    protected $dates = ['deleted_at', 'created_at'];

    protected $fillable = [
        'created_at',
        'anamnesa',
        'temuan_klinis',
        'diagnosa',
        'dokter_pemeriksa',
        'idReservasi_dokter',
        'deleted_at',
        'deleted_by'
    ];

    /* ================= RELASI ================= */

    // Rekam medis milik 1 antrian temu dokter
    public function temuDokter()
    {
        return $this->belongsTo(TemuDokter::class, 'idReservasi_dokter', 'idreservasi_dokter');
    }

    // Dokter pemeriksa
    public function dokterPemeriksa()
{
    return $this->belongsTo(RoleUser::class, 'dokter_pemeriksa', 'idrole_user')
                ->with(['user']);
}


    // Rekam medis punya banyak detail
    public function detail()
{
    return $this->hasMany(DetailRekamMedis::class, 'idrekam_medis', 'idrekam_medis');
}


    /** Rekam Medis → Temu Dokter */
    public function reservasi()
    {
        return $this->belongsTo(TemuDokter::class, 'idReservasi_dokter')
            ->withTrashed()
            ->with([
                'pet' => function ($q) {
                    $q->withTrashed()->with(['pemilik.user']);
                }
            ]);
    }
}
