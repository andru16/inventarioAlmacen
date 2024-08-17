<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Models\Inventario\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InventarioController extends Controller
{
    public function vistaInventario()
    {
        return view('inventario.listar_inventario');
    }

    public function listarProductos(Request $request)
    {
        $itemsInventario = Inventario::whereHas('productos', function ($query){
            $query->where('id_almacen', Auth::user()->almacen_id);
        })->with(['productos' => function($query){
            $query->with(['categoria', 'marca']);
        }]);

        return DataTables::eloquent($itemsInventario)
            ->addColumn('nombre', function(Inventario $inventario) {
                return  $inventario->productos->nombre ;

            })->addColumn('referencia', function(Inventario $inventario) {
                return $inventario->productos->referencia;

            })->addColumn('segunda_referencia', function(Inventario $inventario) {
                return $inventario->productos->segunda_referencia;

            })->addColumn('categoria', function(Inventario $inventario) {
                return $inventario->productos->categoria->nombre;

            })->addColumn('marca', function(Inventario $inventario) {
                return $inventario->productos->marca->nombre;

            })->addColumn('cantidad', function(Inventario $inventario) {
                return $inventario->cantidad;

            })->addColumn('cantidad_disponible', function(Inventario $inventario) {
                return $inventario->cantidad_disponible;

            })->addColumn('costo', function(Inventario $inventario) {
                return '$'.number_format($inventario->costo, 0,',', '.');

            })->addColumn('precio', function(Inventario $inventario) {
                return '$'.number_format($inventario->precio, 0,',', '.');

            })->setRowId(function (Inventario $inventario) {
                return $inventario ->id;
            })

            ->filter( function($query) {

                $buscar = request('buscar');
//
                if ( !empty( $buscar ) ) {

                    $query->where(function ($query) use($buscar){
                        $query->where('nombre', 'like', "%" . $buscar . "%")
                            ->orWhere('referencia', 'like', "%" . $buscar . "%");
                    });

                }

            })
            ->order( function( $query ) {
//                $query->orderBy('nombre', 'desc');
            })
            ->toJson();
    }

}
