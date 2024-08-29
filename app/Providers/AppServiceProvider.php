<?php

namespace App\Providers;

use App\Interfaces\Almacen\ColaboradoresAlmacenServicesInterfaces;
use App\Interfaces\Clientes\ClientesServicesInterfaces;
use App\Interfaces\Configuracion\Almacen\AlmacenServicesIntefaces;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use App\Interfaces\Configuracion\Marca\MarcaServicesInterfaces;
use App\Interfaces\Facturas\FacturasServicesInterfaces;
use App\Interfaces\Inventario\InventarioServicesInterfaces;
use App\Interfaces\Pagos\PagosFacturaServicesInterfaces;
use App\Interfaces\Servicios\ServiciosServicesInterfaces;
use App\Interfaces\Ventas\VentasServicesInterfaces;
use App\Interfaces\Producto\ProductuoServicesInterfaces;
use App\Services\Almacen\ColaboradoresAlmacenServices;
use App\Services\Clientes\ClientesServices;
use App\Services\Configuracion\Almacen\AlmacenServices;
use App\Services\Configuracion\Categoria\CategoriaServices;
use App\Services\Configuracion\Consecutivo\ConsecutivoServices;
use App\Services\Configuracion\Marca\MarcaServices;
use App\Services\Facturas\FacturasServices;
use App\Services\Inventario\InventarioServices;
use App\Services\Pagos\PagosFacturasServices;
use App\Services\Producto\ProductoServices;
use App\Services\Servicios\ServiciosServices;
use App\Services\Ventas\VentasServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Almacen
        $this->app->bind(AlmacenServicesIntefaces::class, AlmacenServices::class);
        $this->app->bind(ColaboradoresAlmacenServicesInterfaces::class, ColaboradoresAlmacenServices::class);

        //Categoria
        $this->app->bind(CategoriaServicesInterfaces::class, CategoriaServices::class);

        //MarcaRequest
        $this->app->bind(MarcaServicesInterfaces::class, MarcaServices::class);

        //Producto
        $this->app->bind(ProductuoServicesInterfaces::class, ProductoServices::class);

        //Consecutivo
        $this->app->bind(ConsecutivoServicesInterfaces::class, ConsecutivoServices::class);

        //Facturaciones
        $this->app->bind(FacturasServicesInterfaces::class, FacturasServices::class);

        //Inventario
        $this->app->bind(VentasServicesInterfaces::class, VentasServices::class);
        $this->app->bind(InventarioServicesInterfaces::class, InventarioServices::class);

        //Clientes
        $this->app->bind(ClientesServicesInterfaces::class, ClientesServices::class);

        //Ventas
        $this->app->bind(VentasServicesInterfaces::class, VentasServices::class);

        //Servicios
        $this->app->bind(ServiciosServicesInterfaces::class, ServiciosServices::class);

        //Pagos
        $this->app->bind(PagosFacturaServicesInterfaces::class, PagosFacturasServices::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
