<?php

namespace App\Interfaces\Configuracion\Consecutivo;


use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use App\Http\Requests\Configuracion\Marca\MarcaRequest;

interface ConsecutivoServicesInterfaces
{
    public function generarConsecutivo(string $tipo);
}
