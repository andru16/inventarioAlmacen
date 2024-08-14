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
        //Obtenemos la información del almacén
        this.obtenerListadoCategorias();

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
                    url: "/usuarios/traer",
                    data: function (d) {
                        return $.extend({}, d, {
                            "buscar": inputBuscadorUsuarios.val().toLowerCase(),
                        });
                    }
                },
                "columns": [
                    { data: "nombreCompleto", name: "nombreCompleto"},
                    { data: "cargo", name: "cargo"},
                    { data: "id", name:"id", sClass:"text-center",
                        render: function( data, type, row) {

                            if( row.personificar ) {
                                return `
                                <a href="/administracion/personificar/${ data }" class="btn btn-light-success btn-sm" style="margin-right: 4px;">Acceder</a>
                            `;
                            }

                            return '';

                        }
                    }
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

appCategoria.mount('#app_categoria')
