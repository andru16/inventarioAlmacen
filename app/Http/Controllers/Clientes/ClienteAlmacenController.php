<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Interfaces\Clientes\ClientesServicesInterfaces;
use Illuminate\Http\Request;

class ClienteAlmacenController extends Controller
{
    public function __construct
    (
        protected ClientesServicesInterfaces $clientesServicesInterfaces
    ){}

    public function selectClientes(Request $request)
    {
        try{

            return  response()->json($this->clientesServicesInterfaces->selectClientes($request));

        } catch (\Exception $exception){
            return response()->json($exception);
        }
    }
}
