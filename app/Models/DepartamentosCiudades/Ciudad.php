<?php

namespace App\Models\DepartamentosCiudades;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'ciudades';

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

}
