<?php

namespace App\Interfaces\Ventas;

use App\Models\Ventas\Venta;

interface VentasServicesInterfaces
{

    /**
     * Se raliza el registro de la venta y el registro de los productos de la venta
     *
     * @param $ventaRequest
     * @return Venta
     */
    public function registrarVenta($ventaRequest):Venta;

}
