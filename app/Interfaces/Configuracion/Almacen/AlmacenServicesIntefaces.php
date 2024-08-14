<?php

namespace App\Interfaces\Configuracion\Almacen;



use App\Http\Requests\Configuracion\Almacen\AlmacenRequest;
use PhpParser\Node\Expr\Cast\Object_;

interface AlmacenServicesIntefaces
{

    /**
     * Registra la información de un almacén
     *
     * @param AlmacenRequest $request
     * @return mixed
     */
    public function registrarInformacionAlmacen(AlmacenRequest $request);

    /**
     * Se obtiene la información del almacén
     *
     * @return ?Object
     */
    public function informacionAlmacen(): ?Object;

}
