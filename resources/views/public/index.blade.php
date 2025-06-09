<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JQKH35SJVK"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-JQKH35SJVK');
    </script>

    <meta name="base-url" content="{{ url('') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('escudo-favicon.png') }}">
    <link rel="icon" href="{{ asset('escudo-favicon.png') }}">

    <title>Agenda de la Presidenta - H. Ayuntamiento de Mazatlán</title>

    <link rel="stylesheet" href="{{asset('lib/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('lib/fontawesome-free-6.6.0-web/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/Acherus/acherus.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/Infinita/infinita.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/spinner.css')}}">
    <link rel="stylesheet" href="{{asset('css/nuevo.css')}}">
    <link rel="stylesheet" href="{{asset('css/header.css')}}">

    


    <script src="https://unpkg.com/vue@latest"></script>
    <script src="{{asset('js/bootstrap.js')}}" charset="utf-8"></script>
    <script type="module" src="{{asset('js/index.js')}}"></script>

</head>
<body>

<div id="app">


    <!-- AQUI HAY QUE AGREGAR EL COMPONENTE -->
    <custom-header></custom-header>


        <div class="watermark">
            <img class="mujer-izq" src="{{asset('img/mujer-mzt.png')}}" />
            <img class="mujer-der" src="{{asset('img/mujer-mzt.png')}}" />
        </div>

        <div class="content">
            <div class="container-lg my-5">

                <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-1">
                    <li class="breadcrumb-item">
                        <span>
                            <img class="home" src="{{asset('img/shared/home-icon.png')}}">
                        </span>
                    </li>
                    <li class="breadcrumb-item" aria-current="page" style="--bs-breadcrumb-divider: '>'; --bs-breadcrumb-item-padding-x: 0.3rem;">Presidencia Municipal</li>
                    <li class="breadcrumb-item" aria-current="page" style="--bs-breadcrumb-item-padding-x: 0.3rem;">Agenda</li>
                </ol>
            </nav>

            <div class="row align-items-center text-center mb-2">
                <div class="col-12 col-md-12 col-lg-6 col-xl-5 text-center text-lg-start">
                    <h1 class="proyecto">Agenda</h1>
                </div>
                <div class="col-12 col-md-12 col-lg-6 col-xl-7">
                    <h4 class="titulo">Presidenta Municipal</h4>
                    <div class="separador"></div>
                </div>
            </div>


                <div class="col-12 col-md-auto offset-md-3 offset-lg-2 text-center text-gray py-2">
                    <p class="mb-0 acherus">H. Ayuntamiento de Mazatlán</p>
                </div>

                <div class="col-12 col-md-auto offset-md-3 offset-lg-2 fs-6 text-black mb-5 mb-md-2 px-2 text-center acherus">
                    ¡Mantente al día con el trabajo de nuestra Presidenta!
                </div>

                <div class="row justify-content-center align-items-start pt-3 pb-4">

                    <!-- fecha -->
                    <div class="col-8 col-sm-4 col-md-3 col-lg-2 pb-5">
                        <div class="fecha card">

                            <div class="card-header text-center">
                                <span v-cloak>@{{mes}}</span>
                            </div>
                            <div class="click-area card-body text-center pointer">
                                <div class="day-num text-gray" v-cloak>@{{dia}}</div>
                                <div class="anio-num">@{{anio}}</div>
                                <div class="day-name" v-cloak>@{{diaLetra}}</div>
                            </div>
                            <!--<div class="card-footer p-1">
                                <input type="date" class="pointer" v-model="fecha">
                            </div>-->
                            
                        </div>

                        <div class="barra-desplazamiento card d-flex flex-row align-items-center w-100">
                            <span class="arrow prev pointer d-flex justify-content-center align-items-center"
                                    @click="anteriorDia">
                                <i class="fa-solid fa-fw fa-chevron-left"></i>
                            </span>

                            <input type="date" class="fecha-input pointer flex-grow-1" v-model="fecha">

                            <span class="arrow next pointer d-flex justify-content-center align-items-center"
                                    @click="siguienteDia">
                                <i class="fa-solid fa-fw fa-chevron-right"></i>
                            </span>
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
                                <div v-if="loading">
                                    <i class="fa-solid fa-spinner fa-spin" style="color: gainsboro"></i>
                                    <div style="font-weight: 300;">Cargando eventos...</div>
                                </div>
                                <div v-else>
                                    <i class="fa-regular fa-calendar-xmark" style="color: gainsboro"></i>
                                    <div style="font-weight: 300;">No hay eventos programados</div>
                                </div>
                            </div>
                        </div>


                        <div class="text-muted text-center mt-5">Estas citas est&aacute;n sujetas a cambios sin previo aviso</div>

                    </div>
                </div>

            </div>
        </div>

        

        <div class="footer bg-primary text-light px-2 py-3 py-lg-4">
        <!-- Escritorio -->
        <div class="container-fluid d-none d-lg-block">
            <div class="row justify-content-between">
                <div class="col-12 col-lg-3 col-xl-2 mb-4 mb-lg-0">
                    <img class="escudo" src="{{asset('img/shared/escudo-vert-white.png')}}" >

                    <div class="social-icons text-center mt-2">
                        <a href="https://www.facebook.com/GobiernoMunicipaldeMazatlan/">
                            <i class="fa-brands fa-fw icono fa-facebook-f"></i>
                        </a>
                        <a href="https://www.youtube.com/@hayuntamientodemazatlan/">
                            <i class="fa-brands fa-fw icono fa-youtube"></i>
                        </a>
                        <a href="https://www.instagram.com/gobiernomunicipaldemazatlan/">
                            <i class="fa-brands fa-fw icono fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-lg-9 col-xl-10">
                    <div class="footer-menu container-fluid">
                        <div class="row justify-content-xl-end">
                            <div class="col-12 col-lg-4 col-xl-auto mb-3 mb-xl-0 custom-flex-grow">
                                <div class="footer-heading">Ayuntamiento de Mazatlán</div>

                                <ul class="footer-list">
                                    <li><a href="https://wvw.mazatlan.gob.mx/organigrama/">Gobierno</a></li>
                                    <li><a href="https://servicios.mazatlan.gob.mx/">Pagos en línea</a></li>
                                    <!-- <li><a href="#">Facturación</a></li> -->
                                    <li><a href="#">Mapa del sitio</a></li>
                                    <li><a href="#">Atención ciudadana</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-8 col-xl-auto mb-3 mb-xl-0 custom-flex-grow">
                                <div class="footer-heading">Órgano Interno de Control</div>

                                <ul class="footer-list">
                                    <li><a href="https://oicmzt.com/oic/denuncia-o-queja/">Realiza una denuncia</a></li>
                                    <li><a href="http://wvw.mazatlan.gob.mx/wp-content/uploads/2025/01/Codigo-de-Etica-de-las-Personas-Servidoras-Publicas-del-Municipio-de-Mazatlan-Sinaloa-1.pdf">Código de ética</a></li>
                                    <li><a href="https://wvw.mazatlan.gob.mx/wp-content/uploads/2022/04/C%C3%B3digo-de-Conducta-de-las-Personas-Servidoras-P%C3%BAblicas-del-Municipio-de-Mazatl%C3%A1n-Sinaloa.pdf">Código de conducta</a></li>
                                    <li><a href="https://tics.mazatlan.gob.mx/sisdec/autoridad-investigadora">SISDEC</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-4 col-xl-auto mb-3 mb-xl-0 custom-flex-grow">
                                <div class="footer-heading">Transparencia</div>

                                <ul class="footer-list">
                                    <li><a href="http://transparencia.mazatlan.gob.mx/destinatarios-de-recursos/destinatarios-y-uso-de-recursos-entregados">Destino de recursos</a></li>
                                    <li><a href="https://sindicoprocurador.mazatlan.gob.mx/">Síndico procurador</a></li>
                                    <li><a href="https://tics.mazatlan.gob.mx/asuntosjuridicos">Asuntos jurídicos</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-8 col-xl-auto mb-3 mb-xl-0 custom-flex-grow">
                                <div class="footer-heading">Enlaces</div>

                                <div class="row">
                                    <div class="col-auto">
                                        <ul class="footer-list">
                                            <li><a href="https://imdem.mazatlan.gob.mx/">IMDEM</a></li>
                                            <li><a href="https://imju.mazatlan.gob.mx/">IMJU</a></li>
                                            <li><a href="https://immujer.mazatlan.gob.mx/">IMMUJER</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-auto">
                                        <ul class="footer-list">
                                            <li><a href="https://culturamazatlan.com/">CULTURA</a></li>
                                            <li><a href="http://jumapam.gob.mx/">JUMAPAM</a></li>
                                            <li><a href="http://difmazatlan.gob.mx/">DIF</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-auto text-nowrap">
                                        <ul class="footer-list">
                                            <li><a href="https://wvw.mazatlan.gob.mx/#">VISIT MAZATLAN</a></li>
                                            <li><a href="https://wvw.mazatlan.gob.mx/#">MAZATLAN TRAVEL</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-12 col-xl-12 text-end d-flex flex-column justify-content-end">
                                <div>Angel Flores s/n Col. Centro C.P. 82000</div>
                                <div>H. Ayuntamiento de Mazatlán 2025</div>
                            </div>
                        </div>
                    </div><!-- /footer-menu -->
                </div>
            </div>
        </div>

        <!-- Mobile -->
        <div class="container-fluid d-lg-none">
            <!-- Enlaces -->
            <div id="footer-mobile" class="mb-4">
                <div class="mb-2">
                    <button class="btn btn-primary footer-heading-mobile" type="button" data-bs-toggle="collapse" data-bs-target="#ayuntamiento-collapse" aria-expanded="false" aria-controls="ayuntamiento-collapse">
                        <i class="fa-solid fa-fw fa-plus collapse-icon"></i>
                        <i class="fa-solid fa-fw fa-minus collapse-icon"></i>
                        Ayuntamiento de Mazatlán
                    </button>
                    <ul class="footer-list collapse collapse-margin" id="ayuntamiento-collapse" data-bs-parent="#footer-mobile">
                        <li class="mb-3"><a href="https://wvw.mazatlan.gob.mx/organigrama/">Gobierno</a></li>
                        <li class="mb-3"><a href="https://servicios.mazatlan.gob.mx/">Pagos en línea</a></li>
                        <li class="mb-3"><a href="#">Mapa del sitio</a></li>
                        <li class="mb-3"><a href="#">Atención ciudadana</a></li>
                    </ul>
                </div>
                <div class="mb-2">
                    <button class="btn btn-primary footer-heading-mobile" type="button" data-bs-toggle="collapse" data-bs-target="#oic-collapse" aria-expanded="false" aria-controls="oic-collapse">
                        <i class="fa-solid fa-fw fa-plus collapse-icon"></i>
                        <i class="fa-solid fa-fw fa-minus collapse-icon"></i>
                        Órgano Interno de Control
                    </button>
                    <ul class="footer-list collapse collapse-margin" id="oic-collapse" data-bs-parent="#footer-mobile">
                        <li class="mb-3"><a href="https://oicmzt.com/oic/denuncia-o-queja/">Realiza una denuncia</a></li>
                        <li class="mb-3"><a href="http://wvw.mazatlan.gob.mx/wp-content/uploads/2025/01/Codigo-de-Etica-de-las-Personas-Servidoras-Publicas-del-Municipio-de-Mazatlan-Sinaloa-1.pdf">Código de ética</a></li>
                        <li class="mb-3"><a href="https://wvw.mazatlan.gob.mx/wp-content/uploads/2022/04/C%C3%B3digo-de-Conducta-de-las-Personas-Servidoras-P%C3%BAblicas-del-Municipio-de-Mazatl%C3%A1n-Sinaloa.pdf">Código de conducta</a></li>
                        <li class="mb-3"><a href="https://tics.mazatlan.gob.mx/sisdec/autoridad-investigadora">SISDEC</a></li>
                    </ul>
                </div>
                <div class="mb-2">
                    <button class="btn btn-primary footer-heading-mobile" type="button" data-bs-toggle="collapse" data-bs-target="#transparencia-collapse" aria-expanded="false" aria-controls="transparencia-collapse">
                        <i class="fa-solid fa-fw fa-plus collapse-icon"></i>
                        <i class="fa-solid fa-fw fa-minus collapse-icon"></i>
                        Transparencia
                    </button>
                    <ul class="footer-list collapse collapse-margin" id="transparencia-collapse" data-bs-parent="#footer-mobile">
                        <li class="mb-3"><a href="http://transparencia.mazatlan.gob.mx/destinatarios-de-recursos/destinatarios-y-uso-de-recursos-entregados">Destino de recursos</a></li>
                        <li class="mb-3"><a href="https://sindicoprocurador.mazatlan.gob.mx/">Síndico procurador</a></li>
                        <li class="mb-3"><a href="https://tics.mazatlan.gob.mx/asuntosjuridicos">Asuntos jurídicos</a></li>
                    </ul>
                </div>
                <div class="mb-2">
                    <button class="btn btn-primary footer-heading-mobile" type="button" data-bs-toggle="collapse" data-bs-target="#enlaces-collapse" aria-expanded="false" aria-controls="enlaces-collapse">
                        <i class="fa-solid fa-fw fa-plus collapse-icon"></i>
                        <i class="fa-solid fa-fw fa-minus collapse-icon"></i>
                        Enlaces
                    </button>
                    <ul class="footer-list collapse collapse-margin" id="enlaces-collapse" data-bs-parent="#footer-mobile">
                        <li class="mb-3"><a href="https://imdem.mazatlan.gob.mx/">IMDEM</a></li>
                        <li class="mb-3"><a href="https://imju.mazatlan.gob.mx/">IMJU</a></li>
                        <li class="mb-3"><a href="https://immujer.mazatlan.gob.mx/">IMMUJER</a></li>
                        <li class="mb-3"><a href="https://culturamazatlan.com/">CULTURA</a></li>
                        <li class="mb-3"><a href="http://jumapam.gob.mx/">JUMAPAM</a></li>
                        <li class="mb-3"><a href="http://difmazatlan.gob.mx/">DIF</a></li>
                        <li class="mb-3"><a href="https://wvw.mazatlan.gob.mx/#">VISIT MAZATLAN</a></li>
                        <li class="mb-3"><a href="https://wvw.mazatlan.gob.mx/#">MAZATLAN TRAVEL</a></li>
                    </ul>
                </div>
            </div>

            <!-- Logo y redes sociales -->
            <div class="row justify-content-between">
                <div class="col-4">
                    <img class="escudo-mobile" src="{{asset('img/shared/escudo-vert-white.png')}}" >
                </div>
                <div class="col-8">
                    <!-- Redes Sociales -->
                    <div class="social-icons text-end mt-4 mb-3">
                        <a href="https://www.facebook.com/GobiernoMunicipaldeMazatlan/">
                            <i class="fa-brands fa-fw icono fa-facebook-f"></i>
                        </a>
                        <a href="https://www.youtube.com/@hayuntamientodemazatlan/">
                            <i class="fa-brands fa-fw icono fa-youtube"></i>
                        </a>
                        <a href="https://www.instagram.com/gobiernomunicipaldemazatlan/">
                            <i class="fa-brands fa-fw icono fa-instagram"></i>
                        </a>
                    </div>

                    <!-- Dirección -->
                    <div class="col-12 col-lg-12 col-xl-12 text-end d-flex flex-column justify-content-end address-mobile">
                        <div class="mb-2">Angel Flores s/n Col. Centro C.P. 82000</div>
                        <div>H. Ayuntamiento de Mazatlán 2025</div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- footer -->


    </div> <!-- app-->

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
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>-->


</body>
</html>
