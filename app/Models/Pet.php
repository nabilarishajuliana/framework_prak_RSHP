<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
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

    protected static function booted()
{
    static::deleting(function ($pet) {

        if ($pet->temuDokter()->whereNull('deleted_at')->exists()) {
            throw new \Exception("Tidak bisa menghapus Pet karena masih memiliki antrian/temu dokter.");
        }

        if ($pet->rekamMedis()->whereNull('deleted_at')->exists()) {
            throw new \Exception("Tidak bisa menghapus Pet karena masih memiliki rekam medis aktif.");
        }
    });
}


    // Accessor untuk umur (return object Carbon interval)
    public function getUmurAttribute()
    {
        // Jika tidak ada tanggal lahir, kembalikan null
        if (!$this->tanggal_lahir) {
            return null;
        }

        $lahir = Carbon::parse($this->tanggal_lahir);
        $now = Carbon::now();

        // Hitung selisih
        $diff = $lahir->diff($now);

        return (object)[
            'tahun' => $diff->y,
            'bulan' => $diff->m
        ];
    }

    // Accessor untuk umur dalam bentuk teks
    public function getUmurTextAttribute()
    {
        // Kalau tanggal lahir belum diisi
        if (!$this->umur) {
            return '-';
        }

        $tahun = $this->umur->tahun;
        $bulan = $this->umur->bulan;

        // Format teks umur
        if ($tahun > 0) {
            return $tahun . ' tahun' . ($bulan > 0 ? " $bulan bulan" : '');
        }

        return $bulan . ' bulan';
    }

}
