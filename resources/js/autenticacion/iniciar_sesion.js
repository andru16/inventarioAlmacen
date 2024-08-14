import { createApp } from "vue/dist/vue.esm-bundler";
import swal from 'sweetalert';
import {activarLoadBtn, desactivarLoadBtn} from "@/ayudas/Load";

const app = createApp({
    data() {
        return {
            correo_electronico: '',
            password: '',
            confirmPassword:'',
            cargando: false,
            mostrarClave: false,
            mostrarConfirmacionClave: false,
            errores: {
                correo_electronico: {
                    estado: false,
                    mensaje: 'El correo electrónico es obligatorio'
                },
                password: {
                    estado: false,
                    mensaje: 'La contraseña es obligatoria'
                }
            },
            errorClave: {
                password: {
                    estado: false,
                    mensaje: 'La contraseña es obligatoria'
                },
                confirmPassword:{
                    estado: false,
                    mensaje: 'Las contraseñas no coninciden'
                }
            }
        }
    },
    mounted() {
        console.log('Hola Andrés')
    },
    methods: {
        mostrarOcultarClave() {

            const inputClave = document.getElementById("password");

            if (inputClave.type === "password") {
                inputClave.type = "text";
                this.mostrarClave = true;
            } else {
                inputClave.type = "password";
                this.mostrarClave = false;
            }

        },
        mostrarOcultarConfirmacionClave() {

            const inputClave = document.getElementById("confirmPassword");

            if (inputClave.type === "password") {
                inputClave.type = "text";
                this.mostrarConfirmacionClave = true;
            } else {
                inputClave.type = "password";
                this.mostrarConfirmacionClave = false;
            }

        },
        enviarFormularioInicioSesion() {

            this.cargando = true;

            if( this.verificarCamposInicioSesion() ) {
                this.cargando = false;
                return;
            }

            axios.post('/iniciar-sesion', {
                correo_electronico: this.correo_electronico,
                password: this.password
            })
                .then( respuestaServidor => {

                    console.log(respuestaServidor)
                    window.location.href = respuestaServidor.data.redireccion
                })
                .catch( errorServidor => {
                    swal({
                        title: "",
                        text: "Al parecer esas credenciales no son correctas",
                        icon: "info",
                        button: "Lo intentaré de nuevo"
                    });
                })
                .finally( () => {
                    this.cargando = false;
                })


        },
        /*
        * Esta función me permitirá identificar cuando el usuario escribió en un campo
        * para eliminar la advertencia del campo incorrecto
        * */
        detectarDato(campo) {
            this.errores[campo]['estado'] = false;
        },
        detectarDatoConfirmacion(campo) {
            this.errorClave[campo]['estado'] = false;
        },

        /*
        * Esta función permite verificamos que los campos
        * de inicio de sesión no lleguen vacíos
        * */
        verificarCamposInicioSesion() {

            let errores = false;

            if( this.correo_electronico.trim() === '') {
                this.errores.correo_electronico.estado = true;
                this.correo_electronico = '';
                errores = true;
            }

            if( this.password.trim() === '') {
                this.errores.password.estado = true;
                this.password = '';
                errores = true;
            }

            return errores;
        },
        cambiarContrasena(){

            activarLoadBtn('btn_enviar_formulario_inicio_sesion');

            axios.post('/cambiar-contrasena', {
                password: this.password,
                confirmPassword: this.confirmPassword
            })
                .then( respuestaServidor => {
                    window.location.href = '/';
                })
                .catch( errorServidor => {

                    const estado = errorServidor.response.status;

                    if( estado === 422 ) {
                        swal({
                            title: "Falta información",
                            text: "Por favor ingresa la nueva contraseña y la confirmación de la nueva contraseña",
                            icon: "error",
                            button: "Completar información"
                        });
                        return;
                    }

                    if( estado === 423 ) {
                        swal({
                            title: "Las contraseñas no coinciden",
                            text: "Por favor verifica que las contraseñas coincidan",
                            icon: "error",
                            button: "Verificar contraseñas"
                        });
                        return;
                    }

                    swal({
                        title: "¡Ups!",
                        text: "Error al cambiar la contraseña, por favor contacta al soporte técnico",
                        icon: "error",
                        button: "Cerrar este mensaje"
                    });


                })
                .finally( () => {
                    desactivarLoadBtn('btn_enviar_formulario_inicio_sesion');
                });

        }

    }
});

app.mount('#form_iniciar_sesion');
