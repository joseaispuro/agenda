
@extends('layouts.app')

@section('title', 'Agenda Municipal')

@push('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{asset('js/home.js')}}"></script>
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
      <a class="nav-link" href="#">Cerrar Sesión</a>
    </li>
  </ul>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">
              <i class="fas fa-home"></i>
              Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/evento">
              <i class="fas fa-calendar-week"></i>
              Evento
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/reportes">
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
          <h2 class="text-center mb-4 mt-4"> Agenda del Día</h2>
        
          <div class="row mb-4 d-flex justify-content-center">
              <div class="col-md-2">
                <button class="btn btn-action btn-lg" style="width: 100%;" @click="anteriorDia"><i class="fas fa-arrow-alt-circle-left"></i></button>
              </div>
              <div class="col-md-4">
                <p class="fecha">@{{fechaLetra}}</p>
              </div>
              <div class="col-md-2">
                <button class="btn btn-action btn-lg" style="width: 100%;" @click="siguienteDia"><i class="fas fa-arrow-alt-circle-right"></i></button>
              </div>
          </div>

          <div class="row d-flex justify-content-center mb-4">

              <div class="col-md-8 d-flex justify-content-end barra-publicado ">
                <h6 class="publicado" v-text=" publicado ? 'Publicado en página' : 'No publicado en página'"></h6>
              <div class='form-check form-switch'>
                <label>&nbsp;</label>
                <input class='form-check-input btn-lg' type='checkbox' id='flexSwitchCheckDefault' v-model='publicado'>
              </div>
              </div>
          </div>

          <!--<h5>  {{$fecha_letra ?? ''}}</h5>-->
        <div class="row d-flex justify-content-center">
          <div class="col-md-8">


           <table class="table table-striped" id="lista" v-if="eventos.length > 0">
            <thead>
              <th>Hora</th>
              <th>Evento</th>
              <th>Tipo</th>
              <th></th>
            </thead>
            <tbody>
              <tr v-for="evento in eventos">
                <td><i class="fas fa-clock"></i> @{{ evento.fecha_inicio.substr(10) }} a  @{{ evento.fecha_fin.substr(10) }}</td>
                <td><strong>@{{evento.concepto}}</strong></td>
                <td>@{{evento.tipo_cita}}</td>
                <td><button class="btn btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button></td>
              </tr>
            </tbody>
            </table>

            <h3 v-if="eventos.length == 0">No hay eventos agendados para este día</h3>

            <!--
            <div class="row d-flex justify-content-center" style="margin-top:50px">
              <div class="col-md-3 mb-4">
                <button class="btn btn-success btn-lg" style="width: 100%;" @click="nuevoEvento"><i class="fas fa-calendar-week"></i> Nueva Cita</button>
              </div>
              <div class="col-md-3 mb-4">
                <button class="btn btn-action btn-lg" style="width: 100%;" @click="imprimir(1)"><i class="fas fa-print"></i> Imprimir</button>
              </div>
              <div class="col-md-3 mb-4">
                <button class="btn btn-action btn-lg" style="width: 100%;" @click="imprimir"><i class="fas fa-user-shield"></i> Alcalde</button> 
              </div>
              <div class="col-md-3 mb-4">
                <button class="btn btn-primary btn-lg" style="width: 100%;" @click="imprimir"><i class="fas fa-user-friends"></i>  Representación</button> 
              </div>
            </div>

            <div class="row">
              <div class="col">

                <button @click="imprimir(2)"  class="btn btn-primary">Imprimir Semanal</button>
              </div>
              <div class="col"></div>
            </div> -->

            <div class="row mt-4" style="margin-top: 60px!important;">
              <div class="col">
                <button class="btn btn-success btn-lg" style="width: 100%;" @click="nuevoEvento"><i class="fas fa-calendar-plus"></i> Nueva Cita</button>
              </div>
              <div class="col">
                <select name="" id="" v-model="opcion" class="form-control btn-lg">
                  <option value="0">Diaria</option>
                  <option value="1">Semanal</option>
                </select>
              </div>
              <div class="col">
                <select name="" id="" v-model="tipo" class="form-control btn-lg">
                  <option value="0">Todos</option>
                  <option value="1">Alcalde</option>
                  <option value="2">Representación</option>
                </select>
              </div>
              <div class="col">
                <button class="btn btn-primary btn-lg" style="width: 100%;" @click="imprimir(1)"><i class="fas fa-print"></i> Imprimir</button>
              </div>
            </div>

          </div>
          
        </div>

          <!--<p>@{{$data}}</p>-->
          
          
    </main>
  </div>
</div>


</div>

    <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  

@endsection