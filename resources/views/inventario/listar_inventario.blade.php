@extends('plantillas.app')

@section('styles')
@endsection

@section('breadcrumbs')
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">Almacén
        <!--begin::Description-->
        <span class="page-desc text-muted fs-7 fw-semibold"></span>
        <!--end::Description-->
    </h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
        <!--begin::Item-->
        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
            <a href="index.html" class="text-gray-500 text-hover-primary">
                <i class="ki-duotone ki-home fs-6 text-gray-500 me-n1"></i>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
            <a class="menu-link py-3 px-4 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <span class="menu-title">Inicio</span>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-gray-700">Almacén</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection


@section('contenido')
    <!--begin::Card-->
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin:::Tabs-->
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5 active" data-bs-toggle="tab" href="#kt_inventario">
                        <i class="ki-duotone ki-shop fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                        Inventario
                    </a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#kt_productos">
                        <i class="ki-duotone ki-package fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>Productos</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#kt_proveedores">
                        <i class="ki-duotone ki-delivery-2 fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                            <span class="path9"></span>
                        </i>Proveedores</a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_inventario" role="tabpanel">
                    <div class="card card-flush mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-customer-table-filter="search" id="kt_buscador_inventario" class="form-control form-control-solid w-250px ps-12" placeholder="Buscar ítem" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <!--begin::Export-->
                                    <button type="button" class="btn btn-sm btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                                        <i class="ki-duotone ki-exit-up fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Exportar</button>
                                    <!--end::Export-->
                                    <!--begin::Add customer-->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_registrar_venta">
                                        <i class="ki-outline ki-plus fs-2"></i>Registrar venta
                                    </button>
                                    <!--end::Add customer-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-striped  fs-6 gy-5" id="kt_inventario_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0" >
                                        <th class="min-w-175px text-center">Producto</th>
                                        <th class="min-w-125px">Referencia</th>
                                        <th class="min-w-125px">Referencia proveedor</th>
                                        <th class="min-w-125px">Categoria</th>
                                        <th class="min-w-125px">Marca</th>
                                        <th class="min-w-125px">Cantidad</th>
                                        <th class="min-w-125px">Disponible</th>
                                        <th class="min-w-125px">Costo</th>
                                        <th class="min-w-125px">Precio</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">

                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_productos" role="tabpanel">
                    <div class="card card-flush mb-5 mb-xl-10" id="app_productos">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-customer-table-filter="search" id="kt_buscador_producto" class="form-control form-control-solid w-250px ps-12" placeholder="Buscar producto" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <!--begin::Export-->
                                    <button type="button" class="btn btn-light-primary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                                        <i class="ki-duotone ki-exit-up fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Exportar</button>
                                    <!--end::Export-->
                                    <!--begin::Add customer-->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_agregar_producto">
                                        <i class="ki-outline ki-plus fs-2"></i>Nuevo producto
                                    </button>
                                    <!--end::Add customer-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle fs-6 gy-5" id="kt_productos_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Producto</th>
                                        <th class="min-w-125px">Referencia</th>
                                        <th class="min-w-125px">Categoria</th>
                                        <th class="min-w-125px">Marca</th>
                                        <th class="min-w-125px">Cantidad</th>
                                        <th class="min-w-125px">Costo</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">

                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_proveedores" role="tabpanel">
                    <div class="card card-flush mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header pt-7">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-customer-table-filter="search" id="kt_buscador_proveedor" class="form-control form-control-solid w-250px ps-12" placeholder="Buscar proveedores" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Actions-->
                            <div class="card-toolbar">
                                <!--begin::Filters-->
                                <div class="d-flex flex-stack flex-wrap gap-4">
                                    <button type="button" class="btn btn-sm btn-light-primary " data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
                                        <i class="ki-outline ki-exit-up fs-2"></i>Exportar
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_agregar_proveedor">
                                        <i class="ki-outline ki-plus fs-2"></i> Crear proveedor
                                    </button>
                                </div>
                                <!--begin::Filters-->
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_proveedores_table">
                                    <!--begin::Table head-->
                                    <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Proveedor</th>
                                        <th class="min-w-125px">Correo electronico</th>
                                        <th class="min-w-125px">Telefono</th>
                                        <th class="min-w-125px">Direccion</th>
                                        <th class="min-w-125px">Contacto</th>
                                        <th class="min-w-125px"></th>
                                    </tr>
                                    <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_servicios" role="tabpanel">
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Customers" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <!--begin::Export-->
                                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                                        <i class="ki-duotone ki-exit-up fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Exportar</button>
                                    <!--end::Export-->
                                    <!--begin::Add customer-->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">
                                        <i class="ki-outline ki-plus fs-2"></i>Nueva venta
                                    </button>
                                    <!--end::Add customer-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Codigo</th>
                                        <th class="min-w-125px">Referencia</th>
                                        <th class="min-w-125px">Marca</th>
                                        <th class="min-w-125px">Categoria</th>
                                        <th class="min-w-125px">Producto</th>
                                        <th class="min-w-125px">Cantidad</th>
                                        <th class="min-w-125px">Disponible</th>
                                        <th class="min-w-125px">Costo</th>
                                        <th class="min-w-125px">Precio</th>
                                        <th class="text-end min-w-70px">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">

                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end:::Tab pane-->

            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection

