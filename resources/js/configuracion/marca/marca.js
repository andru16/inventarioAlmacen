import {createApp} from "vue/dist/vue.esm-bundler";
import spanish from '../../data_tables/spanish.json';
import {activarLoadBtn, desactivarLoadBtn} from "@/ayudas/Load";

import swal from "sweetalert";

const appMarca = createApp({
    data() {
        return {
            tablaListaMarcas: {
                draw: () => {}
            },

            formularioRegistrarMarca:{},
        }
    },

    mounted() {
        //Obtenemos el listado de categorias
        this.listadoMarcas();

        //Inicializamos la validación del formulario
        this.inicializarFormulariosDeValidacion();
    },

    methods: {
        listadoMarcas(){

            this.tablaListaMarcas = $('#kt_marcas_table').DataTable({
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
                    url: "/configuracion/marcas/listado-marcas",
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
        registrarMarca() {

            activarLoadBtn('btn_crear_marca');

            this.formularioRegistrarMarca.validate()
                .then( estado => {

                    if( estado === 'Invalid') {
                        desactivarLoadBtn('btn_crear_marca')
                        return '';
                    }

                    const formularioRegistrarMarca = new FormData(document.getElementById('kt_form_marca'));

                    axios.post('/configuracion/registrar-marca', formularioRegistrarMarca, {
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
                                    //Refrescamos la tabla para listar el nuevo resultado
                                    this.tablaListaMarcas.draw()

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
                            desactivarLoadBtn('btn_crear_marca');
                        })


                })

        },
        inicializarFormulariosDeValidacion() {

            const registrarMarca = document.getElementById('kt_form_marca');

            this.formularioRegistrarMarca = FormValidation.formValidation(
                registrarMarca,
                {

                    fields: {
                        'nombre_categoria': {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor ingresa el nombre de la categoria'
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

appMarca.mount('#app_marca')
