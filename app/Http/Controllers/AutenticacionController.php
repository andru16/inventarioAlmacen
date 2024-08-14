<?php

namespace App\Http\Controllers;

use App\Http\Requests\CambioDeClaveRequest;
use App\Http\Requests\IniciarSesionRequest;
use App\Http\Seguimiento\Localizacion;
use App\Models\Autenticacion\InicioSesion;
use App\Models\Usuarios\Usuario;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AutenticacionController extends Controller
{
    public function vistaIniciarSesion()
    {
        return view('autenticacion.login');
    }

    public function cerrarSesion(Request $request, Redirector $redirector)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $redirector->to('/');

    }

    public function iniciarSesion(IniciarSesionRequest $request, Localizacion $localizacion)
    {

        $credenciales = [
            'correo_electronico' => $request->correo_electronico,
            'password'           => $request->password
        ];

        if( Auth::attempt($credenciales, false) ) {

            $request->session()->regenerate();
            $request->session()->put('correo_electronico', $request->correo_electronico);

//            $registrarInicioSesion             = new InicioSesion();
//            $registrarInicioSesion->id_usuario = Auth::user()->id;
//            $registrarInicioSesion->ip_usuario = $localizacion->obtenerIPReal();
//            $registrarInicioSesion->save();

            // Identificar el rol o permiso y retornar la URL
            $redireccionarA = '/inicio';
            // Hacemos la comprobación de las credenciales para redireccionar la página en la cual se encontraba antes.
            if ($request->session()->has('url.intended')) {
                $redireccionarA = $request->session()->get('url.intended');
            }

//            if(Auth::user()->cambio_clave === '1'){
//                $redireccionarA = '/cambiar-clave';
//            }

//            if( Auth::user()->can('Gerencia')) {
//                $redireccionarA = '/dashboard-gerencial/ventas';
//            }

            return response()->json([
                'mensaje'     => 'Usuario autenticado',
                'redireccion' => $redireccionarA
            ]);
        }

        return response()->json([
            'mensaje' => 'El usuario o la contraseña con incorrectos'
        ], 422);

    }

    public function VistaCambiarClave(){

        /*
         * Si el usuario no tiene el campo de cambio de clave activo
         * lo redireccionamos al login
         * */

        if( auth()->user()->cambio_clave === '0' ){
            return redirect('/');
        }

        return view('autenticacion.cambio_contrasena');

    }

    public function cambiarContrasena(CambioDeClaveRequest $request){

        if ( $request->password !== $request->confirmPassword ) {
            return response()->json([
                'mensaje' => 'Las contraseñas no coinciden'
            ], 423);
        }

        DB::beginTransaction();
        try {

            $usuario = Usuario::find(Auth::user()->id);
            $usuario->password = $request->password;
            $usuario->cambio_clave = 0;
            $usuario->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'Contraseña cambiada correctamente'
            ]);

        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($exception, 425);
        }

    }
}
