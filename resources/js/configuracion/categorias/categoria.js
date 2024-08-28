import {createApp} from "vue/dist/vue.esm-bundler";
import spanish from '../../data_tables/spanish.json';
import {activarLoadBtn, desactivarLoadBtn} from "@/ayudas/Load";

import swal from "sweetalert";

const appCategoria = createApp({
    data() {
        return {
            tablaListaCategorias: {
                draw: () => {}
            },

            formularioRegistrarCategoria:{},
        }
    },

    mounted() {
        //Obtenemos el listado de categorias
        this.listadoCategorias();

        //Inicializamos la validación del formulario
        this.inicializarFormulariosDeValidacion();
    },

    methods: {
        listadoCategorias(){

            this.tablaListaCategorias = $('#kt_categorias_tabla').DataTable({
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
                    url: "/configuracion/categorias/listado-categorias",
                    data: function (d) {
                        return $.extend({}, d, {
                            // "buscar": inputBuscadorUsuarios.val().toLowerCase(),
                        });
                    }
                },
                "columns": [
                    { data: "count", name: "count"},
                    { data: "nombre", name: "nombre"},
                ]
            });

        },
        registrarCategoria() {

            activarLoadBtn('btn_crear_categoria');

            this.formularioRegistrarCategoria.validate()
                .then( estado => {

                    if( estado === 'Invalid') {
                        desactivarLoadBtn('btn_crear_categoria')
                        return '';
                    }

                    const formularioRegistrarCategoria = new FormData(document.getElementById('kt_form_categoria'));

                    axios.post('/configuracion/registrar-categoria', formularioRegistrarCategoria, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then( res => {

                            swal({
                                title: '¡Eso es todo!',
                                text: 'La categoria fue registrada!',
                                icon: 'success',
                                buttons: 'Ver información',
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then( confirmacion => {

                                if( confirmacion ) {
                                    //Refrescamos la tabla para listar los nuevos registros
                                    this.tablaListaCategorias.draw()

                                    //Limpiamos el formulario
                                    document.getElementById('kt_form_categoria').reset();
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
                            desactivarLoadBtn('btn_crear_categoria');
                        })


                })

        },
        inicializarFormulariosDeValidacion() {

            const formRegistrarCatergoria = document.getElementById('kt_form_categoria');

            this.formularioRegistrarCategoria = FormValidation.formValidation(
                formRegistrarCatergoria,
                {

                    fields: {
                        'nombre_marca': {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor ingresa el nombre de la marca'
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

appCategoria.mount('#app_categoria')
