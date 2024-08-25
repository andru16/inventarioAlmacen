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
             * Section-Inventario
             */
            tablaListaInventario: {
                draw: () => {}
            },
            registrarCliente:false,
            formularioFactura:{
                productoSeleccionado: null,
                cantidadAdd: 1,
                listaProductos:[],
                totalPrecioProducto:0,
                descuento:'',
                servicio:'',
                fecha_factura: '',
                fecha_vencimiento:'',
                estado: '',
                nombre_cliente: '',
                telefono: '',
                totalFactura: 0
            },



            /**
             * Section-Productos
             */
            tablaListaProductos: {
                draw: () => {}
            },
            formularioCrearProducto:{},
        }
    },

    mounted() {
        /**
         * Section-Inventario
         * En esta section estara todo lo relacionado con el tab inventario
         */
        //Inicializamos
        this.listadoInventario()
        this.selectProductos('#select_producto');

        // Convertimos el campo de cantidad en formato decial estándar
        let inputDescuento = document.querySelector('#input_descuento');
        new AutoNumeric(inputDescuento, {
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            emptyInputBehavior: 0,
            modifyValueOnWheel: false,
            decimalPlaces: 2
        });

        // Convertimos el campo de cantidad en formato decial estándar
        let inputServicio = document.querySelector('#input_servicio');
        new AutoNumeric(inputServicio, {
            decimalCharacter : ',',
            digitGroupSeparator : '.',
            emptyInputBehavior: 0,
            modifyValueOnWheel: false,
            decimalPlaces: 2
        });

        $('#fecha_factura').daterangepicker({
            singleDatePicker: true,
            // showDropdowns: true,
            minYear: 2000,
            maxYear: parseInt(moment().format("YYYY"), 12),
            locale: this.locale,
            autoApply: true,
            startDate: moment().startOf('day').format('YYYY-MM-DD'),
            dateFormat: 'YYYY-MM-DD'
        });

        $('#fecha_vencimiento').daterangepicker({
            singleDatePicker: true,
            // showDropdowns: true,
            minYear: 2000,
            maxYear: parseInt(moment().format("YYYY"), 12),
            locale: this.locale,
            autoApply: true,
            startDate: moment().startOf('day').format('YYYY-MM-DD'),
            dateFormat: 'YYYY-MM-DD'
        });

        $('#select_estado').select2({
            dropdownParent: $('#kt_modal_registrar_venta'),
        });
        $('#select_estado').on('select2:select', (e) => {

            this.formularioFactura.estado = e.params.data.text;
            // $('#total_precio_producto').html(e.params.data.precio_format);
        })


        /**
         * Section-Productos
         * En esta section estara todo lo relacionado con el tab productos
         */

        //Obtenemos el listado de productos
        this.listadoProductos();

        //Inicializamos los selects
        this.selectMarcas('#select_marca');
        this.selectCategorias('#select_categoria');

        //Inicializamos la validación del formulario
        this.inicializarFormulariosDeValidacionProducto();

    },

    computed:{
        totalPrecioProducto() {
            let total = 0.00;

            if (this.formularioFactura.productoSeleccionado) {
                total = this.formularioFactura.cantidadAdd * this.formularioFactura.productoSeleccionado.precio;
                this.formularioFactura.totalPrecioProducto = total;
            }

            return Intl.NumberFormat('es-ES', {}).format( total );
        },
        subtotal() {
            // Sumar todos los precios de los productos en la lista
            return this.formularioFactura.listaProductos.reduce((acumulado, producto) => {
                return acumulado + (producto.precio * producto.cantidad);
            }, 0);
        },
        total() {
            // Convertir descuento a número
            let descuento = this.formularioFactura.descuento
                .replace('.', '')
                .replace(',', '.')
                .trim();

            // Convertir servicio a número
            let servicio = this.formularioFactura.servicio
                .replace('.', '')
                .replace(',', '.')
                .trim();

            // Si la cadena está vacía o no es un número, usar 0
            descuento = isNaN(parseFloat(descuento)) ? 0 : parseFloat(descuento);
            servicio = isNaN(parseFloat(servicio)) ? 0 : parseFloat(servicio);

            console.log(this.subtotal, descuento, servicio);

            // Sumar subtotal, descuento y servicio
            return this.subtotal + servicio - descuento;
        }
    },

    methods: {
        /**
         * Section-Inventario
         */
        listadoInventario(){
            this.tablaListaInventario = $('#kt_inventario_table').DataTable({
                "language": spanish,
                "processing": true,
                "serverSide": true,
                "responsive": false,
                "ordering": false,
                search: {
                    return: true,
                },
                "ajax": {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "/inventario/listado-inventario",
                    data: function (d) {
                        return $.extend({}, d, {
                            "buscar": $('#kt_buscador_inventario').val().toLowerCase(),
                        });
                    }
                },
                "columns": [
                    { data: "nombre", name: "nombre", sClass: "text-center"},
                    { data: "referencia", name: "referencia"},
                    { data: "segunda_referencia", name: "segunda_referencia"},
                    { data: "categoria", name: "categoria"},
                    { data: "marca", name: "marca"},
                    { data: "cantidad", name: "cantidad"},
                    { data: "cantidad_disponible", name: "cantidad_disponible"},
                    { data: "costo", name: "costo"},
                    { data: "precio", name: "precio"},
                ]
            });

        },

        selectProductos(idSelector){
            $(idSelector).select2({
                dropdownParent: $('#kt_modal_registrar_venta'),
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
                        let results = data.map(item => ({
                            id: item.id,
                            text: item.nombre +' - '+item.marca,
                            precio: item.precio,
                            precio_format: item.precio_format,
                            cantidadDisponible: item.cantidad
                        }));
                        return { results };
                    },
                    cache: true
                }
            });

            $(idSelector).on('select2:select', (e) => {

                this.formularioFactura.productoSeleccionado = e.params.data;
                // $('#total_precio_producto').html(e.params.data.precio_format);
            })

        },

        agregarProducto() {

            if(  this.formularioFactura.cantidadAdd > this.formularioFactura.productoSeleccionado.cantidadDisponible ) {
                swal({
                    title: '¡Vaya, algo no anda bien!',
                    text: 'La cantidad de producto que ingresaste supera las existencias actuales',
                    icon: 'info',
                    button: 'Cerrar esta advertencia'
                });
                return;
            }

            const resultado =  this.formularioFactura.listaProductos.find( producto => producto.id === this.formularioFactura.productoSeleccionado.id);

            if( resultado ) { // Ya existe el id que intenta añadir
                swal({
                    title: '¡Hubo un inconveniente!',
                    text: 'Ya has añadido el producto  ' + this.formularioFactura.productoSeleccionado.text + ', por favor elimínalo y añade la nueva cantidad que necesitas',
                    icon: 'info',
                    button: 'Cerrar esta advertencia'
                });
                return;
            }

            //Agregamos el producto a la lista de productos para facturar
            this.formularioFactura.listaProductos.push({
                id:       this.formularioFactura.productoSeleccionado.id,
                nombre:   this.formularioFactura.productoSeleccionado.text,
                cantidad: this.formularioFactura.cantidadAdd,
                precio:   this.formularioFactura.productoSeleccionado.precio,
                precio_format:   this.formularioFactura.productoSeleccionado.precio_format,
                total:    this.formularioFactura.totalPrecioProducto,
            });

            //Limpiamos la data
            this.formularioFactura.cantidadAdd = 1
            this.formularioFactura.totalPrecioProducto = 0;
            this.formularioFactura.productoSeleccionado.id = '';
            this.formularioFactura.productoSeleccionado.precio_format = 0.00;
            this.formularioFactura.productoSeleccionado.precio = 0.00;

            $('#select_producto').empty().trigger('change');
        },

        registrarFactura(){

            activarLoadBtn('btn_crear_factura')

            this.formularioFactura.fecha_factura = $('#fecha_factura').val();
            this.formularioFactura.fecha_vencimiento = $('#fecha_vencimiento').val();
            this.formularioFactura.totalFactura = this.total;

            axios.post('/facturas/registrar-factura', this.formularioFactura, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then( res => {

                    // swal({
                    //     title: '¡Eso es todo!',
                    //     text: 'Venta exitosa!',
                    //     icon: 'success',
                    //     buttons: 'Ver inventario',
                    //     closeOnEsc: false,
                    //     closeOnClickOutside: false
                    // }).then( confirmacion => {
                    //
                    //     if( confirmacion ) {
                    //         location.reload()
                    //     }
                    //
                    // });

                })
                .catch( respuesta => {
                    swal({
                        title: '¡Vaya!',
                        text: 'Eso no lo vi venir. No logramos procesar tu solicitud, por favor contacta al soporte técnico',
                        icon: 'error',
                        buttons: 'Cerrar este mensaje'
                    });

                })
                .finally( () => {
                    desactivarLoadBtn('btn_crear_factura');
                })
        },

        /**
         * Section-Productos
         */
        listadoProductos(){


            this.tablaListaProductos = $('#kt_productos_table').DataTable({
                "language": spanish,
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ordering": false,
                search: {
                    return: true,
                },
                "ajax": {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "/productos/listado-productos",
                    data: function (d) {
                        return $.extend({}, d, {
                            "buscar": $('#kt_buscador_producto').val().toLowerCase(),
                        });
                    }
                },
                "columns": [
                    { data: "nombre", name: "nombre"},
                    { data: "referencia", name: "referencia"},
                    { data: "categoria", name: "categoria"},
                    { data: "marca", name: "marca"},
                    { data: "cantidad", name: "cantidad"},
                    { data: "costo", name: "costo"},
                ]
            });

        },
        crearProducto() {

            activarLoadBtn('btn_crear_producto');

            this.formularioCrearProducto.validate()
                .then( estado => {

                    if( estado === 'Invalid') {
                        desactivarLoadBtn('btn_crear_producto')
                        return '';
                    }

                    const formularioCrearProducto = new FormData(document.getElementById('kt_agregar_producto_form'));

                    axios.post('/productos/crear-producto', formularioCrearProducto, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then( res => {

                            swal({
                                title: '¡Eso es todo!',
                                text: 'El producto fue registrado!',
                                icon: 'success',
                                buttons: 'Ver información',
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then( confirmacion => {

                                if( confirmacion ) {
                                    //Refrescamos la tabla para listar el nuevo resultado
                                    this.tablaListaProductos.draw()

                                    //Limpiamos el formulario
                                    document.getElementById('kt_agregar_producto_form').reset();
                                    $('#select_categoria').val('').trigger('change');
                                    $('#select_marca').val('').trigger('change');
                                }

                            });

                        })
                        .catch( respuesta => {
                            swal({
                                title: '¡Vaya!',
                                text: 'Eso no lo vi venir. No logramos procesar tu solicitud, por favor contacta al soporte técnico',
                                icon: 'error',
                                buttons: 'Cerrar este mensaje'
                            });

                        })
                        .finally( () => {
                            desactivarLoadBtn('btn_crear_producto');
                        })


                })

        },

        selectCategorias(idSelector){
            $(idSelector).select2({
                ajax: {
                    url: '/categorias/select-categorias',
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

        },

        selectMarcas(idSelector){
            $(idSelector).select2({
                ajax: {
                    url: '/categorias/select-marcas',
                    dataType: 'json',
                    type: 'get',
                    delay: 300,
                    language: 'es',
                    data: params => {
                        return {
                            busqueda: params.term,
                            page: params.page,
                            departamento_id: this.id_departamento
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

        },

        inicializarFormulariosDeValidacionProducto() {

            const crearProducto = document.getElementById('kt_agregar_producto_form');

            this.formularioCrearProducto = FormValidation.formValidation(
                crearProducto,
                {

                    fields: {
                        'producto': {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor ingresa el nombre de el producto'
                                }
                            }
                        },
                        'stock_minimo': {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor ingresa la cantidad de stock mínimo'
                                }
                            }
                        },
                        'select_categoria': {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor selecciona la categoria'
                                }
                            }
                        },

                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: ""
                        })
                    }
                }
            );

        },
    }
});

appAlmacen.mount('#app_general')
