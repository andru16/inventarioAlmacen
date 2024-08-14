<?php

namespace App\Models\Almacen;

use App\Models\DepartamentosCiudades\Ciudad;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Almacen extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $guarded = [];
    protected $table = 'almacenes';
    protected $keyType = 'string';
    public $incrementing = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';
    protected $dates = ['creado_en', 'actualizado_en'];


    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class,  'id_ciudad');
    }

}
