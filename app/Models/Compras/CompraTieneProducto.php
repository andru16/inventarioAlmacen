<?php

namespace App\Models\Compras;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraTieneProducto extends Model
{

    use HasFactory, Uuids;

    protected $table = 'compras_tienen_productos';
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $dates = ['creado_en', 'actualizado_en'];


    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'total',
        'creado_en',
        'actualizado_en',
    ];
}
