<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Http\Decimales\Decimales;
use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use App\Models\Facturacion\Factura;
use App\Models\Facturacion\FacturaTieneProducto;
use App\Models\Inventario\SalidaInventario;
use App\Models\Inventario\TipoMovimientoSalidaInventario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{

    public function __construct
    (
        protected Decimales $decimales,
        protected ConsecutivoServicesInterfaces $consecutivoServicesInterfaces,
    )
    {}

    public function registrarFactura(Request $request)
    {
        DB::beginTransaction();
        try {

//          $salidaAlmacen = $this->registrarSalida($request);

            $consecutivo = $this->consecutivoServicesInterfaces->generarConsecutivo('factura');
            dd($consecutivo);

            $anio = date('Y');
            $ultimaFactura = Factura::where('numero_factura', 'like', "$anio-FT-%")
                ->orderBy('numero_factura', 'desc')
                ->first();

            if ($ultimaFactura) {
                $consecutivo = intval(substr($ultimaFactura->numero_factura, -5));
                $nuevoConsecutivo = str_pad($consecutivo + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $nuevoConsecutivo = '0001';
            }

            // Crear el nuevo número de factura
            $numeroFactura = $anio . '-FT-' . $nuevoConsecutivo;

            $factura = new Factura();
            $factura->numero_factura    = $numeroFactura;
            $factura->fecha_emision     = $request->fecha_factura;
            $factura->fecha_pago = $request->fecha_vencimiento;
            $factura->nombre_cliente    = $request->nombre_cliente;
            $factura->telefono          = $request->telefono;
            $factura->descuento         = $this->decimales->convertirEnDecimalSQLSrv($request->descuento);
            $factura->servicio          = $this->decimales->convertirEnDecimalSQLSrv($request->servicio);
//            $factura->estado_factura    = $request->estado;
            $factura->id_salida_inventario = '$salidaAlmacen->id';
            $factura->valor_factura = $this->decimales->convertirEnDecimalSQLSrv(80000);
            $factura->save();
            //sacamos el total del costo de la factura y los productos que se facturaran.
            $totalValorFactura = $factura->descuento + $factura->servicio;
            $productosAFacturar = [];
            $idsProductos = [];

            foreach ( $request->listaProductos as $producto) {
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
            dd($totalValorFactura);
            FacturaTieneProducto::insert($productosAFacturar);


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

    public function registrarSalida($datos)
    {


        $ultimaSalida = SalidaInventario::where('numero_factura', 'like', "SA-%")
            ->whereHas('movimientoSalida', function ($query) {
                $query->where('nombre', 'Venta');
            })->orderBy('numero_factura', 'desc')
            ->first();

        if ($ultimaSalida) {
            $consecutivo = intval(substr($ultimaSalida->numero_salida, -5));
            $nuevoConsecutivo = str_pad($consecutivo + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $nuevoConsecutivo = '0001';
        }

        $tipoMovimiento = TipoMovimientoSalidaInventario::where('nombre', 'Venta')->first();
        // Crear el nuevo número de factura
        $numeroSalida = 'SA-' . $nuevoConsecutivo;

        $salida = new SalidaInventario();
        $salida->id_tipo_movimiento = $tipoMovimiento->id;
        $salida->id_almacen = Auth::user()->almacen_id;
        $salida->numero_salida = $numeroSalida;
        $salida->save();

        return $salida;

    }

    public function registrarProductosSalida($idsProductos)
    {

    }

}
