<?php

namespace app\Services\Proveedor;

use App\Http\Requests\Proveedor\ProveedorRequest;
use App\Interfaces\Proveedor\ProveedorServicesInterfaces;
use App\Models\Proveedores\Proveedor;
use Mockery\Exception;

class  ProveedorServices implements ProveedorServicesInterfaces {

    public function crearProveedor(ProveedorRequest $proveedorRequest)
    {

        $verificarProveedor = Proveedor::where('email', $proveedorRequest['email'])->first();

        if ($verificarProveedor):
            throw new Exception('El proveedor ya se encuentra registrado');
        endif;

        $proveedor = new Proveedor();

        $proveedor->nombre = $proveedorRequest['nombre'];
        $proveedor->telefono = $proveedorRequest['telefono'];
        $proveedor->email = $proveedorRequest['email'];
        $proveedor->direccion = $proveedorRequest['direccion'];
        $proveedor->nombre_contacto = $proveedorRequest['nombre_contacto'];
        $proveedor->save();
    }

    public function actualizarProveedor(ProveedorRequest $proveedorRequest, $id){
        $proveedor = Proveedor::find($id);

        $proveedor->nombre = $proveedorRequest['nombre'];
        $proveedor->telefono = $proveedorRequest['telefono'];
        $proveedor->email = $proveedorRequest['email'];
        $proveedor->direccion = $proveedorRequest['direccion'];
        $proveedor->nombre_contacto = $proveedorRequest['nombre_contacto'];
        $proveedor->save();
    }
}
