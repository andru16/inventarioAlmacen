<?php

namespace App\Interfaces\Proveedor;

use App\Http\Requests\Proveedor\ProveedorRequest;

interface ProveedorServicesInterfaces
{
    public function crearProveedor(ProveedorRequest $proveedorRequest);
    public function actualizarProveedor(ProveedorRequest $proveedorRequest, $id);
}
