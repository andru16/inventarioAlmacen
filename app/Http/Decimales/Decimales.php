<?php

namespace App\Http\Decimales;

class Decimales
{

    public function convertirEnDecimalSQLSrv( $valor )
    {

        $buscar = ['.', ','];
        $reemplazar = ['', '.'];
        return (float) str_replace($buscar, $reemplazar, $valor);

    }

    public function importacionSQL( $valor )
    {

        $buscar = [','];
        $reemplazar = [''];
        return (float) str_replace($buscar, $reemplazar, $valor);

    }

}
