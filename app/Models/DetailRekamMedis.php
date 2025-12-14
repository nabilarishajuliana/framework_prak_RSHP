<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRekamMedis extends Model
{
    use SoftDeletes;

    protected $table = 'detail_rekam_medis';
    protected $primaryKey = 'iddetail_rekam_medis';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idrekam_medis',
        'idkode_tindakan_terapi',
        'detail',
        'deleted_at',
        'deleted_by'
    ];

    /** Relasi ke rekam medis */
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'idrekam_medis', 'idrekam_medis')
            ->withTrashed();
    }


    /** Relasi ke Kode Tindakan Terapi */
    public function kodeTindakan()
    {
        return $this->belongsTo(KodeTindakanTerapi::class, 'idkode_tindakan_terapi', 'idkode_tindakan_terapi')->withTrashed();
    }
}
