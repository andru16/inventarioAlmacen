<?php

namespace App\Services\Configuracion\Categoria;


use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use App\Models\Categoria\Categoria;

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

        $categoria         = new Categoria();
        $categoria->nombre = $categoriaRequest['nombre_categoria'];
        $categoria->save();
    }

}
