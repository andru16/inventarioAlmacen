@extends('plantillas.app')

@section('styles')
@endsection

@section('breadcrumbs')
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">Configuración
        <!--begin::Description-->
        <span class="page-desc text-muted fs-7 fw-semibold"></span>
        <!--end::Description--></h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7">
        <!--begin::Item-->
        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
            <a href="{{route('home')}}" class="text-gray-500 text-hover-primary">
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
        <li class="breadcrumb-item text-gray-700">Configuración</li>
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
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5 active" data-bs-toggle="tab" href="#kt_almacen">
                        <i class="ki-duotone ki-home fs-2 me-2"></i>Almacén</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#kt_categoria">
                        <i class="ki-duotone ki-shop fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>Categorias</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#kt_marca">
                        <i class="ki-duotone ki-compass fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>Marcas</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link text-active-primary d-flex align-items-center pb-5" data-bs-toggle="tab" href="#kt_productos">--}}
{{--                        <i class="ki-duotone ki-package fs-2 me-2">--}}
{{--                            <span class="path1"></span>--}}
{{--                            <span class="path2"></span>--}}
{{--                            <span class="path3"></span>--}}
{{--                        </i>Productos</a>--}}
{{--                </li>--}}
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_almacen" role="tabpanel">
                    <!--begin::Layout-->
                    <div class="d-flex flex-column flex-xl-row" id="app_almacen">
                        <!--begin::Sidebar-->
                        <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                            <!--begin::Card-->
                            <div class="card mb-5 mb-xl-8">
                                <!--begin::Card body-->
                                <div class="card-body pt-15">
                                    <!--begin::Summary-->
                                    <div class="d-flex flex-center flex-column mb-5">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-100px symbol-circle mb-7">
                                            <img src="{{ asset('assets/media/logos/almacen_sin_logo.png') }}" alt="image" />
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Name-->
                                        <span href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1" v-if="almacen" v-text="almacen.nombre"></span>
                                        <!--end::Name-->

                                    </div>
                                    <!--end::Summary-->
                                    <!--begin::Details toggle-->
                                    <div class="d-flex flex-stack fs-4 py-3">
                                        <div class="fw-bold rotate collapsible"  :class="{ 'collapsed': !almacen }" data-bs-toggle="collapse" href="#kt_customer_view_details" role="button" :aria-expanded="almacen ? 'true' : 'false'"  aria-controls="kt_customer_view_details">Detalle
                                            <span class="ms-2 rotate-180">
                                                <i class="ki-duotone ki-down fs-3"></i>
                                            </span>
                                        </div>
                                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Editar información almacén">
                                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_customer">Editar</a>
                                        </span>
                                    </div>
                                    <!--end::Details toggle-->
                                    <div class="separator separator-dashed my-3"></div>
                                    <!--begin::Details content-->
                                    <div id="kt_customer_view_details" class="collapse" :class="{ 'show': almacen && almacen.nombre }">
                                        <div class="py-5 fs-6">
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Dirección</div>
                                            <div class="text-gray-600"><span v-if="almacen" v-text="almacen.direccion"></span>,
                                                <br /><span v-if="almacen && almacen.ciudad && almacen.ciudad.departamento" v-text="almacen.ciudad.nombre+', ' +almacen.ciudad.departamento.nombre"></span>
                                                <br />Colombia</div>
                                            <!--begin::Details item-->
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Correo electrónico</div>
                                            <div class="text-gray-600">
                                                <a href="#" class="text-gray-600 text-hover-primary" v-if="almacen" v-text="almacen.correo"></a>
                                            </div>
                                            <!--begin::Details item-->
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Telefono</div>
                                            <div class="text-gray-600"><span v-if="almacen && almacen.telefono" v-text="'+57 '+almacen.telefono"></span></div>
                                            <!--begin::Details item-->
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5" v-if="almacen && almacen.whatsapp">WhatsApp</div>
                                            <div class="text-gray-600"><span v-if="almacen && almacen.whatsapp" v-text="'+57 '+almacen.whatsapp"></span></div>
                                            <!--begin::Details item-->

                                        </div>
                                    </div>
                                    <!--end::Details content-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->

                        </div>
                        <!--end::Sidebar-->
                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid ms-lg-15">
                            <div class="card border border-primary-subtle">
                                <div class="card-header" style="background: #002175;">
                                    <div class="card-title">
                                        <h4 class="text-white float-lef m-0">Información de almacén</h4>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <!--begin::Form-->
                                    <form id="kt_informacion_almacen" class="form" action="#">
                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">
                                            <label class="form-label required" for="nombre_almacen">Nombre almacén</label>
                                            <input type="text" class="form-control form-control-solid form-control-sm" name="nombre_almacen" id="nombre_almacen" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">
                                            <div class="col-md-6">
                                                <label class="form-label required" for="direccion">Dirección</label>
                                                <input type="text" class="form-control form-control-solid form-control-sm" name="direccion" id="direccion"/>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label required" for="correo_electronico">Correo electrónico</label>
                                                <input type="text" class="form-control form-control-solid form-control-sm" name="correo_electronico" id="correo_electronico" />
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">
                                            <div class="col-md-6">
                                                <label class="form-label required" for="telefono">Teléfono</label>
                                                <input type="text" class="form-control form-control-solid form-control-sm" name="telefono" id="telefono"/>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label required" for="whatsapp">WhatsApp</label>
                                                <input type="text" class="form-control form-control-solid form-control-sm" name="whatsapp" id="whatsapp"/>
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">
                                            <div class="col-md-6">
                                                <label class="form-label required" for="select_departamento">Departamento</label>
                                                <select class="form-select form-select-solid form-select-sm" name="select_departamento" id="select_departamento"  data-placeholder="Selecciona un departamento"></select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label required" for="select_ciudad">Ciudad</label>
                                                <select class="form-select form-select-solid form-select-sm" name="select_ciudad"  id="select_ciudad" :disabled="!id_departamento" data-placeholder="Selecciona una ciudad"></select>
                                            </div>
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Action buttons-->
                                        <div class="row py-5">
                                            <div class="col-md-9 offset-md-3">
                                                <div class="d-flex">
                                                    <!--begin::Button-->
                                                    <button type="button" @click="registrarInformacion" id="btn_registrar_info_almacen" class="btn btn-primary">
                                                        <span class="indicator-label">Guardar</span>
                                                        <span class="indicator-progress">Por favor, espere...
														    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                    <!--end::Button-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Action buttons-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                            </div>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Layout-->
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_categoria" role="tabpanel">
                    <!--begin::Form-->

                    <div class="row" id="app_categoria">
                        <div class="col-md-4">
                            <div class="card border border-primary-subtle">
                                <div class="card-header" style="background: #002175;">
                                    <div class="card-title">
                                        <h4 class="text-white float-left m-0">Nueva categoria</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Form-->
                                    <form id="kt_form_categoria" class="form" action="#">
                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">
                                            <label class="form-label required" for="nombre_categoria">Nombre categoria</label>
                                            <input type="text" class="form-control form-control-solid form-control-sm" name="nombre_categoria" id="nombre_categoria" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Action buttons-->
                                        <div class="row py-5">
                                            <div class="col-md-9 offset-md-3">
                                                <div class="d-flex">
                                                    <!--begin::Button-->
                                                    <button type="button" id="btn_crear_categoria" @click="registrarCategoria" class="btn btn-primary">
                                                        <span class="indicator-label">Guardar</span>
                                                        <span class="indicator-progress">Por favor, espere...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                    <!--end::Button-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Action buttons-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card border border-primary-subtle">
                                <div class="card-header" style="background: #002175;">
                                    <div class="card-title">
                                        <h4 class="text-white float-left m-0">Listado de categorias</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_categorias_tabla">
                                            <thead>
                                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No.</th>
                                                <th class="min-w-125px">Categoria</th>

                                            </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">

                                            </tbody>
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Form-->
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_marca" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border border-primary-subtle">
                                <div class="card-header" style="background: #002175;">
                                    <div class="card-title">
                                        <h4 class="text-white float-left m-0">Nueva Marca</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin::Form-->
                                    <form id="kt_categoria" class="form" action="#">
                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">
                                            <label class="form-label required" for="nombre_marca">Marca</label>
                                            <input type="text" class="form-control form-control-solid form-control-sm" name="nombre_marca" id="nombre_marca" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Action buttons-->
                                        <div class="row py-5">
                                            <div class="col-md-9 offset-md-3">
                                                <div class="d-flex">
                                                    <!--begin::Button-->
                                                    <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-primary">
                                                        <span class="indicator-label">Guardar</span>
                                                        <span class="indicator-progress">Por favor, espere...
																		<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                    <!--end::Button-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Action buttons-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card border-dark">
                                <div class="card-header" style="background: #002175;">
                                    <div class="card-title">
                                        <h4 class="text-white float-left m-0">Listado de marcas</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                            <thead>
                                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">No.</th>
                                                <th class="min-w-125px">Categoria</th>

                                            </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">

                                            </tbody>
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_productos" role="tabpanel">
                    <!--begin::Form-->
                    <form id="kt_ecommerce_settings_general_products" class="form" action="#">
                        <!--begin::Heading-->
                        <div class="row mb-7">
                            <div class="col-md-9 offset-md-3">
                                <h2>Cateogries Settings</h2>
                            </div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-7">
                            <div class="col-md-3 text-md-end">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Category Product Count</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Show the number of products inside the subcategories in the storefront header category menu. Be warned, this will cause an extreme performance hit for stores with a lot of subcategories!">
																		<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																	</span>
                                </label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex mt-3">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="radio" value="" name="category_product_count" id="category_product_count_yes" checked="checked" />
                                        <label class="form-check-label" for="category_product_count_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" value="" name="category_product_count" id="category_product_count_no" />
                                        <label class="form-check-label" for="category_product_count_no">No</label>
                                    </div>
                                    <!--end::Radio-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-16">
                            <div class="col-md-3 text-md-end">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Default Items Per Page</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Determines how many items are shown per page.">
																		<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																	</span>
                                </label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-9">
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="products_items_per_page" value="10" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Heading-->
                        <div class="row mb-7">
                            <div class="col-md-9 offset-md-3">
                                <h2>Reviews Settings</h2>
                            </div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-7">
                            <div class="col-md-3 text-md-end">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Allow Reviews</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Enable/disable review entries for registered customers.">
																		<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																	</span>
                                </label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex mt-3">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="radio" value="" name="allow_reviews" id="allow_reviews_yes" checked="checked" />
                                        <label class="form-check-label" for="allow_reviews_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" value="" name="allow_reviews" id="allow_reviews_no" />
                                        <label class="form-check-label" for="allow_reviews_no">No</label>
                                    </div>
                                    <!--end::Radio-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-16">
                            <div class="col-md-3 text-md-end">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Allow Guest Reviews</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Enable/disable review entries for public guest customers">
																		<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																	</span>
                                </label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex mt-3">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="radio" value="" name="allow_guest_reviews" id="allow_guest_reviews_yes" />
                                        <label class="form-check-label" for="allow_guest_reviews_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" value="" name="allow_guest_reviews" id="allow_guest_reviews_no" checked="checked" />
                                        <label class="form-check-label" for="allow_guest_reviews_no">No</label>
                                    </div>
                                    <!--end::Radio-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Heading-->
                        <div class="row mb-7">
                            <div class="col-md-9 offset-md-3">
                                <h2>Vouchers Settings</h2>
                            </div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-7">
                            <div class="col-md-3 text-md-end">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Minimum Vouchers</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Minimum number of vouchers customers can attach to an order">
																		<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																	</span>
                                </label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-9">
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="products_min_voucher" value="1" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-16">
                            <div class="col-md-3 text-md-end">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Maximum Vouchers</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Maximum number of vouchers customers can attach to an order">
																		<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																	</span>
                                </label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-9">
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="products_max_voucher" value="10" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Heading-->
                        <div class="row mb-7">
                            <div class="col-md-9 offset-md-3">
                                <h2>Tax Settings</h2>
                            </div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-7">
                            <div class="col-md-3 text-md-end">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span>Display Prices with Tax</span>
                                </label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-9">
                                <div class="d-flex mt-3">
                                    <!--begin::Radio-->
                                    <div class="form-check form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="radio" value="" name="product_tax" id="product_tax_yes" checked="checked" />
                                        <label class="form-check-label" for="product_tax_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" value="" name="product_tax" id="product_tax_no" />
                                        <label class="form-check-label" for="product_tax_no">No</label>
                                    </div>
                                    <!--end::Radio-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-7">
                            <div class="col-md-3 text-md-end">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Default Tax Rate</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Determines the tax percentage (%) applied to orders">
																		<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																	</span>
                                </label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-9">
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" name="products_tax_rate" value="15%" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Action buttons-->
                        <div class="row py-5">
                            <div class="col-md-9 offset-md-3">
                                <div class="d-flex">
                                    <!--begin::Button-->
                                    <button type="reset" data-kt-ecommerce-settings-type="cancel" class="btn btn-light me-3">Cancel</button>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Save</span>
                                        <span class="indicator-progress">Please wait...
																		<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--end::Button-->
                                </div>
                            </div>
                        </div>
                        <!--end::Action buttons-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection

@section('scripts')
    @vite([
        'resources/js/configuracion/almacen/almacen.js',
        'resources/js/configuracion/categorias/categoria.js',
        ])
@endsection
