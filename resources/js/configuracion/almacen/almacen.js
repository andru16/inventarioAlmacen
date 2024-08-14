import {createApp} from "vue/dist/vue.esm-bundler";
import spanish from '../../data_tables/spanish.json';
import {activarLoadBtn, desactivarLoadBtn} from "@/ayudas/Load";

import swal from "sweetalert";

const appAlmacen = createApp({
    data() {
        return {
            almacen: null,
            id_departamento: null,
            id_ciudad: null,
            formularioInformacionAlmacen:{},
        }
    },

    mounted() {
        //Obtenemos la información del almacén
        this.obtenerInformacionAlmacen();

        //Inicializamos los select
        this.selectDepartamentos('#select_departamento');
        this.selectCiudades('#select_ciudad');

        //Inicializamos la validación del formulario
        this.inicializarFormulariosDeValidacion();
    },

    methods: {
        obtenerInformacionAlmacen(){
            axios.get('/configuracion/informacion-almacen')
                .then(res => {
                    console.log(res.data);
                    this.almacen = res.data;
                    console.log(this.almacen);
                })
                .catch(err => {
                    console.log('error', err);
                });
        },
        selectDepartamentos(idSelector){
            $(idSelector).select2({
                ajax: {
                    url: '/lista-departamentos',
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

            // Escucha el evento 'select2:select' y maneja los datos seleccionados
            $(idSelector).on("select2:select", e => {
                this.id_departamento = e.params.data.id;
            });
        },

        selectCiudades(idSelector){
            $(idSelector).select2({
                ajax: {
                    url: '/lista-ciudades',
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

            // Escucha el evento 'select2:select' y maneja los datos seleccionados
            $(idSelector).on("select2:select", e => {
                this.id_ciudad = e.params.data.id;
            });
        },
        registrarInformacion() {

            activarLoadBtn('btn_registrar_info_almacen');

            this.formularioInformacionAlmacen.validate()
                .then( estado => {

                    if( estado === 'Invalid') {
                        desactivarLoadBtn('btn_registrar_info_almacen')
                        return '';
                    }

                    const formularioInformacionAlmacen = new FormData(document.getElementById('kt_informacion_almacen'));

                    axios.post('/configuracion/registrar/informacion-almacen', formularioInformacionAlmacen, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then( res => {

                            swal({
                                title: '¡Eso es todo!',
                                text: 'La información fue registrada correctamente',
                                icon: 'success',
                                buttons: 'Ver información',
                                closeOnEsc: false,
                                closeOnClickOutside: false
                            }).then( confirmacion => {

                                if( confirmacion ) {
                                    this.obtenerInformacionAlmacen();

                                    //Limpiamos el formulario
                                    document.getElementById('kt_informacion_almacen').reset();
                                    $('#select_departamento').val('').trigger('change');
                                    $('#select_ciudad').val('').trigger('change');
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
                            desactivarLoadBtn('btn_registrar_info_almacen');
                        })


                })

        },
        inicializarFormulariosDeValidacion() {

            const formFactura = document.getElementById('kt_informacion_almacen');

            this.formularioInformacionAlmacen = FormValidation.formValidation(
                formFactura,
                {

                    fields: {
                        'nombre_almacen': {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor ingresa el nombre del almacén'
                                }
                            }
                        },
                        'telefono': {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor ingresa un número de teléfono'
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

appAlmacen.mount('#app_almacen')
