<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
     protected $table = 'role_user';
    protected $primaryKey = 'idrole_user';
    public $timestamps = false;

    protected $fillable = ['iduser', 'idrole'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }
}
