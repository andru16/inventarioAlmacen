<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function vistaInventario()
    {
        return view('inventario.listar_inventario');
    }
}
