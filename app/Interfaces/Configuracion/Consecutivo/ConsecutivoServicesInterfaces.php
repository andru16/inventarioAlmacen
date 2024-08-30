<?php

namespace App\Interfaces\Configuracion\Consecutivo;


use App\Http\Requests\Configuracion\Categoria\CategoriaRequest;
use App\Http\Requests\Configuracion\Marca\MarcaRequest;

interface ConsecutivoServicesInterfaces
{
    /**
     * Generamos el cosecutivo de ventas,compras, factura y pagos.
     *
     * @param string $tipo
     * @return mixed
     */
    public function generarConsecutivo(string $tipo);

    /**
     * Generamos el codigo de barra y retornamos la ruta de la imagen para guardarla en base de datos
     *
     * @param $idProducto
     * @return mixed
     */
    public function generarCodigoDeBarras($idProducto);
}
