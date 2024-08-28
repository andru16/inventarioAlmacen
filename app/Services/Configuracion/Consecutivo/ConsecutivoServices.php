<?php

namespace App\Services\Configuracion\Consecutivo;

use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use Illuminate\Support\Facades\DB;

class ConsecutivoServices implements ConsecutivoServicesInterfaces
{
    private $configuracionTablas = [
        'factura' => ['tabla' => 'facturas', 'campo' => 'numero_factura'],
        'venta' => ['tabla' => 'ventas', 'campo' => 'numero_venta'],
        'compra' => ['tabla' => 'compras', 'campo' => 'numero_ingreso'],
        'pago' => ['tabla' => 'pagos_facturas', 'campo' => 'consecutivo'],
    ];

    public function generarConsecutivo(string $tipo)
    {

        if (!isset($this->configuracionTablas[$tipo])) {
            throw new \Exception("Tipo no reconocido: {$tipo}");
        }

        $prefijo = $this->obtenerPrefijo($tipo);
        $ultimoNumero = $this->obtenerUltimoNumero($tipo);
        $siguienteNumero = $ultimoNumero + 1;

        return $this->formatearConsecutivo($tipo, $prefijo, $siguienteNumero);
    }

    private function obtenerPrefijo(string $tipo)
    {
        $prefijos = [
            'factura' => 'FT',
            'venta' => 'VTA',
            'compra' => 'CMP',
            'pago' => 'PG',
        ];

        return $prefijos[$tipo] ?? '';
    }

    private function obtenerUltimoNumero(string $tipo)
    {
        $config = $this->configuracionTablas[$tipo];
        $tabla = $config['tabla'];
        $campo = $config['campo'];

        $ultimoRegistro = DB::table($tabla)
            ->orderBy($campo, 'desc')
            ->first();

        if (!$ultimoRegistro) {
            return 0;
        }

        $ultimoConsecutivo = $ultimoRegistro->$campo;

        // Extraer el número del consecutivo
        preg_match('/\d+$/', $ultimoConsecutivo, $matches);
        return intval($matches[0] ?? 0);
    }

    private function formatearConsecutivo(string $tipo, string $prefijo, int $numero)
    {
        if ($tipo === 'factura') {
            $año = date('Y');
            return "{$año}-{$prefijo}-" . str_pad($numero, 6, '0', STR_PAD_LEFT);
        }

        return "{$prefijo}-" . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
}
