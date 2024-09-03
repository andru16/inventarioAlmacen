<?php

namespace App\Interfaces\Producto;


use App\Http\Requests\Producto\ProductoRequest;

interface ProductuoServicesInterfaces
{

    /**
     * Creamos el producto y lo creamos en el inventario
     *
     * @param ProductoRequest $productoRequest
     * @return mixed
     */
    public function crearProducto(ProductoRequest $productoRequest);


    /**
     * Obtenemos un producto en especifico por medio de su id
     *
     * @param $idProducto
     * @return mixed
     */
    public function obtenerProducto($idProducto);

    public function actualizarProducto($producto);

}
