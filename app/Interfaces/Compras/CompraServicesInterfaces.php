<?php

namespace App\Interfaces\Compras;

use App\Http\Requests\Compras\CompraRequest;

interface CompraServicesInterfaces
{
    public function crearCompra(CompraRequest $compraRequest);

    public function actualizarCompra(CompraRequest $compraRequest, $id);

    public function obtenerCompra($id);

    public function listarCompras();
}
