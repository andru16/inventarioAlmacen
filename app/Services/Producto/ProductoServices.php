<?php

namespace App\Services\Producto;



use App\Http\Requests\Producto\ProductoRequest;
use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use App\Interfaces\Producto\ProductuoServicesInterfaces;
use App\Models\Inventario\Inventario;
use App\Models\Productos\Producto;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class ProductoServices implements ProductuoServicesInterfaces
{

    public function __construct
    (
        protected ConsecutivoServicesInterfaces $consecutivoServicesInterfaces,
    ){}

    public function crearProducto(ProductoRequest $productoRequest)
    {

        $verificarProducto = Producto::where('nombre', $productoRequest['producto'])
            ->where('id_almacen', Auth::user()->almacen_id)
            ->first();

        if ($verificarProducto) {
            throw new Exception('El producto ya se encuentra registrado');
        }

        $productoConsecutivo = Producto::where('id_almacen', Auth::user()->almacen_id)
            ->latest('id')
            ->first();

        $siglas = 'PT';
        $consecutivo = 1;

        if ($productoConsecutivo) {
            $ultimoConsecutivo = (int) substr($productoConsecutivo->referencia, 2);
            $consecutivo = $ultimoConsecutivo + 1;
        }

        $referencia = $siglas . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

        $producto                 = new Producto();
        $producto->nombre         = $productoRequest['producto'];
        $producto->id_categoria   = $productoRequest['select_categoria'];
        $producto->id_almacen     = Auth::user()->almacen_id;
        $producto->id_marca       = $productoRequest['select_marca'];
        $producto->referencia     = $referencia;
        $producto->stock_minimo   = $productoRequest['stock_minimo'];
        $producto->save();

        $producto->codigo_de_barras = $this->consecutivoServicesInterfaces->generarCodigoDeBarras($producto->id);
        $producto->save();
        //Regisramos el producto en el inventario
        $itemInventario = Inventario::where('id_producto', $producto->id)->first();

        if ($itemInventario){
            throw new Exception('El item ya existe en el inventario');
        }

        $inventario              = new Inventario();
        $inventario->id_producto = $producto->id;
        $inventario->save();

    }

    public function obtenerProducto($idProducto)
    {
        return Producto::with('categoria', 'marca', 'inventario')
                        ->where('id_almacen', Auth::user()->almacen_id)
                        ->findOrFail($idProducto);
    }

    public function actualizarProducto($producto)
    {
        try {

            $productoSql               = Producto::findOrFail($producto->id);
            $productoSql->nombre       = $producto->nombre;
            $productoSql->id_categoria = $producto->id_categoria;
            $productoSql->id_almacen   = Auth::user()->almacen_id;
            $productoSql->id_marca     = $producto->id_marca;
            $productoSql->referencia   = $producto->referencia;
            $productoSql->stock_minimo =  $producto->stock_minimo;
            $productoSql->save();

        }catch (\Exception $exception) {
            return response()->json('Error al procesar la información: ' . $exception->getMessage(), 422);
        }

    }
}
