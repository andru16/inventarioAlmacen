import {createApp} from "vue/dist/vue.esm-bundler";
import spanish from '../data_tables/spanish.json';
import {activarLoadBtn, desactivarLoadBtn} from "@/ayudas/Load";

import swal from "sweetalert";

const appAlmacen = createApp({
    data() {
        return {
            locale: {
                format: "YYYY-MM-DD",
                "separator": " hasta ",
                "applyLabel": "Aplicar filtro",
                "cancelLabel": "Limpiar filtro",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Personalizar",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            /**
             * Seccion-Compras
             */
            tablaListaCompras: null, // Para almacenar la instancia de DataTable
            formularioCompra: {
                fecha: '',
                medio_pago: '',
                observaciones: '',
                valor_compra:0,
                no_remision: '',
                proveedor_id: null,
                estado: 'Pendiente',
                items: [
                    {
                        producto_id: null,
                        cantidad: 1,
                        precio_unitario: 0
                    }
                ]
            },
            productos: [],
            proveedores: [],
            cargandoCompra: false,
            modoEdicion: false,
            compraId: null,
        }
    },

    mounted() {
        /**
         * Seccion-Compras
         * En esta section estara todo lo relacionado con el tab compras
         */
        this.listadoCompras();
        this.selectProveedores('#select_proveedor');
        this.selectProductos('#select_producto');

        $('#select_estado').select2({
            dropdownParent: $('#kt_modal_agregar_compra'),
        });
        $('#select_estado').on('select2:select', (e) => {
            this.formularioCompra.medio_pago = e.params.data.text;
        })

        $('#select_metodo_pago').select2({
            dropdownParent: $('#kt_modal_agregar_compra'),
        });
        $('#select_metodo_pago').on('select2:select', (e) => {
            this.formularioCompra.estado = e.params.data.text;
        })

        // Inicializar datepicker para la fecha
        $('#fecha_compra').daterangepicker({
            singleDatePicker: true,
            minYear: 2000,
            maxYear: parseInt(moment().format("YYYY"), 12),
            locale: this.locale,
            autoApply: true,
            startDate: moment().startOf('day').format('YYYY-MM-DD'),
            dateFormat: 'YYYY-MM-DD'
        });

        $('#fecha_compra').on('apply.daterangepicker', (ev, picker) => {
            this.formularioCompra.fecha = picker.startDate.format('YYYY-MM-DD');
        });
    },

    methods: {
        /**
         * Seccion-Compras
         */
        listadoCompras() {
            this.tablaListaCompras = $('#kt_compras_table').DataTable({
                "language": spanish,
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ordering": false,
                "ajax": {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "/compras/listado-compras",
                    data: function (d) {
                        return $.extend({}, d, {
                            "buscar": $('#kt_buscador_compras').val().toLowerCase(),
                        });
                    }
                },


                "columns": [
                    { data: "fecha", name: "fecha" },
                    { data: "consecutivo", name: "consecutivo" },
                    { data: "proveedor", name: "proveedor" },
                    { data: "items", name: "items" },
                    { data: "medio_pago", name: "medio_pago" },
                    { data: "valor_compra", name: "valor_compra" },
                    { data: "observaciones", name: "observaciones" },
                    {
                        data: null,
                        name: 'acciones',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex justify-content-start align-items-center">
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                        Acciones
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- Editar -->
                                        <a href="#" class="dropdown-item btn-edit-compra" data-id="${row.id}">Editar</a>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ]
            });

            $('#kt_buscador_compras').on('keyup', () => {
                this.tablaListaCompras.draw();
            });

            $('#kt_compras_table').on('click', '.btn-edit-compra', (event) => {
                const compraId = $(event.currentTarget).data('id');
                this.editarCompra(compraId);
            });
        },

        agregarItem() {
            this.formularioCompra.items.push({ producto_id: null, cantidad: 1, precio_unitario: 0 });
            this.selectProductos();
        },

        eliminarItem(index) {
            this.formularioCompra.items.splice(index, 1);
        },

        crearCompra() {
            if (!this.validarFormulario()) return;

            this.cargandoCompra = true;

            axios.post('/compras/crear-compra', this.formularioCompra, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                swal({
                    title: '¡Éxito!',
                    text: 'La compra ha sido agregada correctamente.',
                    icon: 'success',
                    buttons: 'Cerrar'
                }).then(() => {
                    this.tablaListaCompras.draw();
                    this.resetearFormulario();
                    $('#kt_modal_agregar_compra').modal('hide');
                });
            })
            .catch(error => {
                swal({
                    title: 'Error',
                    text: 'Hubo un problema al agregar la compra. Por favor, intenta nuevamente.',
                    icon: 'error',
                    buttons: 'Cerrar'
                });
            })
            .finally(() => {
                this.cargandoCompra = false;
            });
        },

        editarCompra(compraId) {
            axios.get(`/compras/${compraId}`)
                .then(response => {
                    this.formularioCompra = response.data;
                    $('#kt_modal_editar_compra').modal('show');
                })
                .catch(error => {
                    swal({
                        title: 'Error',
                        text: 'Hubo un problema al cargar los datos de la compra. Por favor, intenta nuevamente.',
                        icon: 'error',
                        buttons: 'Cerrar'
                    });
                });
        },

        actualizarCompra() {
            if (!this.validarFormulario()) return;

            this.cargandoCompra = true;

            axios.put(`/compras/${this.formularioCompra.id}`, this.formularioCompra)
                .then(response => {
                    swal({
                        title: '¡Éxito!',
                        text: 'La compra ha sido actualizada correctamente.',
                        icon: 'success',
                        buttons: 'Cerrar'
                    }).then(() => {
                        this.tablaListaCompras.draw();
                        $('#kt_modal_editar_compra').modal('hide');
                    });
                })
                .catch(error => {
                    swal({
                        title: 'Error',
                        text: 'Hubo un problema al actualizar la compra. Por favor, intenta nuevamente.',
                        icon: 'error',
                        buttons: 'Cerrar'
                    });
                })
                .finally(() => {
                    this.cargandoCompra = false;
                });
        },

        validarFormulario() {
            if (!this.formularioCompra.fecha || !this.formularioCompra.medio_pago  || !this.formularioCompra.no_remision || !this.formularioCompra.proveedor_id) {
                swal({
                    title: 'Campo requerido',
                    text: 'Por favor completa todos los campos obligatorios.',
                    icon: 'warning',
                    button: 'Cerrar'
                });
                return false;
            }
            return true;
        },

        resetearFormulario() {
            this.formularioCompra = {
                fecha: '',
                medio_pago: '',
                observaciones: '',
                no_remision: '',
                proveedor_id: null,
                estado: 'Pendiente',
                items: [
                    {
                        producto_id: null,
                        cantidad: 1,
                        precio_unitario: 0
                    }
                ]
            };
        },


        selectProveedores(idSelector) {
            $(idSelector).select2({
                ajax: {
                    url: '/proveedores/select-proveedores',
                    dataType: 'json',
                    type: 'get',
                    delay: 300,
                    language: 'es',
                    data: params => {
                        return {
                            busqueda: params.term,
                            page: params.page
                        };
                    },
                    processResults: data => {
                        let results = data.map(item => ({
                            id: item.id,
                            text: item.nombre
                        }));
                        return { results };
                    },
                    cache: true
                }
            });

            $(idSelector).on('select2:select', (e) => {
                const selectedProveedor = e.params.data.id;
                this.formularioCompra.proveedor_id = selectedProveedor;
            });
        },

        selectProductos() {
            this.$nextTick(() => {
                this.formularioCompra.items.forEach((item, index) => {
                    const selector = `#select_producto_${index}`;
                    $(selector).select2({
                        ajax: {
                            url: '/productos/select-productos',
                            dataType: 'json',
                            type: 'get',
                            delay: 300,
                            language: 'es',
                            data: params => {
                                return {
                                    busqueda: params.term,
                                    page: params.page
                                };
                            },
                            processResults: data => {
                                let results = data.map(producto => ({
                                    id: producto.id,
                                    text: producto.nombre
                                }));
                                return { results };
                            },
                            cache: true
                        }
                    });

                    // Asignar el valor seleccionado al producto_id del item correspondiente
                    $(selector).on('select2:select', (e) => {
                        const selectedProducto = e.params.data.id;
                        this.formularioCompra.items[index].producto_id = selectedProducto;

                        //hacer sumatoria para el total
                        this.actualizarTotalCompra();
                    });
                });
            });
        },
        actualizarTotalCompra() {
            let total = 0;

            this.formularioCompra.items.forEach(item => {
                const subtotal = item.cantidad * item.precio_unitario;
                total += subtotal;
            });

            this.formularioCompra.valor_compra = total;

            console.log('----------------');
            console.log('total compra',this.formularioCompra.valor_compra);
            console.log('----------------');
        }

    }
});

appAlmacen.mount('#app_general')
