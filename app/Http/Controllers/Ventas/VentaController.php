<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Clientes\ClienteAlmacen;
use App\Http\Controllers\Controller;
use App\Http\Decimales\Decimales;
use App\Http\Requests\Ventas\VentaRequest;
use App\Interfaces\Clientes\ClientesServicesInterfaces;
use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use App\Interfaces\Facturas\FacturasServicesInterfaces;
use App\Interfaces\Ventas\VentasServicesInterfaces;
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

            $venta = $this->ventasServicesInterfaces->registrarVenta($ventaRequest);

            if ($ventaRequest->registrarCliente){
                $cliente = $this->clientesServicesInterfaces->crearCliente($ventaRequest->nombre_cliente, $ventaRequest->telefono);
            }else{
                $cliente = ClienteAlmacen::findOrFail($ventaRequest->id_cliente);
            }

            $factura = $this->facturasServicesInterfaces->crearFactura($ventaRequest, $venta, $cliente);

            dd($factura->load('productosFactura'));
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
