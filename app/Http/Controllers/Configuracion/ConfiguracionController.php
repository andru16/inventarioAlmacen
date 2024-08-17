<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuracion\Almacen\AlmacenRequest;
use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use App\Http\Requests\Configuracion\Marca\MarcaRequest;
use App\Interfaces\Configuracion\Almacen\AlmacenServicesIntefaces;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use App\Interfaces\Configuracion\Marca\MarcaServicesInterfaces;
use App\Models\Categoria\Categoria;
use App\Models\Marca\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Yajra\DataTables\Facades\DataTables;

class ConfiguracionController extends Controller
{

    public function __construct(
        protected AlmacenServicesIntefaces $almacenServicesIntefaces,
        protected CategoriaServicesInterfaces $categoriaServicesInterfaces,
        protected MarcaServicesInterfaces $marcaServicesInterfaces,
    ){}

    public function vistaConfiguracion()
    {
        return view('configuracion.vista_configuracion');
    }

    /**
     * Realizamos el llamado del servicio que registrara el registro de la informacion
     *
     * @param AlmacenRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrarInformacionAlmacen(AlmacenRequest $request)
    {
        DB::beginTransaction();
        try {

            $this->almacenServicesIntefaces->registrarInformacionAlmacen($request);

            DB::commit();
            return response()->json('Registro exítoso!');
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'codigo' => $exception->getCode(),
                'nombre' => $exception->getMessage()
            ], 422);
        }

    }

    /**
     * Se obtiene información del almacén
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function informacionAlmacen()
    {
        try {

            $almacen = $this->almacenServicesIntefaces->informacionAlmacen();

            return response()->json($almacen);

        }catch (Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Listamos las categorias registradas en el sistema
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listadoCategorias(Request $request)
    {

        $categorias = Categoria::query();

        return DataTables::eloquent($categorias)
            ->addColumn('count', function(Categoria $categoria) {
                $count = 1;
                return  $count++ ;

            })->addColumn('nombre', function(Categoria $categoria) {
                return $categoria->nombre;

            })->setRowId(function (Categoria $categoria) {
                return $categoria->id;
            })

            ->filter( function($query) {

//                $buscar = request('buscar');
//
//                if ( !empty( $buscar ) ) {
//
//                    $query->where('nombres', 'like', "%" . $buscar . "%")
//                        ->orWhere('apellidos', 'like', "%" . $buscar . "%");
//
//                }

            })
            ->order( function( $query ) {
                $query->orderBy('nombre', 'desc');
            })
            ->toJson();

    }

    /**
     *  Realizamos la creación de la categoria por medio de un servicio.
     *
     * @param CategoriaRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrarCategoria(CategoriaRequest $request)
    {
        DB::beginTransaction();
            try {

                $this->categoriaServicesInterfaces->crearCategoria($request->all());

                DB::commit();
                return response()->json('Categoria registrada exitosamente!');
            }catch (\Exception $exception){
                DB::rollBack();
                return response()->json([
                    'codigo' => $exception->getCode(),
                    'nombre' => $exception->getMessage()
                ], 422);
            }
    }

    public function registrarMarca(MarcaRequest $marcaRequest)
    {

        DB::beginTransaction();
            try {

                $this->marcaServicesInterfaces->crearMarca($marcaRequest);

                DB::commit();
                return response()->json('Marca registrada exitosamente!');
            }catch (\Exception $exception){
                DB::rollBack();
                return response()->json([
                    'codigo' => $exception->getCode(),
                    'nombre' => $exception->getMessage()
                ], 422);
            }

    }

    public function listadoMarcas(Request $request)
    {
        $marcas = Marca::query();

        return DataTables::eloquent($marcas)
            ->addColumn('count', function(Marca $marca) {
                $count = 1;
                return  $count++ ;

            })->addColumn('nombre', function(Marca $marca) {
                return $marca->nombre;

            })->setRowId(function (Marca $marca) {
                return $marca->id;
            })

            ->filter( function($query) {

            })
            ->order( function( $query ) {
                $query->orderBy('nombre', 'desc');
            })
            ->toJson();
    }


}
