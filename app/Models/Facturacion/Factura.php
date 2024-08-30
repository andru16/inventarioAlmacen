<?php

namespace App\Models\Facturacion;

use App\Models\Clientes\ClienteAlmacen;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Factura extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $guarded = [];
    protected $table = 'facturas';
    protected $keyType = 'string';
    public $incrementing = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $dates = ['creado_en', 'actualizado_en'];

    public function productosFactura()
    {
        return $this->hasMany(FacturaTieneProducto::class, 'id_factura');
    }

    public function servicios()
    {
//        return $this->hasMany(Servic)
    }

    public function cliente()
    {
        return $this->belongsTo(ClienteAlmacen::class, 'id_cliente');
    }

}
