<?php

namespace App\Interfaces\Inventario;

Interface InventarioServicesInterfaces
{
    /**
     * Realizamos el descuento de los productos en el inventario
     *
     * @param $venta
     * @return mixed
     */
    public function reagistrarDescuentoInventario($venta);
}
