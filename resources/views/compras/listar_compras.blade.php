@extends('plantillas.app')

@section('styles')
@endsection

@section('breadcrumbs')
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">Compras
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
        <li class="breadcrumb-item text-gray-700">Compras</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection

@section('contenido')
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-customer-table-filter="search" id="kt_buscador_compras"
                        class="form-control form-control-solid w-250px ps-12" placeholder="Buscar Compra" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <!--begin::Export-->
                    <button type="button" class="btn btn-sm btn-light-primary me-3" data-bs-toggle="modal"
                        data-bs-target="#kt_customers_export_modal">
                        <i class="ki-duotone ki-exit-up fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>Exportar</button>
                    <!--end::Export-->
                    <!--begin::Add customer-->
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_agregar_compra">
                        <i class="ki-outline ki-plus fs-2"></i>Registrar comprar
                    </button>
                    <!--end::Add customer-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete
                        Selected</button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_compras_table">
                    <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Fecha</th>
                        <th class="min-w-125px">Consecutivo</th>
                        <th class="min-w-125px">Proveedor</th>
                        <th class="min-w-125px">Items</th>
                        <th class="min-w-125px">Medio de pago</th>
                        <th class="min-w-125px">Valor compra</th>
                        <th class="min-w-125px">Observaciones</th>
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
@endsection



@section('modales')
    <!-- Modal para Crear Compra -->
    <div class="modal fade" id="kt_modal_agregar_compra" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-950px">
            <div class="modal-content">
                <form id="kt_agregar_compra_form">
                    <div class="modal-header">
                        <h2 class="fw-bold">Agregar Compra</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-offset="300px">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label required">Fecha</label>
                                        <input type="date" class="form-control form-control-solid form-control-sm"
                                               v-model="formularioCompra.fecha" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label required">No. Remisión</label>
                                        <input type="text" class="form-control form-control-solid form-control-sm"
                                               v-model="formularioCompra.no_remision" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label required" for="select_metodo_pago">Medio de Pago</label>
                                        <select class="form-select form-select-solid form-select-sm" id="select_metodo_pago">
                                            <option value="">Selecciona un medio de pago</option>
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Credito">Credito</option>
                                            <option value="Consignacion">Consignacion</option>
                                            <option value="Transferencia">Transferencia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label required" for="select_estado">Estado</label>
                                        <select class="form-select form-select-solid form-select-sm" id="select_estado" >
                                            <option value="">Selecciona un estado</option>
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="Completa">Completa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="fv-row mb-5">
                                <label class="form-label required">Proveedor</label>
                                <select class="form-select form-select-solid form-select-sm" name="select_proveedor"  id="select_proveedor" data-placeholder="Selecciona un proveedor"></select>
                            </div>

                            <div class="fv-row mb-5">
                                <label class="form-label required">Productos</label>
                                <div class="border p-2 rounded-sm my-2" v-for="(item, index) in formularioCompra.items" :key="index">

                                    <div class="d-flex justify-content-between">
                                        <select class="form-select form-select-solid form-select-sm mt-1" :id="'select_producto_' + index" v-model="item.producto_id" data-placeholder="Selecciona un producto"></select>
                                        <input type="number" v-model="item.cantidad" class="form-control form-control-solid form-control-sm m-1" placeholder="Cantidad" @input="actualizarTotalCompra"/>
                                        <input type="number" v-model="item.precio_unitario" class="form-control form-control-solid form-control-sm m-1" placeholder="Precio Unitario" @input="actualizarTotalCompra" />
                                        <button type="button" class="btn btn-sm btn-light-danger m-1" @click="eliminarItem(index)">
                                            <i class="ki-duotone ki-trash fs-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                        </button>

                                    </div>

                                </div>
                                <button type="button" @click="agregarItem" class="btn btn-primary btn-sm mt-4">Añadir Producto</button>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Total</label>
                                <input type="text" class="form-control form-control-solid form-control-sm" v-model="formularioCompra.valor_compra" placeholder="$"/>
                            </div>
                            <div class="fv-row">
                                <label class="form-label">Observaciones</label>
                                <textarea class="form-control form-control-solid form-control-sm" rows="3" v-model="formularioCompra.observaciones"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light btn-sm me-3"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" @click="crearCompra" class="btn btn-primary btn-sm"
                            :disabled="cargandoCompra">
                            <span v-if="!cargandoCompra">Crear compra</span>
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

    <!-- Modal para Editar Compra -->
    <div class="modal fade" id="kt_modal_editar_compra" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-750px">
            <div class="modal-content">
                <form id="kt_editar_compra_form">
                    <div class="modal-header">
                        <h2 class="fw-bold">Editar Compra</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-height="auto">
                            <!-- Form fields similar to Add Modal -->
                            <!-- Similar to the Create Modal, but with v-model bindings adjusted for edit -->
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light btn-sm me-3"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" @click="actualizarCompra" class="btn btn-primary btn-sm"
                            :disabled="cargandoCompra">
                            <span v-if="!cargandoCompra">Actualizar compra</span>
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
@endsection
@section('scripts')
@vite(['resources/js/compras/listar_compras.js'])
@endsection
