<?php

namespace App\Services\Clientes;

use App\Http\Requests\Clientes\ClienteRequest;
use App\Interfaces\Clientes\ClientesServicesInterfaces;
use App\Models\Clientes\ClienteAlmacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Class ClientesServices implements ClientesServicesInterfaces
{

    public function selectClientes(Request $request)
    {
        return ClienteAlmacen::where('estado', 1)->where('id_almacen', Auth::user()->almacen_id)->get();
    }


    /**
     * Creamos el cliente a un almacen en especifico
     *
     * @param $nombre
     * @param $telefono
     * @return ClienteAlmacen
     * @throws \Exception
     *
     */
    public function crearCliente($nombre, $telefono):ClienteAlmacen
    {

        try {

            $cliente =  new ClienteAlmacen();
            $cliente->nombre     = $nombre;
            $cliente->telefono   = $telefono;
            $cliente->id_almacen = Auth::user()->almacen_id;
            $cliente->save();

            return $cliente;

        }catch (\Exception $exception){
            throw new \Exception("Error al crear el cliente: " . $exception->getMessage());
        }

    }

}
