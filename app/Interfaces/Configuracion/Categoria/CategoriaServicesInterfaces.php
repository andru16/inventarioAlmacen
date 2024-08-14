<?php

namespace App\Interfaces\Configuracion\Categoria;


use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;

interface CategoriaServicesInterfaces
{

    /**
     * Establecemos las reglas de negocio de nuestra clase
     *
     * @param CategoriaRequest $categoriaRequest
     * @return mixed
     */
    public function crearCategoria(CategoriaRequest $categoriaRequest);

}
