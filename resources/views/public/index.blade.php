<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<body id="app">
    <div class="intro p-5">
        <div class="container-lg col-lg-10 col-xl-9 col-xxl-8">

            <div class="row">
                <div class="col-md-3 mb-4 text-center">
                    <img class="logo" src="{{asset('img/logo-color.png')}}">
                </div>
                <div class="col-md header">
                    <h1 class="title text-primary">AGENDA DEL ALCALDE</h1>
                    <h2 class="title-2 text-muted">H. AYUNTAMIENTO DE MAZATL&Aacute;N 2021-2024</h2>
                </div>
            </div>

            <div class="container col-xl-10 fs-3 my-4 text-center">
                Ent&eacute;rate de las actividades y los lugares a los que estar&aacute; acudiendo nuestro alcalde
            </div>

        </div>
    </div>

    <div class="content py-5">
        <div class="container-xxl">
            <div class="row justify-content-center align-items-start py-4">

                <!-- fecha -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 pb-5">
                    <div class="fecha card border-info">

                        <span class="arrow prev pointer" @click="anteriorDia"><i class="prev fa-solid fa-fw fa-chevron-up"></i></span>
                        <span class="arrow next pointer" @click="siguienteDia"><i class="next fa-solid fa-fw fa-chevron-down"></i></span>

                        <div class="card-header text-center">
                            <i class="fa-regular fa-calendar"></i>&nbsp; @{{mes}}
                        </div>
                        <div class="click-area card-body text-center pointer">
                            <div class="day-num text-info">@{{dia}}</div>
                            <div class="day-name">@{{diaLetra}}</div>
                        </div>
                        <div class="card-footer p-1">
                            <input type="date" class="pointer" v-model="fecha">
                        </div>
                    </div>

                    <div class="actions text-secondary">
                        <button type="button" class="btn btn-lg btn-secondary" @click="imprimirPdf" title="Descargar PDF">
                            <i class="fa-regular fa-fw fa-file-pdf"></i>
                        </button>
                        <button type="button" title="Volver al día de hoy" class="btn btn-lg btn-secondary" @click="reiniciar" >
                            <span style="font-size:17px;font-weight: 600;line-height: 47px;">HOY</span>
                        </button>
                    </div>
                </div>

                <!-- eventos -->
                <div class="col-md-9 col-lg-7 mb-4">

                    <ul class="list-group">

                        <!-- SI CITA ES PRIVADA ponemos clase privada -->
                        <div v-for="evento in eventos" class="evento list-group-item p-4 " v-bind:class="{ privado: evento.tipo_cita == 'privada' }">

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

                                        <div v-if="evento.tipo_cita != 'privada'" class="text-secondary pointer ps-3" @click="compartirWhatsApp(evento)">
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

                </div>

                <!-- twitter -->
                <div class="twitter col-12 col-sm-8 col-lg-3">
                    @include("public.twitter")
                </div>
            </div>

        </div>
    </div>

    <div class="footer bg-primary text-white p-5">
        <div class="container col-md-10">
            <div class="row justify-content-between">
                <div class="col-sm-3 col-lg-2 mb-4 mb-sm-0">
                    <a href="http://mazatlan.gob.mx">
                        <img class="footer-logo" src="{{asset('img/escudo-mazatlan-white.png')}}">
                    </a>
                </div>
                <div class="col-sm-5 col-lg-6 mb-4 mb-sm-0 mt-sm-3 lh-lg">
                    <div class="fw-bold">Presidencia Municipal</div>
                    <div>H. Ayuntamiento de Mazatl&aacute;n</div>
                    <div>Angel Flores S/N, Col. Centro</div>
                    <div>Mazatl&aacute;n, Sinaloa.</div>
                    <div>Tel. (669) 9-15-80-00</div>
                </div>
                <div class="col-sm-4 mb-4 mb-sm-0 mt-sm-3 text-end">
                    <a class="text-white" href="https://www.instagram.com/aytodemzt">
                        <i class="fa-brands fa-fw fa-3x fa-instagram"></i>
                    </a>
                    <a class="text-white" href="https://twitter.com/aytodemzt">
                        <i class="fa-brands fa-fw fa-3x fa-twitter"></i>
                    </a>
                    <a class="text-white" href="https://www.facebook.com/AytodeMzt">
                        <i class="fa-brands fa-fw fa-3x fa-facebook"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

    <div class="lds-spinner" id="spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>


