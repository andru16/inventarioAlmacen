<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Http\Decimales\Decimales;
use App\Http\Requests\Ventas\VentaRequest;
use App\Interfaces\Configuracion\Consecutivo\ConsecutivoServicesInterfaces;
use App\Interfaces\Facturas\FacturasServicesInterfaces;
use App\Interfaces\Ventas\VentasServicesInterfaces;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{

}
