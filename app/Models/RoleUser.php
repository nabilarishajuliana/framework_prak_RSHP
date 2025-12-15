<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use SoftDeletes;
    protected $table = 'role_user';
    protected $primaryKey = 'idrole_user';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'iduser',
        'idrole',
        'status',
        'deleted_at',
        'deleted_by'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }
        public function temuDokter()
    {
        return $this->hasMany(TemuDokter::class, 'idrole_user', 'idrole_user');
    }
}


// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class RoleUser extends Model
// {
//      protected $table = 'role_user';
//     protected $primaryKey = 'idrole_user';
//     public $timestamps = false;

//     protected $fillable = ['iduser', 'idrole'];

//     // Relasi ke User
//     public function user()
//     {
//         return $this->belongsTo(User::class, 'iduser', 'iduser');
//     }

//     // Relasi ke Role
//     public function role()
//     {
//         return $this->belongsTo(Role::class, 'idrole', 'idrole');
//     }

//     public function temuDokter()
//     {
//         return $this->hasMany(TemuDokter::class, 'idrole_user', 'idrole_user');
//     }
// }
