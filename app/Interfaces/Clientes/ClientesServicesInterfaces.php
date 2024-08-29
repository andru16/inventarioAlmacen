<?php

namespace App\Interfaces\Clientes;

use App\Http\Requests\Clientes\ClienteRequest;
use App\Models\Clientes\ClienteAlmacen;
use Illuminate\Http\Request;

interface ClientesServicesInterfaces
{

    public function selectClientes(Request $request);

    /**
     * Registramos el nuevo cliente del almacen
     *
     * @param $nombre
     * @param $telefono
     * @return ClienteAlmacen
     */
    public function crearCliente( $nombre, $telefono):ClienteAlmacen;

}
