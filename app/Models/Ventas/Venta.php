<?php

namespace App\Models\Ventas;

use App\Models\Facturacion\Factura;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Venta extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $guarded = [];
    protected $table = 'ventas';
    protected $keyType = 'string';
    public $incrementing = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $dates = ['creado_en', 'actualizado_en'];

    public function productosVenta()
    {
        return $this->hasMany(VentaTieneProducto::class, 'id_venta');
    }

    public function factura()
    {
        return $this->hasOne(Factura::class, 'id_venta');
    }

}
