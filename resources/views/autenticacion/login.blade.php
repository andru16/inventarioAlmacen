@extends('plantillas.iniciar_sesion')

@section('styles')
    <style>
        .icono-mensaje img {
            width: 25px;
            height: 25px;
        }

        .icono-mensaje {
            background-color: #f5f8fa;
            width: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top-right-radius: .475rem;
            border-bottom-right-radius: .475rem;
        }

        .sin-bordes-finales {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .form-floating:focus-within .icono-mensaje {
            background-color: #eef3f7;
        }

        .icono-mensaje:hover {
            cursor: pointer;
        }

        [v-cloak] {
            display: none;
        }
    </style>
@endsection

@section('formulario_login')
    <!-- Formulario inicio de sesión -->
    <form class="form w-100" novalidate="novalidate" id="form_iniciar_sesion" action="#">

        <!-- Encabezado del inicio de sesión -->

        <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mt-3 text-dark--login">Iniciar sesión</h1>
        </div>

        <!-- ./ Encabezado del inicio de sesión -->
        <!-- Correo electrónico -->
        <div class="form-floating mb-7">
            <input
                type="email"
                class="form-control form-control-solid"
                :class="errores.correo_electronico.estado ? 'is-invalid' : ''"
                v-model="correo_electronico"
                id="correo_electronico"
                placeholder=""
                @keyup="detectarDato('correo_electronico')"
            />
            <label for="correo_electronico">Correo electrónico</label>
            <div v-if="errores.correo_electronico.estado" class="mt-1">
                <span class="text-danger" v-text="errores.correo_electronico.mensaje"></span>
            </div>
        </div>
        <!-- ./ Correo electrónico -->
        <!-- Contraseña -->
        <div class="d-flex">

            <div class="form-floating mb-7 d-flex w-100">
                <input
                    type="password"
                    class="form-control form-control-solid sin-bordes-finales"
                    :class="errores.password.estado ? 'is-invalid' : ''"
                    v-model="password"
                    id="password"
                    placeholder=""
                    @keydown="detectarDato('password')"
                    @keypress.enter="enviarFormularioInicioSesion"
                />
                <div class="icono-mensaje" v-cloak @click="mostrarOcultarClave">
                    <img v-show="!mostrarClave && password !== ''" src="{{ asset('assets/media/icons/ver.png') }}"
                         alt="">
                    <img v-show="mostrarClave && password !== ''" src="{{ asset('assets/media/icons/cerrar-ojo.png') }}"
                         alt="">
                </div>
                <label for="password">Contraseña</label>
                <div v-if="errores.password.estado" class="mt-1">
                    <span class="text-danger" v-text="errores.password.mensaje"></span>
                </div>
            </div>


        </div>


        <!-- ./ Contraseña -->
        <!-- Botón inicio de sesión -->
        <div class="d-grid mb-10">
            <button
                type="button"
                id="btn_enviar_formulario_inicio_sesion"
                @click="enviarFormularioInicioSesion"
                :data-kt-indicator="cargando ? 'on' : ''"
                class="btn btn-primary"
                :class="cargando ? 'disabled' : ''"
            >

                <span class="indicator-label">Iniciar sesión</span>

                <!-- Botón de progreso inicio de sesión -->
                <span class="indicator-progress">
                    Verificando información...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                <!-- ./ Botón de progreso inicio de sesión -->
            </button>
        </div>
        <!-- ./ Botón inicio de sesión -->
    </form>
    <!-- ./ Formulario inicio de sesión -->
@endsection
@section('scripts')
    @vite(['resources/js/autenticacion/iniciar_sesion.js'])
@endsection
