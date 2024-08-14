<?php

namespace App\Http\Controllers\DepartamentosCiudades;

use App\Http\Controllers\Controller;
use App\Models\DepartamentosCiudades\Ciudad;
use App\Models\DepartamentosCiudades\Departamento;
use Illuminate\Http\Request;

class CiudadDepartamentoController extends Controller
{
    public function listarDepartamentos(Request $request)
    {
        return response()->json(
            Departamento::where('nombre', 'like', '%'. $request->busqueda . '%')->get()
        );
    }

    public function listarCiudades(Request $request)
    {
        return response()->json(
          Ciudad::where('departamento_id', $request->departamento_id)
                ->where('nombre', 'like', '%'. $request->busqueda . '%')
                ->get()
        );
    }
}
