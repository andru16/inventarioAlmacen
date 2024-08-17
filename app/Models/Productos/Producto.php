<?php

namespace App\Models\Productos;

use App\Models\Categoria\Categoria;
use App\Models\Inventario\Inventario;
use App\Models\Marca\Marca;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Producto extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $guarded = [];
    protected $table = 'productos';
    protected $keyType = 'string';
    public $incrementing = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $dates = ['creado_en', 'actualizado_en'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'id_producto');
    }

}
