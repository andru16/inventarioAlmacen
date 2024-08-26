<?php

namespace App\Services\Compras;

use App\Http\Requests\Compras\CompraRequest;
use App\Interfaces\Compras\CompraServicesInterfaces;
use App\Models\Compras\Compra;
use App\Models\Compras\CompraTieneProducto;
use App\Models\Productos\Producto;

class CompraServices implements CompraServicesInterfaces
{
    /**
     * Crear una nueva compra.
     *
     * @param CompraRequest $compraRequest
     * @return Compra
     */
    public function crearCompra(CompraRequest $compraRequest)
    {

        $ultimoConsecutivo = Compra::max('consecutivo');
        $nuevoConsecutivo = $ultimoConsecutivo ? $ultimoConsecutivo + 1 : 1;

        $compra = Compra::create([
            'fecha' => $compraRequest->fecha,
            'medio_pago' => $compraRequest->medio_pago,
            'observaciones' => $compraRequest->observaciones,
            'consecutivo' => str_pad($nuevoConsecutivo, 6, '0', STR_PAD_LEFT),
            'no_remision' => $compraRequest->no_remision,
            'valor_compra' => $compraRequest->valor_compra,
            'proveedor_id' => $compraRequest->proveedor_id,
            'estado' => $compraRequest->estado,
        ]);

        $this->guardarProductosCompra($compra, $compraRequest->items);

        return $compra;
    }

    /**
     * Actualizar una compra existente.
     *
     * @param CompraRequest $compraRequest
     * @param string $id
     * @return Compra
    */
    public function actualizarCompra(CompraRequest $compraRequest, $id)
    {
        $compra = Compra::findOrFail($id);
        $compra->update($compraRequest->only([
            'fecha',
            'medio_pago',
            'observaciones',
            'no_remision',
            'valor_compra',
            'proveedor_id',
            'estado',
        ]));

        // Eliminar los productos existentes antes de agregar los nuevos
        $compra->productos()->detach();

        $this->guardarProductosCompra($compra, $compraRequest->items);

        return $compra;
    }

    /**
     * Obtener una compra específica por su ID.
     *
     * @param string $id
     * @return Compra
     */
    public function obtenerCompra($id)
    {
        return Compra::with(['productos', 'proveedor'])->findOrFail($id);
    }

    /**
     * Listar todas las compras.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listarCompras()
    {
        return Compra::with(['productos', 'proveedor'])->get();
    }

    /**
     * Guardar los productos asociados a una compra.
     *
     * @param Compra $compra
     * @param array $items
     * @return void
     */
    private function guardarProductosCompra(Compra $compra, array $items)
    {
        foreach ($items as $item) {

            $compraTieneProducto = new CompraTieneProducto();

            $compraTieneProducto->compra_id = $compra->id;
            $compraTieneProducto->producto_id = $item['producto_id'];
            $compraTieneProducto->cantidad = $item['cantidad'];
            $compraTieneProducto->precio_unitario = $item['precio_unitario'];
            $compraTieneProducto->total = $item['cantidad'] * $item['precio_unitario'];
            $compraTieneProducto->save();

        }
    }
}
