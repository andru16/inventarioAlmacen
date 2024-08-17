<?php

namespace App\Services\Configuracion\Marca;


use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use App\Http\Requests\Configuracion\Marca\MarcaRequest;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use App\Interfaces\Configuracion\Marca\MarcaServicesInterfaces;
use App\Models\Categoria\Categoria;
use App\Models\Marca\Marca;
use Illuminate\Support\Facades\Auth;

class MarcaServices implements MarcaServicesInterfaces
{

    /**
     * Registramos la nueva marca
     *
     * @param MarcaRequest $marcaRequest
     * @return void
     */
    public function crearMarca(MarcaRequest $marcaRequest)
    {

        $marca             = new Marca();
        $marca->nombre     = $marcaRequest['nombre_marca'];
        $marca->id_almacen = Auth::user()->almacen_id;
        $marca->save();

    }

    /**
     * @param ?$datos
     * @return ?mixed
     */
    public function listarMarcas($datos): mixed
    {
        $marcas = Marca::where('id_almacen', Auth::user()->almacen_id)->get();
        return $marcas;
    }

}
