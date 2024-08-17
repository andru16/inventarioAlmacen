<?php

namespace App\Models\Marca;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Marca extends Model
{
    use HasFactory, Notifiable, Uuids;

    protected $guarded = [];
    protected $table = 'marcas';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}
