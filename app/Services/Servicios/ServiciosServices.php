<?php

namespace App\Services\Servicios;

use App\Http\Decimales\Decimales;
use App\Interfaces\Servicios\ServiciosServicesInterfaces;
use App\Models\Almacen\ColaboradorAlmacen;
use App\Models\Servicios\ServicioAlmacen;
use App\Models\Servicios\ServicioTieneColaborador;
use Webpatser\Uuid\Uuid;

Class ServiciosServices implements ServiciosServicesInterfaces
{

    public function __construct
    (
        protected Decimales $decimales
    ){}

    /**
     * Creamos el servicio realizado por parte de los técnicos
     *
     * @param $ventaRequest
     * @param $factura
     * @return ServicioAlmacen
     */
    public function crearServicio($ventaRequest, $factura):ServicioAlmacen
    {
        $servicio = new ServicioAlmacen();
        $servicio->id_factura = $factura->id;
        $servicio->descripcion = $ventaRequest->descripcionServicio;
        $servicio->valor       = $this->decimales->convertirEnDecimalSQLSrv($ventaRequest->servicio);
        $servicio->save();

        $this->registrarColaboradoresServicio($ventaRequest->colaboradores, $servicio);

        return $servicio;

    }

    /**
     * Registramos los colaboradores que estuvieron en el servicio
     *
     * @param $colaboradores
     * @param $servicio
     * @return void
     * @throws \Exception
     */
    public function registrarColaboradoresServicio($colaboradores, $servicio)
    {
        //Consultamos primero que los colaboradores esten registradoes en el sistema
        $colaboradoresSql = ColaboradorAlmacen::whereIn('id', $colaboradores)->get();

        $colaboradoresServicio = [];
        foreach ($colaboradoresSql as $item) {
            $colaboradoresServicio[] = [
                'id' => Uuid::generate()->string,
                'id_servicio' => $servicio->id,
                'id_colaborador' => $item->id,
            ];
        }

        ServicioTieneColaborador::insert($colaboradoresServicio);

    }

}
