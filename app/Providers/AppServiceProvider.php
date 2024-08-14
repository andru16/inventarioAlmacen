<?php

namespace App\Providers;

use App\Interfaces\Configuracion\Almacen\AlmacenServicesIntefaces;
use App\Interfaces\Configuracion\Categoria\CategoriaServicesInterfaces;
use App\Services\Configuracion\Almacen\AlmacenServices;
use App\Services\Configuracion\Categoria\CategoriaServices;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
