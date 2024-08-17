<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaInventario extends Model
{
    use HasFactory;

    public function movimientoSalida()
    {
        return $this->belongsTo(TipoMovimientoSalidaInventario::class, 'id_tipo_movimiento');
    }
}
