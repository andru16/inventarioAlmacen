<?php

namespace App\Providers;

use App\Interfaces\Configuracion\Almacen\AlmacenServicesIntefaces;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use App\Interfaces\Configuracion\Marca\MarcaServicesInterfaces;
use App\Interfaces\Producto\ProductuoServicesInterfaces;
use App\Services\Configuracion\Almacen\AlmacenServices;
use App\Services\Configuracion\Categoria\CategoriaServices;
use App\Services\Configuracion\Marca\MarcaServices;
use App\Services\Producto\ProductoServices;
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

        //Categoria
        $this->app->bind(CategoriaServicesInterfaces::class, CategoriaServices::class);

        //MarcaRequest
        $this->app->bind(MarcaServicesInterfaces::class, MarcaServices::class);

        //Producto
        $this->app->bind(ProductuoServicesInterfaces::class, ProductoServices::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
