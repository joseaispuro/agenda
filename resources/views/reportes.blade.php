
@extends('layouts.app')

@section('title', 'Agenda Municipal')

@push('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{asset('js/reportes.js')}}"></script>
@endpush

@section('content')

<div id="app">

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"><i class="fas fa-calendar-week"></i> Agenda Municipal</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <img src="http://servicios.mazatlan.gob.mx/predial/img/logo-white.png" class="logo" alt="">
  <!--<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="{{url('/logout')}}">Cerrar Sesión</a>
    </li>
  </ul>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{url('/')}}">
              <i class="fas fa-home"></i>
              Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{url('/evento')}}">
              <i class="fas fa-calendar-week"></i>
              Evento
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{url('/reportes')}}">
              <i class="fas fa-chart-bar"></i>
              Reportes
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Configuración</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fas fa-user-friends"></i>
              Usuarios
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fas fa-tools"></i>
              Mantenimiento
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <h2 class="text-center"> Reportes</h2>
         <div class="row mb-3  d-flex justify-content-center encabezado">

            <div class="row col-md-8">
              <div class="col-md-2">
                <label for=""><strong>Fecha Inicio</strong></label>
                <input type="date" class="form-control" v-model="fecha_inicio">
              </div>
              <div class="col-md-2">
                <label for=""><strong>Fecha Fin</strong></label>
                <input type="date" class="form-control" v-model="fecha_fin">
              </div>

              <div class="col-md-2">
                <label for=""><strong>Atiende</strong></label>
                <select name="atiende" v-model="atiende" id="" class="form-control">
                  <option value="0">Todo</option>
                  <option value="1">Alcalde</option>
                  <option value="2">Representación</option>
                </select>
              </div>

              <div class="col-md-2">
                <label for=""><strong>Tipo</strong></label>
                <select name="tipo" v-model="tipo" class="form-control">
                  <option value="0">Todo</option>
                  <option value="publica">Pública</option>
                  <option value="privada">Privada</option>
                  <option value="invitacion">Invitación</option>
                </select>
              </div>

              <div class="col mb-2 mt-3 d-grid gap-2">
                <button class="btn btn-primary" @click="visualizar"><i class="fas fa-list-ol"></i> Visualizar</button>
              </div>
              <div class="col mb-2 mt-3 d-grid gap-2">
                <button class="btn btn-success" @click="generar"><i class="far fa-file-alt"></i> Generar PDF</button>
              </div>
            </div>
          </div>

          <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <table class="table table-striped" id="lista" v-if="eventos.length > 0">
                  <thead>
                    <th>Hora</th>
                    <th>Evento</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                  </thead>
                  <tr v-for="evento in eventos">
                    <td><i class="fas fa-clock"></i> @{{ evento.fecha_inicio.substr(10) }} a  @{{ evento.fecha_fin.substr(10) }}</td>
                    <td><strong>@{{evento.concepto}}</strong></td>
                    <td>@{{evento.tipo_cita}}</td>
                    <td>@{{evento.fecha_formateada}}</td>
                  </tr>
              </table>
            </div>

            <h3 v-if="eventos.length == 0">No hay eventos registrados</h3>
          </div>

    </main>
  </div>
</div>


</div>

    <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  

@endsection