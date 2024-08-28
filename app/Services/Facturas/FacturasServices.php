<?php

namespace App\Services\Facturas;

use App\Http\Decimales\Decimales;
use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use App\Interfaces\Facturas\FacturasServicesInterfaces;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\FacturaTieneProducto;
use App\Models\Ventas\VentaTieneProducto;
use Webpatser\Uuid\Uuid;

class FacturasServices implements FacturasServicesInterfaces
{

    public function __construct
    (
        protected ConsecutivoServicesInterfaces $consecutivoServicesInterfaces,
        protected Decimales $decimales,
    ){}

    /**
     * Se crea la factura de la venta realizada
     *
     * @param $ventaRequest
     * @param $venta
     * @param $cliente
     * @return Factura
     */
    public function crearFactura($ventaRequest, $venta, $cliente):Factura
    {

        $consecutivo = $this->consecutivoServicesInterfaces->generarConsecutivo('factura');

        $factura = new Factura();
        $factura->id_cliente = $cliente->id;
        $factura->id_venta = $venta->id;
        $factura->numero_factura = $consecutivo;
        $factura->fecha_emision = $ventaRequest->fecha_factura;
        $factura->valor_factura = $venta->valor_venta;
        $factura->descuento = $this->decimales->convertirEnDecimalSQLSrv($ventaRequest->descuento);
        $factura->fecha_vencimiento = $ventaRequest->fecha_vencimiento;
        $factura->estado_factura = $ventaRequest->estado;
        $factura->save();

        $this->registrarItemsFactura($factura, $venta);

        return $factura;

    }

    /**
     * Registramos los productos que fueron incluidos en la factura
     *
     * @param $factura
     * @param $venta
     * @return void
     */
    public function registrarItemsFactura($factura, $venta)
    {
        $venta->load(['productosVenta.inventario.producto']);

        $productosVenta = [];
        foreach ($venta->productosVenta as $itemVenta){
            $productosVenta[] = [
                'id'              => Uuid::generate()->string,
                'id_factura'      => $factura->id,
                'id_producto'     => $itemVenta->inventario->producto->id,
                'cantidad'        => $itemVenta->cantidad,
                'precio_unitario' => $itemVenta->costo_unitario,
                'total'           => $itemVenta->costo_total
            ];
        }

        FacturaTieneProducto::insert($productosVenta);

    }

}