@section('modales')
    <!--begin::Modal - Customers - Add-->
    <div class="modal fade" id="kt_modal_agregar_producto" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="#" id="kt_agregar_producto_form" data-kt-redirect="apps/customers/list.html">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_add_customer_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Agregar producto</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <div class="card card-flush">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-5 mt-5">
                                            <label class="form-label required" for="producto">Nombre producto</label>
                                            <input type="text" class="form-control form-control-solid form-control-sm" name="producto" id="producto" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row">
                                            <div class="col-md-6 fv-row mb-5">
                                                <label class="form-label required" for="select_categoria">Categoria</label>
                                                <select class="form-select form-select-solid form-select-sm" name="select_categoria"  id="select_categoria" data-placeholder="Selecciona una categoria"></select>
                                            </div>
                                            <div class="col-md-6 fv-row mb-5">
                                                <label class="form-label" for="select_marca">Marca</label>
                                                <select class="form-select form-select-solid form-select-sm" name="select_marca"  id="select_marca" data-placeholder="Selecciona una categoria"></select>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-5">
                                            <label class="form-label" for="stock_minimo">Cantidad mínima de stock</label>
                                            <input type="text" class="form-control form-control-solid form-control-sm" name="stock_minimo" id="stock_minimo" />
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light btn-sm me-3" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="button" id="btn_crear_producto" @click="crearProducto" class="btn btn-primary btn-sm">
                            <span class="indicator-label">Crear producto</span>
                            <span class="indicator-progress">Por favor, espere...
							    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - Customers - Add-->
    <!--begin::Modal - Venta - Add-->
    <div class="modal fade" id="kt_modal_registrar_venta" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-950px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="#" id="kt_registrar_venta_form" >
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_add_customer_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Registrar venta</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Card-->
                            <div class="card">
                                <!--begin::Card body-->
                                <div class="card-body p-12">
                                    <!--begin::Form-->
                                    <form action="" id="kt_invoice_form">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column align-items-start flex-xxl-row">
                                            <!--begin::Input group-->
                                            <div class="d-flex align-items-center flex-equal fw-row me-4 order-2">
                                                <!--begin::Date-->
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap">Fecha:</div>
                                                <!--end::Date-->
                                                <!--begin::Input-->
                                                <div class="position-relative d-flex align-items-center w-150px">
                                                    <!--begin::Datepicker-->
                                                    <input type="text" class="form-control form-control-solid form-control-sm" name="fecha_factura" id="fecha_factura" />
                                                    <!--end::Datepicker-->
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4" data-bs-toggle="tooltip" data-bs-trigger="hover" >
                                                <span class="fs-2x fw-bold text-gray-800">Factura </span>
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row">
                                                <!--begin::Date-->
                                                <div class="fs-6 fw-bold text-gray-700 text-nowrap">Fecha de vencimiento:</div>
                                                <!--end::Date-->
                                                <!--begin::Input-->
                                                <div class="position-relative d-flex align-items-center w-150px">
                                                    <!--begin::Datepicker-->
                                                    <input type="text" class="form-control form-control-solid form-control-sm"  name="fecha_vencimiento" id="fecha_vencimiento" />
                                                    <!--end::Datepicker-->
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <!--end::Top-->
                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed my-10"></div>
                                        <!--end::Separator-->
                                        <!--begin::Wrapper-->
                                        <div class="mb-0">
                                            <!--begin::Row-->
                                            <div class=" gx-10 mb-5">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm" style="">
                                                    <input class="form-check-input" type="checkbox" v-model="registrarCliente" id="flexRadioLg"/>
                                                    <label class="form-check-label" for="flexRadioLg">
                                                        Registrar cliente factura
                                                    </label>
                                                </div>
                                                <!--begin::Col-->
                                                <div class="col-lg-12 mt-5" v-if="registrarCliente">
                                                    <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Cliente</label>
                                                    <div class="row">
                                                        <!--begin::Input group-->
                                                        <div class="col-md-6 mb-5">
                                                            <input type="text" class="form-control form-control-solid" placeholder="Nombre"  v-model="formularioFactura.nombre_cliente"/>
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="col-md-6 mb-5">
                                                            <input type="text" class="form-control form-control-solid" placeholder="Teléfono"  v-model="formularioFactura.telefono"/>
                                                        </div>
                                                        <!--end::Input group-->
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mt-5 mb-5">
                                                    <div class="mb-5">
                                                        <label class="form-label" for="select_estado">Estado de factura</label>
                                                        <select class="form-select form-select-solid form-select-sm mb-2" name="select_estado"  id="select_estado">
                                                            <option value="" selected>Selecciona un estado</option>
                                                            <option value="Pendiente" >Pendiente</option>
                                                            <option value="Completa" >Completa</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end::Col-->

                                            </div>
                                            <!--end::Row-->
                                            <!--begin::Table wrapper-->
                                            <div class="table-responsive mb-10">
                                                <!--begin::Table-->
                                                <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                    <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                                        <th class="min-w-300px w-475px">Producto</th>
                                                        <th class="min-w-100px w-100px">Cantidad</th>
                                                        <th class="min-w-150px w-150px">Precio</th>
                                                        <th class="min-w-100px w-150px text-end">Total</th>
                                                        <th class="min-w-75px w-75px text-end">Accion</th>
                                                    </tr>
                                                    </thead>
                                                    <!--end::Table head-->
                                                    <!--begin::Table body-->
                                                    <tbody>
                                                    <tr class="border-bottom border-bottom-dashed" data-kt-element="item"  v-for="(producto, index) in formularioFactura.listaProductos" :key="index">
                                                        <td class="pe-7">
                                                            <input type="text" class="form-control form-control-solid mb-2" v-model="producto.nombre"/>
                                                        </td>
                                                        <td class="ps-0">
                                                            <input class="form-control form-control-sm form-control-solid"   v-model="producto.cantidad" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm form-control-solid text-end"  v-model="producto.precio_format" />
                                                        </td>
                                                        <td class="pt-8 text-end text-nowrap">$
                                                            <span data-kt-element="total" v-text="Intl.NumberFormat('es-ES', {}).format( producto.total )"></span></td>
                                                        <td class="pt-5 text-end">
                                                            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                                                <i class="ki-duotone ki-trash fs-3">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                    <span class="path5"></span>
                                                                </i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-bottom border-bottom-dashed" data-kt-element="item" >
                                                        <td class="pe-7">
                                                            <select class="form-select form-select-solid form-select-sm mb-2" name="select_producto"  id="select_producto" data-placeholder="Selecciona un producto"></select>
                                                        </td>
                                                        <td class="ps-0">
                                                            <input class="form-control form-control-sm form-control-solid" type="number" min="1" name="" placeholder="1" v-model="formularioFactura.cantidadAdd" :disabled="!formularioFactura.productoSeleccionado" data-kt-element="quantity" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm form-control-solid text-end " disabled v-if="formularioFactura.productoSeleccionado" v-model="formularioFactura.productoSeleccionado.precio_format"/>
                                                            <input type="text" class="form-control form-control-sm form-control-solid text-end " disabled v-else/>
                                                        </td>
                                                        <td class="pt-8 text-end text-nowrap">$
                                                            <span id="total_precio_producto" v-text="totalPrecioProducto"></span></td>
                                                        <td class="pt-5 text-end">

                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                    <!--end::Table body-->
                                                    <!--begin::Table foot-->
                                                    <tfoot>
                                                    <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                        <th class="text-primary">
                                                            <button class="btn btn-primary btn-sm py-1"  type="button" @click="agregarProducto">Añadir producto</button>
                                                        </th>
                                                        <th colspan="2" class="border-bottom border-bottom-dashed ps-0">
                                                            <div class="d-flex flex-column align-items-start">
                                                                <div class="fs-5">Subtotal</div>
                                                                <div class="fs-5 mb-3">Descuento</div>
                                                                <div class="fs-5">Servicio</div>
                                                            </div>
                                                        </th>

                                                        <th colspan="2" class="border-bottom border-bottom-dashed text-end">
                                                            $
                                                            <span data-kt-element="sub-total" v-text="Intl.NumberFormat('es-ES', {}).format( subtotal )"></span>
                                                            <input type="text" class="form-control form-control-sm form-control-solid text-end mb-3" id="input_descuento" v-model="formularioFactura.descuento" />
                                                            <input type="text" class="form-control form-control-sm form-control-solid text-end" id="input_servicio" v-model="formularioFactura.servicio" />
                                                        </th>
                                                    </tr>
                                                    <tr class="align-top fw-bold text-gray-700">
                                                        <th></th>
                                                        <th colspan="2" class="fs-4 ps-0">Total</th>
                                                        <th colspan="2" class="text-end fs-4 text-nowrap">$
                                                            <span data-kt-element="grand-total" v-text="Intl.NumberFormat('es-ES', {}).format( total )"></span>
                                                        </th>
                                                    </tr>
                                                    </tfoot>
                                                    <!--end::Table foot-->
                                                </table>
                                            </div>
                                            <!--end::Table-->

                                        </div>
                                        <!--end::Wrapper-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->

                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light btn-sm me-3" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="button" id="btn_crear_factura" @click="registrarFactura" class="btn btn-primary btn-sm">
                            <span class="indicator-label">Crear factura</span>
                            <span class="indicator-progress">Por favor, espere...
							    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - Venta - Add-->
    <!--begin::Modal - Proveedores - Add-->
    <div class="modal fade" id="kt_modal_agregar_proveedor" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form id="kt_agregar_proveedor_form">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <h2 class="fw-bold">Agregar Proveedor</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-height="auto">
                            <!--begin::Form fields-->
                            <div class="fv-row mb-5">
                                <label class="form-label required">Nombre del Proveedor</label>
                                <input type="text" class="form-control form-control-solid form-control-sm" name="nombre_proveedor" v-model="formularioProveedor.nombre" />
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-solid form-control-sm" name="correo_proveedor" v-model="formularioProveedor.email" />
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control form-control-solid form-control-sm" name="telefono_proveedor" v-model="formularioProveedor.telefono" />
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Dirección</label>
                                <input class="form-control form-control-solid form-control-sm" name="direccion_proveedor" v-model="formularioProveedor.direccion">
                            </div>
                            <div class="fv-row">
                                <label class="form-label">Nombre Contacto</label>
                                <input class="form-control form-control-solid form-control-sm" name="nombre_contacto" v-model="formularioProveedor.nombre_contacto">
                            </div>
                            <!--end::Form fields-->
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->

                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" @click="crearProveedor" class="btn btn-primary btn-sm" :disabled="cargandoProveedor">
                            <span v-if="!cargandoProveedor">Crear proveedor</span>
                            <span v-else>
                                Por favor, espere...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - Proveedores - Add-->

    <!--begin::Modal - Proveedores - Edit-->
    <div class="modal fade" id="kt_modal_editar_proveedor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content">
                <form id="kt_editar_proveedor_form">
                    <div class="modal-header">
                        <h2 class="fw-bold">Editar Proveedor</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div class="modal-body py-6 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-height="auto">
                            <div class="fv-row mb-5">
                                <label class="form-label required">Nombre del Proveedor</label>
                                <input type="text" class="form-control form-control-solid form-control-sm" v-model="formularioProveedor.nombre" />
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-solid form-control-sm" v-model="formularioProveedor.email" />
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control form-control-solid form-control-sm" v-model="formularioProveedor.telefono" />
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Dirección</label>
                                <input class="form-control form-control-solid form-control-sm" v-model="formularioProveedor.direccion">
                            </div>
                            <div class="fv-row">
                                <label class="form-label">Nombre Contacto</label>
                                <input class="form-control form-control-solid form-control-sm" v-model="formularioProveedor.nombre_contacto">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" @click="actualizarProveedor" class="btn btn-primary btn-sm" :disabled="cargandoProveedor">
                            <span v-if="!cargandoProveedor">Guardar cambios</span>
                            <span v-else>
                                Por favor, espere...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Modal - Proveedores - Edit-->

@endsection

@section('scripts')
    @vite(['resources/js/inventario/listar_inventario.js'])
@endsection
