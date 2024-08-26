<?php

namespace App\Models\Compras;

use App\Models\Productos\Producto;
use App\Models\Proveedores\Proveedor;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory, Uuids;

    protected $table = 'compras';
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $dates = ['creado_en', 'actualizado_en'];


    protected $fillable = [
        'fecha',
        'medio_pago',
        'observaciones',
        'consecutivo',
        'no_remision',
        'valor_compra',
        'proveedor_id',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class,'proveedor_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'compras_tienen_productos')
                    ->withPivot('cantidad', 'precio_unitario', 'total')
                    ->withTimestamps();
    }
}
