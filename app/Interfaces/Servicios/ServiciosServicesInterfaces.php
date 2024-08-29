<?php

namespace App\Interfaces\Servicios;

use App\Models\Servicios\ServicioAlmacen;

Interface ServiciosServicesInterfaces
{
    /**
     * Creamos el servicio realizado por parte de los técnicos del almacen
     * @param $ventaRequest
     * @param $factura
     * @return ServicioAlmacen
     */
    public function crearServicio($ventaRequest, $factura):ServicioAlmacen;
}
