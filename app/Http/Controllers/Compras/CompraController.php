<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Interfaces\Producto\ProductuoServicesInterfaces;
use Illuminate\Http\Request;

class CompraController extends Controller
{

    public function __construct
    (
        protected ProductuoServicesInterfaces $productuoServicesInterfaces
    )
    {}

    public function vistaCompras()
    {
        return view('compras.listar_compras');
    }

    public function crearCompra()
    {
        $this->productuoServicesInterfaces->crearProducto();



    }
}
