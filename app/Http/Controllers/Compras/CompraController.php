<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Interfaces\Compras\CompraServicesInterfaces;
use Illuminate\Http\Request;
use App\Http\Requests\Compras\CompraRequest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CompraController extends Controller
{
    protected $compraServicesInterfaces;

    public function __construct(CompraServicesInterfaces $compraServicesInterfaces)
    {
        $this->compraServicesInterfaces = $compraServicesInterfaces;
    }

    /**
     * Mostrar la vista principal de las compras.
     *
     * @return \Illuminate\View\View
     */
    public function vistaCompras()
    {
        return view('compras.listar_compras');
    }

    /**
     * Listar todas las compras con DataTables.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listarCompras(Request $request)
    {
        $compras = $this->compraServicesInterfaces->listarCompras();

        return DataTables::of($compras)
            ->addColumn('fecha', function ($compra) {
                return $compra->fecha;
            })
            ->addColumn('consecutivo', function ($compra) {
                return $compra->consecutivo;
            })
            ->addColumn('proveedor', function ($compra) {
                return $compra->proveedor->nombre;
            })
            ->addColumn('items', function ($compra) {
                return $compra->productos->pluck('nombre')->join(', ');
            })
            ->addColumn('medio_pago', function ($compra) {
                return $compra->medio_pago;
            })
            ->addColumn('valor_compra', function ($compra) {
                return $compra->valor_compra;
            })
            ->addColumn('observaciones', function ($compra) {
                return $compra->observaciones;
            })
            ->setRowId(function ($compra) {
                return $compra->id;
            })
            ->toJson();

    }

    /**
     * Crear una nueva compra.
     *
     * @param \App\Http\Requests\Compras\CompraRequest $compraRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function crearCompra(CompraRequest $compraRequest)
    {
        DB::beginTransaction();
        try {
            $this->compraServicesInterfaces->crearCompra($compraRequest);
            DB::commit();
            return response()->json('Compra creada con éxito');
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'codigo' => $exception->getCode(),
                'mensaje' => $exception->getMessage()
            ], 422);
        }
    }

    /**
     * Actualizar una compra existente.
     *
     * @param \App\Http\Requests\Compras\CompraRequest $compraRequest
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actualizarCompra(CompraRequest $compraRequest, $id)
    {
        DB::beginTransaction();
        try {
            $this->compraServicesInterfaces->actualizarCompra($compraRequest, $id);
            DB::commit();
            return response()->json('Compra actualizada con éxito');
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'codigo' => $exception->getCode(),
                'mensaje' => $exception->getMessage()
            ], 422);
        }
    }

    /**
     * Obtener los datos de una compra específica
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerCompra($id)
    {
        try {
            $compra = $this->compraServicesInterfaces->obtenerCompra($id);
            return response()->json($compra);
        } catch (\Exception $exception) {
            return response()->json([
                'codigo' => $exception->getCode(),
                'mensaje' => $exception->getMessage()
            ], 404);
        }
    }
}