</html>
<script>
  const { createApp } = Vue

  createApp({
    data() {
      return {
        fecha: '',
        fechaLetra: '',
        diaLetra: '',
        dia: '',
        mes: '',
        eventos : {},
      }
    },
    mounted (){
        document.getElementById('spinner').style.display = 'flex';

        const urlParams = new URLSearchParams(window.location.search);
        const fecha = urlParams.get('fecha');

        if(fecha){
            this.fecha = fecha;
        }else{

        let fecha = new Date();

        let year = fecha.getFullYear();
        let diaLetra = fecha.getDay();

        let mes = (fecha.getMonth() + 1 < 10) ?  '0' + (fecha.getMonth() + 1) : fecha.getMonth() + 1;
        let dia = (fecha.getDate() < 10) ?  '0' + fecha.getDate()  : fecha.getDate();

        fecha = fecha.getFullYear() + '-' + mes  + '-' + dia;


        const days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viérnes", "Sábado"];
        const month = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
            "Noviembre", "Diciembre"];

            let fechaLetra = days[diaLetra] + ' ' + dia + ' de ' + month[mes-1] + ' de ' + year;

            this.fechaLetra = fechaLetra;
            this.fecha = fecha;
        }
    },
    methods: {
        siguienteDia: function(){
            let day = new Date(this.fecha+'T00:00:00');

            day.setDate(day.getDate()+1);

            let mes = (day.getMonth() + 1 < 10) ?  '0' + (day.getMonth() + 1) : day.getMonth() + 1;
            let dia = (day.getDate() < 10) ?  '0' + day.getDate()  : day.getDate();

            this.fecha = day.getFullYear() + '-' + mes  + '-' + dia;

        },
        anteriorDia: function(){
            let day = new Date(this.fecha+'T00:00:00');
            day.setDate(day.getDate()-1);

            let mes = (day.getMonth() + 1 < 10) ?  '0' + (day.getMonth() + 1) : day.getMonth() + 1;
            let dia = (day.getDate() < 10) ?  '0' + day.getDate()  : day.getDate() ;

            this.fecha = day.getFullYear() + '-' + mes  + '-' + dia;
        },
        fechaSeleccionada: function(fecha) {

            let mes = (fecha.getMonth() + 1 < 10) ?  '0' + (fecha.getMonth() + 1) : fecha.getMonth() + 1;
            let dia = fecha.getDate();
            //console.log('el dia es ' + dia);
            let year = fecha.getFullYear();
            let diaLetra = fecha.getDay();

            const days = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
            const month = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
            "Noviembre", "Diciembre"];

                let fechaLetra = days[diaLetra] + ' ' + dia + ' de ' + month[mes-1] + ' de ' + year;

                this.fechaLetra = fechaLetra;
        },
        reiniciar(){

             let fecha = new Date();
            let mes = fecha.getMonth() + 1;

            mes = (mes < 10) ? '0' + mes : mes;
            let anio =  fecha.getFullYear();
            let fec =  anio + '-' + mes + '-' + fecha.getDate();

            this.fecha = fec;

        },
        imprimirPdf(){

            let url = document.getElementsByTagName('meta').namedItem('base-url').content + '/imprimir-pdf/' + this.fecha ;
            window.location =  url;

        },
        compartirWhatsApp(evento){
            console.log(evento);
            window.location = 'whatsapp://send?text=' + this.prepararTexto(evento.concepto) + '%20' + evento.fecha_inicio;
        },
        prepararTexto(texto){
            return texto.replace(' ', '%20');
        }
    },
    watch: {
        fecha: function(value){


            this.fechaSeleccionada(new Date(value+'T00:00:00'));

            //Obtener eventos
            let form = this;

            //Colocamos el dia cuando cambia
            let tempDia = form.fecha.split('-');
            form.dia = tempDia[2];

            //Colocamos el mes cuando cambia
            let tempMes = form.fechaLetra.split(' ');
            form.mes = tempMes[3];
            form.diaLetra = tempMes[0];

            form.eventos = [];

            let url =  document.querySelector('meta[name="base-url"]').getAttribute('content') + '/get-eventos-public';
             var data = { fecha: this.fecha, fecha_hasta : null };

              fetch(url, {
                  method: 'POST', // or 'PUT',
                  body: JSON.stringify(data),
                  headers:{
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                     }
              })
              .then(response => response.json())
              .then(data => {
                document.getElementById('spinner').style.display = 'none';
                this.eventos = data.eventos;

                //console.log(data);
              }).catch(function(error) {
                console.log('err' + error);
              });


        }
    }
  }).mount('#app')
</script>
