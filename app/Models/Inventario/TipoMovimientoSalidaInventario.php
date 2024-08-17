<?php

namespace App\Models\Inventario;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TipoMovimientoSalidaInventario extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $guarded = [];
    protected $table = 'tipo_movimientos_salidas_inventario';
    protected $keyType = 'string';
    public $incrementing = false;
}
