<?php

namespace App\Http\Controllers\Configuracion;



use App\Http\Controllers\Controller;
use App\Http\Requests\Configuracion\Almacen\AlmacenRequest;
use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use App\Interfaces\Configuracion\Almacen\AlmacenServicesIntefaces;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ConfiguracionController extends Controller
{

    public function __construct(
        protected AlmacenServicesIntefaces $almacenServicesIntefaces,
        protected CategoriaServicesInterfaces $categoriaServicesInterfaces
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

            $this->almacenServicesIntefaces->registrarInformacionAlmacen($request->all());

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

}
