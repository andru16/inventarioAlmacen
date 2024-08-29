<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Clientes\ClienteAlmacen;
use App\Http\Controllers\Controller;
use App\Http\Decimales\Decimales;
use App\Http\Requests\Ventas\VentaRequest;
use App\Interfaces\Clientes\ClientesServicesInterfaces;
use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use App\Interfaces\Facturas\FacturasServicesInterfaces;
use App\Interfaces\Inventario\InventarioServicesInterfaces;
use App\Interfaces\Pagos\PagosFacturaServicesInterfaces;
use App\Interfaces\Servicios\ServiciosServicesInterfaces;
use App\Interfaces\Ventas\VentasServicesInterfaces;
use App\Models\Inventario\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function __construct
    (
        protected Decimales                     $decimales,
        protected ConsecutivoServicesInterfaces $consecutivoServicesInterfaces,
        protected VentasServicesInterfaces      $ventasServicesInterfaces,
        protected FacturasServicesInterfaces    $facturasServicesInterfaces,
        protected ClientesServicesInterfaces    $clientesServicesInterfaces,
        protected ServiciosServicesInterfaces   $serviciosServicesInterfaces,
        protected PagosFacturaServicesInterfaces $pagosFacturaServicesInterfaces,
        protected InventarioServicesInterfaces   $inventarioServicesInterfaces,
    )
    {}
    public function vistaVentas()
    {
        return view('ventas.listar_ventas');
    }



    public function registrarVenta(VentaRequest $ventaRequest)
    {
        DB::beginTransaction();
        try {

            //Registramos la venta
            $venta = $this->ventasServicesInterfaces->registrarVenta($ventaRequest);

            //Registramos el cliente en caso de que no exista, si existe lo consultamos
            if ($ventaRequest->registrarCliente){
                $cliente = $this->clientesServicesInterfaces->crearCliente($ventaRequest->nombre_cliente, $ventaRequest->telefono);
            }else{
                $cliente = ClienteAlmacen::findOrFail($ventaRequest->id_cliente);
            }

            //Creamos la factura de la venta
            $factura = $this->facturasServicesInterfaces->crearFactura($ventaRequest, $venta, $cliente);

            //Si la venta incluyo un servicio lo registramos
            if ($ventaRequest->incluirServicio){
                $servicio = $this->serviciosServicesInterfaces->crearServicio($ventaRequest, $factura);
            }

            //En caso de que el estado de la factura fuese abono o cancelado, entonces procedemos a hacer ese registro
            if ($ventaRequest->estado == 'Abono' || $ventaRequest->estado == 'Cancelado'){

                $abono =  $this->decimales->convertirEnDecimalSQLSrv($ventaRequest->abono);
                $pagoCompleto = $factura->valor_factura;

                $recaudo = new \stdClass();
                $recaudo->id_factura = $factura->id;
                $recaudo->valor_pago = $ventaRequest->estado == 'Abono' ? $abono : $pagoCompleto;
                $recaudo->numero_recaudo = $this->consecutivoServicesInterfaces->generarConsecutivo('pago');
                $recaudo->fecha_pago = $venta->fecha_venta;

                $recaudoSql = $this->pagosFacturaServicesInterfaces->registrarPagoDeFactura($recaudo);

            }

            //Realizamos el descuento de los productos de la venta en el inventario
            $this->inventarioServicesInterfaces->reagistrarDescuentoInventario($venta);

            DB::commit();
            return response()->json('Ingreso de recaudo exítoso');
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'codigo' => $exception->getCode(),
                'nombre' => $exception->getMessage()
            ], 422);
        }
    }

}
