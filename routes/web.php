<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\Proveedores\ProveedorController;
use App\Http\Controllers\Inventario\InventarioController;
use App\Http\Controllers\Compras\CompraController;
use App\Http\Controllers\Ventas\VentaController;
use App\Http\Controllers\Configuracion\ConfiguracionController;
use App\Http\Controllers\DepartamentosCiudades\CiudadDepartamentoController;
use App\Http\Controllers\Productos\ProductoController;
use App\Http\Controllers\Facturacion\FacturaController;
use App\Http\Controllers\Clientes\ClienteAlmacenController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group( function() {

    Route::get('/login', [AutenticacionController::class, 'vistaIniciarSesion'])->name('login');
    Route::middleware('guest')->post('/iniciar-sesion', [AutenticacionController::class, 'iniciarSesion']);


});


Route::middleware(['auth'])->group(function (){
    /**
     * Login
     */
    Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/cerrar-sesion', [AutenticacionController::class, 'cerrarSesion'])->name('cerrarSesion');

    /**
     * Inventario
     */
    Route::get('/inventario', [InventarioController::class, 'vistaInventario'])->name('inventario');
    Route::post('/inventario/listado-inventario', [InventarioController::class, 'listarProductos']);

    /**
     * Productos
     */
    Route::post('/productos/crear-producto', [ProductoController::class, 'crearProducto']);
    Route::post('/productos/listado-productos', [ProductoController::class, 'listarProductos']);
    Route::get('/productos/select-productos', [ProductoController::class, 'listaProductosSelect']);

    /**
     * Compras
     */
    Route::get('/compras', [CompraController::class, 'vistaCompras'])->name('compras');

    /**
     * Ventas
     */
    Route::get('/ventas', [VentaController::class, 'vistaVentas'])->name('ventas');

    /**
     * Proveedores
     */


    /**
     *Configuracion-Almacen
     */
    Route::get('/configuracion', [ConfiguracionController::class, 'vistaConfiguracion'])->name('configuracion');
    Route::post('/configuracion/registrar/informacion-almacen', [ConfiguracionController::class, 'registrarInformacionAlmacen']);
    Route::get('/configuracion/informacion-almacen', [ConfiguracionController::class, 'informacionAlmacen']);

    /**
     *Configuracion-categoria
     */
    Route::post('/configuracion/registrar-categoria', [ConfiguracionController::class, 'registrarCategoria']);
    Route::post('/configuracion/categorias/listado-categorias', [ConfiguracionController::class, 'listadoCategorias']);
    Route::get('/categorias/select-categorias', [ProductoController::class, 'selectCategorias']);

    /**
     *Configuracion-marcas
     */
    Route::post('/configuracion/registrar-marca', [ConfiguracionController::class, 'registrarMarca']);
    Route::post('/configuracion/marcas/listado-marcas', [ConfiguracionController::class, 'listadoMarcas']);
    Route::get('/categorias/select-marcas', [ProductoController::class, 'selectMarcas']);


    /**
     * Departamentos y ciudades
     */
    Route::get('/lista-departamentos', [CiudadDepartamentoController::class, 'listarDepartamentos']);
    Route::get('/lista-ciudades', [CiudadDepartamentoController::class, 'listarCiudades']);

    /**
     * Ventas
     */
    Route::post('/ventas/registrar-venta', [VentaController::class, 'registrarVenta']);

    /**
     * Clientes
     */
    Route::get('/clientes/select-clientes', [ClienteAlmacenController::class, 'selectClientes']);
});

