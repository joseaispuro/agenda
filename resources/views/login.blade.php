<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Inicio de Sesión')

@push('styles')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{asset('js/login.js')}}"></script>
@endpush

@section('content')

    <div class="container h-100" id="app">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="https://servicios.mazatlan.gob.mx/predial/img/logo-white.png" class="brand_logo" alt="Logo">
                    </div>
                </div>

                    <h3>Agenda Municipal</h3>

                <div class="d-flex justify-content-center form_container">
                    <form>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="usuario" class="form-control input_user" v-model="usuario"  autocomplete="off" placeholder="Usuario">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control input_pass" v-model="password" autocomplete="off" v-on:keyup.enter="ingresar" placeholder="Contraseña">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customControlInline">
                                <label class="custom-control-label" for="customControlInline">Recordarme</label>
                            </div>
                        </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                 <button v-on:click="ingresar" type="button" name="button" class="btn login_btn"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
                        </div>
                        <div class="d-flex justify-content-center mt-3 login_container">
                                 <button v-on:click="limpiarDatos" type="button" name="button" class="btn btn-warning btn-block"><i class="fas fa-eraser"></i> Limpiar datos</button>
                        </div>
                    </form>
                </div>
        
            </div>
        </div>
    </div>

@endsection