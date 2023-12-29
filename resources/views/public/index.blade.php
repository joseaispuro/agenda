<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Gibrán Beltrán">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="base-url" content="{{ url('') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Agenda del Alcalde - H. Ayuntamiento de Mazatlán</title>

    <link rel="stylesheet" href="{{asset('lib/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('lib/fontawesome-free-6.1.1-web/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/spinner.css')}}">

    <script src="https://unpkg.com/vue@3"></script>
    <script type="module" src="{{asset('js/index.js')}}"></script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

</head>
<body>
    <div id="app">
        <div class="intro py-5">
            <div class="container-xl">

                <div class="row justify-content-center">
                    <div class="col-md-auto me-0 me-md-4 mb-4 text-center">
                        <img class="logo" src="{{asset('img/logo.svg')}}">
                    </div>
                    <div class="col-md-auto header text-center text-md-left">
                        <h1 class="title text-primary">AGENDA DEL ALCALDE</h1>
                        <h2 class="title-2 text-muted">H. AYUNTAMIENTO DE MAZATL&Aacute;N 2021-2024</h2>
                    </div>
                </div>

                <div class="container fs-3 my-4 text-center">
                    Ent&eacute;rate de las actividades y los lugares a los que estar&aacute; acudiendo nuestro alcalde
                </div>

            </div>
        </div>

        <div class="content py-5">
            <div class="container-xl">
                <div class="row justify-content-center align-items-start py-4">

                    <!-- fecha -->
                    <div class="col-8 col-sm-4 col-md-3 col-lg-2 pb-5">
                        <div class="fecha card border-info">

                            <span class="arrow prev pointer" @click="anteriorDia"><i class="prev fa-solid fa-fw fa-chevron-up"></i></span>
                            <span class="arrow next pointer" @click="siguienteDia"><i class="next fa-solid fa-fw fa-chevron-down"></i></span>

                            <div class="card-header text-center">
                                <i class="fa-regular fa-calendar"></i>&nbsp; <span v-cloak>@{{mes}}</span>
                            </div>
                            <div class="click-area card-body text-center pointer">
                                <div class="day-num text-info" v-cloak>@{{dia}}</div>
                                <div class="day-name" v-cloak>@{{diaLetra}}</div>
                            </div>
                            <div class="card-footer p-1">
                                <input type="date" class="pointer" v-model="fecha">
                            </div>
                        </div>

                        <div class="actions text-secondary">
                            <button type="button" class="btn btn-lg btn-secondary" @click="imprimir" title="Imprimir">
                                <i class="fa-solid fa-fw fa-print"></i>
                            </button>
                            <button type="button" title="Volver al día de hoy" class="btn btn-lg btn-secondary" @click="reiniciar" >
                                <span style="font-size:17px;font-weight: 600;line-height: 47px;">HOY</span>
                            </button>
                        </div>
                    </div>

                    <!-- eventos -->
                    <div class="col-md mb-4">

                        <ul class="list-group">

                            <!-- SI CITA ES PRIVADA ponemos clase privada -->
                            <div v-for="evento in eventos" :key="evento.id" class="evento list-group-item p-4 " v-bind:class="{ privado: evento.tipo_cita == 'privada' }" v-cloak>

                                <div class="d-flex">
                                    <div class="hora">
                                        <div>@{{evento.fecha_inicio.substr(10, 6)}}</div>
                                        <div class="ampm">HRS</div>
                                    </div>

                                    <div class="evento-titulo col ps-3"  v-bind:class="[evento.tipo_cita != 'privada' ? 'border-primary' : 'border-secondary']">

                                            <h5  v-if="evento.tipo_cita != 'privada'"class="card-title mb-3">@{{evento.concepto}}</h5>
                                            <h6  v-if="evento.tipo_cita != 'privada'" class="card-subtitle text-muted">@{{evento.asunto}}</h6>

                                            <h5 v-else class="card-title">CITA PRIVADA</h5>

                                    </div>

                                    <div v-if="evento.tipo_cita != 'privada'" class="text-secondary pointer ps-3 d-block d-md-none" @click="compartirWhatsApp(evento)">
                                        <i class="fa-solid fa-fw fa-lg fa-share-from-square"></i>
                                    </div>
                                </div>

                                <div class="detalles row col-md-10 mx-auto mt-4 text-center text-primary" v-if="evento.tipo_cita != 'privada'">
                                            <div class="col-md mb-3">
                                                <div class="text-info mb-1">
                                                    <i class="fa-solid fa-user-tie"></i>
                                                    <label>ATIENDE</label>
                                                </div>

                                                <div>@{{evento.atiende}}</div>
                                            </div>
                                            <div class="col-md mb-3">
                                                <div class="text-info mb-1">
                                                    <i class="fa-solid fa-people-group"></i>
                                                    <label>ASISTEN</label>
                                                </div>

                                                <div>
                                                @{{evento.asiste}}
                                                </div>
                                            </div>
                                            <div class="col-md mb-3">
                                                <div class="text-info mb-1">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <label>LUGAR</label>
                                                </div>

                                                <div>@{{evento.lugar}}</div>
                                            </div>
                                </div>

                            </div><!-- /evento -->

                        </ul>


                        <div class="card bg-light empty" v-if="eventos.length == 0">
                                <div class="card-body py-5">
                                    <i class="fa-regular fa-calendar-xmark" style="color: gainsboro"></i>
                                    <div style="font-weight: 300;">No hay eventos programados</div>
                                </div>
                        </div>


                        <div class="text-muted text-center mt-5">Estas citas est&aacute;n sujetas a cambios sin previo aviso</div>

                    </div>

                    @if (env('URL_TWITTER'))
                    <!-- twitter -->
                    <div class="twitter col-12 col-sm-9 col-md-8 col-lg-4 col-xl-3">
                        @include("public.twitter", ["url" => env('URL_TWITTER')])
                    </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="footer bg-primary text-white">
            <div class="container col-md-10 pt-5">
                <div class="row justify-content-between">
                    <div class="col-sm-3 col-lg-2 mb-4 mb-sm-0">
                        <a href="http://mazatlan.gob.mx">
                            <img class="footer-logo" src="{{asset('img/logo.svg')}}">
                        </a>
                    </div>
                    <div class="col-sm-5 col-lg-6 mb-4 mb-sm-0 mt-sm-3 lh-lg">
                        <div class="fw-bold">Presidencia Municipal</div>
                        <div>H. Ayuntamiento de Mazatl&aacute;n</div>
                        <div>Angel Flores S/N, Col. Centro</div>
                        <div>Mazatl&aacute;n, Sinaloa.</div>
                    </div>
                    <div class="col-sm-4 mb-4 mb-sm-0 mt-sm-3 text-end d-flex flex-column justify-content-between">
                        @if (env('URL_INSTAGRAM'))
                        <a class="text-white" href="{{env('URL_INSTAGRAM')}}">
                            <i class="fa-brands fa-fw fa-3x fa-instagram"></i>
                        </a>
                        @endif
                        @if (env('URL_TWITTER'))
                        <a class="text-white" href="{{env('URL_TWITTER')}}">
                            <i class="fa-brands fa-fw fa-3x fa-twitter"></i>
                        </a>
                        @endif
                        @if (env('URL_FACEBOOK'))
                        <a class="text-white" href="{{env('URL_FACEBOOK')}}">
                            <i class="fa-brands fa-fw fa-3x fa-facebook"></i>
                        </a>
                        @endif
                        &nbsp;
                    </div>
                </div>
            </div>

            <a class="d-block text-center fw-bold pb-2" style="color: dimgray" href="mailto:gibrans64@gmail.com">
                Desarrollo por Gibrán Beltrán y Jose Aispuro. Informática Mazatlán.
            </a>
        </div>
    </div>

    <div class="lds-spinner" id="spinner">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</body>
</html>
