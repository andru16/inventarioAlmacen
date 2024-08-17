<?php

namespace App\Interfaces\Configuracion\Marca;


use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use App\Http\Requests\Configuracion\Marca\MarcaRequest;

interface MarcaServicesInterfaces
{

    /**
     * Establecemos las reglas de nuestra clase de marca
     *
     * @param MarcaRequest $marcaRequest
     * @return mixed
     */
    public function crearMarca(MarcaRequest $marcaRequest);

    public function listarMarcas($datos);

}
