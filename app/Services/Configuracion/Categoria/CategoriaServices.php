<?php

namespace App\Services\Configuracion\Categoria;


use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use App\Models\Categoria\Categoria;
use Illuminate\Support\Facades\Auth;

class CategoriaServices implements CategoriaServicesInterfaces
{

    /**
     * Creamos la categoria
     *
     * @param  $categoriaRequest
     * @return void
     */
    public function crearCategoria( $categoriaRequest)
    {

        $categoria             = new Categoria();
        $categoria->nombre     = $categoriaRequest['nombre_categoria'];
        $categoria->id_almacen = Auth::user()->almacen_id;
        $categoria->save();
    }

    /**
     * Listamos las categorias
     * @param $request
     * @return ?mixed
     */
    public function listarCategorias($request)
    {
        $categorias = Categoria::where('id_almacen', Auth::user()->almacen_id)->get();
        return $categorias;
    }

}
