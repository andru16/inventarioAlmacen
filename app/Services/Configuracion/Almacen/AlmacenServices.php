<?php

namespace App\Services\Configuracion\Almacen;

use App\Http\Requests\Configuracion\Almacen\AlmacenRequest;
use App\Interfaces\Configuracion\Almacen\AlmacenServicesIntefaces;
use App\Models\Almacen\Almacen;
use App\Models\Usuarios\Usuario;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Auth;

class AlmacenServices implements AlmacenServicesIntefaces
{

    public function registrarInformacionAlmacen(AlmacenRequest $request)
    {
       //Registramos el nuevo almacen
        $almacen            = new Almacen();
        $almacen->nombre    = $request['nombre_almacen'];
        $almacen->direccion = $request['direccion'];
        $almacen->correo    = $request['correo_electronico'];
        $almacen->telefono  = $request['telefono'];
        $almacen->whatsapp  = $request['whatsapp'];
        $almacen->id_ciudad = $request['select_ciudad'];
        $almacen->save();

        //Actualizamos el id del usuario que guardo la información del almacén, como pertenecienteal almacen registrado
        $usuario =  Usuario::find(Auth::id());
        $usuario->almacen_id = $almacen->id;
        $usuario->save();


    }

    /**
     * Obtenemos la informacion del almacen, con sus relaciones incluidas.
     *
     * @return ?Object
     */
    public function informacionAlmacen(): ?Object
    {

        $almacen = Almacen::with(['ciudad' => function($query){
                                $query->with('departamento');
                            }])->where('id', Auth::user()->almacen_id)
                            ->first();

        return $almacen;

    }

}
