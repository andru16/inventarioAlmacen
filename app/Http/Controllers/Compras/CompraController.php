<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function vistaCompras()
    {
        return view('compras.listar_compras');
    }
}
