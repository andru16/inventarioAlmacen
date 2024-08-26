<?php

namespace App\Http\Controllers\Proveedores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proveedor\ProveedorRequest;
use App\Interfaces\Proveedor\ProveedorServicesInterfaces;
use App\Models\Proveedores\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProveedorController extends Controller
{

    public function __construct(
        protected ProveedorServicesInterfaces $proveedorServicesInterfaces,
    ){}

    /**
     * Lista los proveedores para selección en un campo select.
     */
    public function listaProveedoresSelect(Request $request)
    {
        
        $proveedores = Proveedor::where('nombre', 'like', "%" . $request->busqueda . "%")
                            ->get()
                            ->map(function ($proveedor) {
                                return [
                                    'id' => $proveedor->id,
                                    'nombre' => $proveedor->nombre,
                                ];
                            });

        return response()->json($proveedores);
    }

    /**
     * Lista todos los proveedores en formato DataTables.
     */
    public function listarProveedores(Request $request)
    {
        $proveedores = Proveedor::query();

        if ($buscar = $request->input('buscar')) {
            $proveedores->where(function ($query) use ($buscar) {
                $query->where('nombre', 'like', "%" . $buscar . "%")
                    ->orWhere('email', 'like', "%" . $buscar . "%")
                    ->orWhere('telefono', 'like', "%" . $buscar . "%");
            });
        }

        return DataTables::eloquent($proveedores)
            ->addColumn('nombre', function(Proveedor $proveedor) {
                return $proveedor->nombre;
            })
            ->addColumn('email', function(Proveedor $proveedor) {
                return $proveedor->email;
            })
            ->addColumn('telefono', function(Proveedor $proveedor) {
                return $proveedor->telefono;
            })
            ->addColumn('direccion', function(Proveedor $proveedor) {
                return $proveedor->direccion;
            })
            ->setRowId(function (Proveedor $proveedor) {
                return $proveedor->id;
            })
            ->toJson();
    }

    /**
     * Crea un nuevo proveedor.
     */
    public function crearProveedor(ProveedorRequest $proveedorRequest)
    {
        DB::beginTransaction();
        try {
            $this->proveedorServicesInterfaces->crearProveedor($proveedorRequest);

            DB::commit();
            return response()->json('Proveedor creado con éxito');
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'codigo' => $exception->getCode(),
                'nombre' => $exception->getMessage()
            ], 422);
        }
    }

    /**
     * Actualiza un proveedor existente.
     */
    public function actualizarProveedor(ProveedorRequest $proveedorRequest, $id)
    {
        DB::beginTransaction();
        try {
            $this->proveedorServicesInterfaces->actualizarProveedor($proveedorRequest, $id);

            DB::commit();
            return response()->json('Proveedor actualizado con éxito');
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'codigo' => $exception->getCode(),
                'nombre' => $exception->getMessage()
            ], 422);
        }
    }

    public function getProveedor(Proveedor $proveedor)
    {
        return response()->json($proveedor);
    }

}
