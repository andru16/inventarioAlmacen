<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producto\ProductoRequest;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use App\Interfaces\Configuracion\Marca\MarcaServicesInterfaces;
use App\Interfaces\Producto\ProductuoServicesInterfaces;
use App\Models\Productos\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{

    public function __construct(
        protected ProductuoServicesInterfaces $productuoServicesInterfaces,
        protected CategoriaServicesInterfaces $categoriaServicesInterfaces,
        protected MarcaServicesInterfaces $marcaServicesInterfaces,
    ){}

    public function listaProductosSelect(Request $request)
    {
        $productos = Producto::with(['categoria', 'marca', 'inventario'])
                            ->where('id_almacen', Auth::user()->almacen_id)
                            ->where('nombre', 'like', "%" . $request->busqueda . "%")
                            ->get()
                            ->map(function ($producto) {
                                return [
                                  'id'       => $producto->id,
                                  'nombre'   => $producto->nombre,
                                  'marca'    => $producto->marca->nombre,
                                  'precio'   => $producto->inventario->precio,
                                  'precio_format' => '$'.number_format($producto->inventario->precio, 0, ',', '.'),
                                  'cantidad' => (int)$producto->inventario->cantidad_disponible,
                                ];
                            });

        return response()->json($productos);
    }

    public function listarProductos(Request $request)
    {

        $productos = Producto::with(['categoria', 'marca', 'inventario'])->where('id_almacen', Auth::user()->almacen_id);

        return DataTables::eloquent($productos)
            ->addColumn('nombre', function(Producto $producto) {

                return  $producto->nombre;

            })->addColumn('referencia', function(Producto $producto) {
                return $producto->referencia;

            })->addColumn('categoria', function(Producto $producto) {
                return $producto->categoria->nombre;

            })->addColumn('marca', function(Producto $producto) {
                return $producto->marca->nombre;

            })->addColumn('cantidad', function(Producto $producto) {
                return $producto->inventario->cantidad;

            })->addColumn('costo', function(Producto $producto) {
                return '$'.number_format($producto->inventario->costo, 0,',', '.');

            })->setRowId(function (Producto $producto) {
                return $producto->id;
            })

            ->filter( function($query) {

                $buscar = request('buscar');
//
                if ( !empty( $buscar ) ) {

                    $query->where(function ($query) use($buscar){
                        $query->where('nombre', 'like', "%" . $buscar . "%")
                            ->orWhere('referencia', 'like', "%" . $buscar . "%");
                    });

                }

            })
            ->order( function( $query ) {
                $query->orderBy('nombre', 'desc');
            })
            ->toJson();

    }
    public function crearProducto(ProductoRequest $productoRequest)
    {

        DB::beginTransaction();
        try {

            $this->productuoServicesInterfaces->crearProducto($productoRequest);

            DB::commit();
            return response()->json('Producto creado con exíto');
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'codigo' => $exception->getCode(),
                'nombre' => $exception->getMessage()
            ], 422);
        }

    }

    public function actualizarProducto(Request $request, $idProducto)
    {
        DB::beginTransaction();
        try {

            $this->productuoServicesInterfaces->actualizarProducto($request);

            DB::commit();
            return response()->json('Producto actualizado');
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'codigo' => $exception->getCode(),
                'nombre' => $exception->getMessage()
            ], 422);
        }
    }

    /**
     * Llamamos el servicio que lista las categorias
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectCategorias(Request $request)
    {
        $categorias = $this->categoriaServicesInterfaces->listarCategorias($request);
        return response()->json($categorias);

    }

    /**
     * Llamamos el servicio que lista las marcas
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectMarcas(Request $request)
    {
        $marcas = $this->marcaServicesInterfaces->listarMarcas($request);
        return response()->json($marcas);
    }

    public function obtenerProducto(Request $request)
    {
        $producto = $this->productuoServicesInterfaces->obtenerProducto($request->idProducto);

        $categorias = $this->categoriaServicesInterfaces->listarCategorias($request);

        $marcas = $this->marcaServicesInterfaces->listarMarcas($request);

        $infoProducto = [
            'producto'   => $producto,
            'categorias' => $categorias,
            'marcas'     => $marcas
        ];

        return response()->json($infoProducto);
    }

}
