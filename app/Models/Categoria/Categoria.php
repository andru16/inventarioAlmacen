<?php

namespace App\Models\Categoria;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Categoria extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $guarded = [];
    protected $table = 'categorias_productos';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;


}
