<?php

namespace App\Services\Inventario;

use App\Interfaces\Inventario\InventarioServicesInterfaces;
use App\Models\Inventario\Inventario;
use mysql_xdevapi\Exception;

Class InventarioServices implements InventarioServicesInterfaces
{
    /**
     * Realizamos el descuento de productos en el inventario
     *
     * @param $venta
     * @return void
     */
    public function reagistrarDescuentoInventario($venta)
    {
        $venta->load('productosVenta');

        $idsItems = [];

        foreach ($venta->productosVenta as $producto){
            $idsItems[] = [$producto->id_item_inventario];
        }

        $itemsInventarioSql = Inventario::whereIn('id', $idsItems)->get();

        $itemsInventario = [];
        foreach ($itemsInventarioSql as $item){
            $itemsInventario[$item->id] = [
                'id'                  => $item->id,
                'id_producto'         => $item->id_producto,
                'cantidad'            => $item->cantidad,
                'cantidad_reservada'  => $item->cantidad_reservada,
                'cantidad_disponible' => $item->cantidad_disponible,
                'costo'               => $item->costo,
                'precio'              => $item->precio,
            ];
        }

        $itemsADescontar = [];
        foreach ($venta->productosVenta as $itemVenta){
            if (!$itemsInventario[$itemVenta->id_item_inventario]){
                throw new Exception('No se encontro el producto en el inventario');
            }

            if ($itemVenta->cantidad > $itemsInventario[$itemVenta->id_item_inventario]['cantidad_disponible']){
                throw new \Exception('Stock insuficiente');
            }

            $cantidadADescontar = $itemVenta->cantidad;

            $cantidad = $itemsInventario[$itemVenta->id_item_inventario]['cantidad'] - $cantidadADescontar;
            if ($itemsInventario[$itemVenta->id_item_inventario]['cantidad_reservada'] > 0) {
                $cantidadReservada = $itemsInventario[$itemVenta->id_item_inventario]['cantidad_reservada'] - $cantidadADescontar;
            } else {
                $cantidadReservada = $itemsInventario[$itemVenta->id_item_inventario]['cantidad_reservada'];
            }
            $cantidadDisponible = $cantidad - $cantidadReservada;

            $itemsADescontar[] = [
                'id'                  => $itemVenta->id_item_inventario,
                'id_producto'         => $itemsInventario[$itemVenta->id_item_inventario]['id_producto'],
                'cantidad'            => $cantidad,
                'cantidad_reservada'  => $cantidadReservada,
                'cantidad_disponible' => $cantidadDisponible,
                'costo'               => $itemsInventario[$itemVenta->id_item_inventario]['costo'],
                'precio'              => $itemsInventario[$itemVenta->id_item_inventario]['precio'],
            ];
        }

        Inventario::upsert($itemsADescontar, ['id'], ['id_producto', 'cantidad', 'cantidad_reservada', 'cantidad_disponible', 'costo', 'precio']);
    }
}
