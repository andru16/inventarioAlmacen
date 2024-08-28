<?php

namespace App\Services\Almacen;

use App\Interfaces\Almacen\ColaboradoresAlmacenServicesInterfaces;
use App\Models\Almacen\ColaboradorAlmacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Class ColaboradoresAlmacenServices implements ColaboradoresAlmacenServicesInterfaces
{
    public function listarColaboradores()
    {
        return ColaboradorAlmacen::where('id_almacen',  Auth::user()->almacen_id)->where('estado', '1')->get();
    }
}
