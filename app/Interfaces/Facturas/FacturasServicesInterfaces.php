<?php

namespace App\Interfaces\Facturas;

use App\Models\Facturacion\Factura;

interface FacturasServicesInterfaces
{

    /**
     * Creamos la factura e incluimos los productos que deben ser facturados
     * @param $ventaRequest
     * @param $venta
     * @param $cliente
     * @return Factura
     */
    public function crearFactura($ventaRequest, $venta, $cliente):Factura;

}
