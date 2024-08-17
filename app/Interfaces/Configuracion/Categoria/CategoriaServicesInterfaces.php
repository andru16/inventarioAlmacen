<?php

namespace App\Interfaces\Configuracion\Categoria;


use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use http\Env\Request;

interface CategoriaServicesInterfaces
{

    /**
     * Establecemos las reglas de negocio de nuestra clase
     *
     * @param CategoriaRequest $categoriaRequest
     * @return mixed
     */
    public function crearCategoria(CategoriaRequest $categoriaRequest);

    /**
     * Establecemos las reglas de la clase
     * @param  $request
     * @return mixed
     */
    public function listarCategorias( $request);
}
