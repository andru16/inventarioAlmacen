<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\Proveedores\ProveedorController;
use App\Http\Controllers\Inventario\InventarioController;
use App\Http\Controllers\Compras\CompraController;
use App\Http\Controllers\Ventas\VentaController;
use App\Http\Controllers\Configuracion\ConfiguracionController;
use App\Http\Controllers\DepartamentosCiudades\CiudadDepartamentoController;
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

    /**
     *Configuracion-marcas
     */


    /**
     * Departamentos y ciudades
     */
    Route::get('/lista-departamentos', [CiudadDepartamentoController::class, 'listarDepartamentos']);
    Route::get('/lista-ciudades', [CiudadDepartamentoController::class, 'listarCiudades']);
});

