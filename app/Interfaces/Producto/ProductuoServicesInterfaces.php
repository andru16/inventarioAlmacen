<?php

namespace App\Interfaces\Producto;


use App\Http\Requests\Producto\ProductoRequest;

interface ProductuoServicesInterfaces
{

    public function crearProducto(ProductoRequest $productoRequest);

}
