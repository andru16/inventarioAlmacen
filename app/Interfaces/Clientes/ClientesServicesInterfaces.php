<?php

namespace App\Interfaces\Clientes;

use App\Http\Requests\Clientes\ClienteRequest;
use Illuminate\Http\Request;

interface ClientesServicesInterfaces
{

    public function selectClientes(Request $request);

    public function crearCliente( $nombre, $telefono);

}
