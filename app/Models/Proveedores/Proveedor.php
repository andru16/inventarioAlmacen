<?php

namespace App\Models\Proveedores;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory, Uuids;

    protected $table = 'proveedores';
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $dates = ['creado_en', 'actualizado_en'];

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'direccion',
        'nombre_contacto',
        'estado',
    ];
}
