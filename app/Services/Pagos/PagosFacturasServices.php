<?php

namespace App\Services\Pagos;

use App\Interfaces\Pagos\PagosFacturaServicesInterfaces;
use App\Models\Pagos\PagoFactura;

Class PagosFacturasServices implements PagosFacturaServicesInterfaces
{

    /**
     *  Registramos el recaudo a una factura
     *
     * @param object $recaudo
     * @return PagoFactura
     */
    public function registrarPagoDeFactura(object $recaudo): PagoFactura
    {

        $nuevoRecaudo                 = new PagoFactura();
        $nuevoRecaudo->id_factura     = $recaudo->id_factura;
        $nuevoRecaudo->valor_pago     = $recaudo->valor_pago;
        $nuevoRecaudo->numero_pago    = $recaudo->numero_recaudo;
        $nuevoRecaudo->fecha_pago     = $recaudo->fecha_pago;
        $nuevoRecaudo->save();

        return $nuevoRecaudo;

    }
}
