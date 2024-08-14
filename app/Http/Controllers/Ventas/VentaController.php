<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function vistaVentas()
    {
        return view('ventas.listar_ventas');
    }
}
