<?php

namespace App\Services\Facturas;

use App\Interfaces\Facturas\FacturasServicesInterfaces;
use App\Interfaces\Facturas\FacturaTieneProductosServicesInterface;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\FacturaTieneProducto;

class FacturasServices implements FacturaTieneProductosServicesInterface
{

    public function registrarProductosFactura($productos, $factura)
    {
        $totalValorFactura =0;
        $idsProductos = [];
        foreach ( $productos as $producto) {
            $idsProductos[] = $producto->id;
            $productosAFacturar[] = [
                'id_factura'           => $factura->id,
                'id_producto'          => $producto->id,
                'cantidad'             => $producto->cantidad,
                'precio_unitario'      => $producto->precio,
                'total'                => $producto->total,
            ];
            $totalValorFactura += $this->decimales->convertirEnDecimalSQLSrv($producto->total);
        }

        FacturaTieneProducto::insert($productosAFacturar);
    }

}
