<?php

namespace App\Models\DepartamentosCiudades;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Departamento extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $table = 'departamentos';

}
