<?php

namespace App\Services\Ventas;


use App\Http\Decimales\Decimales;
use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use App\Interfaces\Ventas\VentasServicesInterfaces;
use App\Models\Inventario\Inventario;
use App\Models\Ventas\Venta;
use App\Models\Ventas\VentaTieneProducto;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class VentasServices implements VentasServicesInterfaces
{

    public function __construct(
        protected ConsecutivoServicesInterfaces $consecutivoServicesInterfaces,
        protected Decimales $decimales,
    )
    {}


    /**
     * Registramos la venta realizada
     *
     * @param $ventaRequest
     * @return Venta
     * @throws \Exception
     */
    public function registrarVenta($ventaRequest): Venta
    {

        $consecutivoSalida = $this->consecutivoServicesInterfaces->generarConsecutivo('venta');

        $venta               = new Venta();
        $venta->id_almacen   = Auth::user()->almacen_id;
        $venta->numero_venta = $consecutivoSalida;
        $venta->fecha_venta  = $ventaRequest->fecha_factura;
        $venta->valor_venta  = $this->decimales->convertirEnDecimalSQLSrv($ventaRequest->totalFactura);
        $venta->save();

        $this->registrarItemsVenta($ventaRequest->listaProductos, $venta->id);

        return $venta;
    }

    /**
     * Registramos los productos que fueron incluidos en la venta
     * @param $productos
     * @param $idVenta
     * @return void
     * @throws \Exception
     */
    public function registrarItemsVenta($productos, $idVenta)
    {
        $itemsVenta = [];
        $idsProductos = [];

        foreach ($productos as $producto){
            $idsProductos[] = $producto['id'];
        }

        $itemsInventario = Inventario::whereIn('id_producto', $idsProductos)->get();

        $idsItemsInventario = [];
        foreach ($itemsInventario as $item) {
            $idsItemsInventario[$item->id_producto] = $item->id;
        }

        foreach ($productos as $producto) {

            $idItemInventario = $idsItemsInventario[$producto['id']];
            $itemsVenta[] = [
                'id' => Uuid::generate()->string,
                'id_item_inventario' => $idItemInventario,
                'id_venta' => $idVenta,
                'cantidad' => $producto['cantidad'],
                'costo_unitario' => $this->decimales->convertirEnDecimalSQLSrv($producto['precio']),
                'costo_total' => $this->decimales->convertirEnDecimalSQLSrv($producto['total']),
            ];

        }

        VentaTieneProducto::insert($itemsVenta);

    }

}
