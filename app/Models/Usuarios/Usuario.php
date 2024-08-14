<?php

namespace App\Models\Usuarios;

use App\Models\Almacen\Almacen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Uuids;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, Uuids;

    protected $guarded = [];
    protected $table = 'usuarios';
    protected $keyType = 'string';
    public $incrementing = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $dates = ['creado_en', 'actualizado_en'];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute( $clave )
    {
        return $this->attributes['password'] = bcrypt( $clave );
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }


}
