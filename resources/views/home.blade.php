
@extends('layouts.app')

@section('title', 'Agenda Municipal')

@push('styles')
    <link href="{{ asset('css/home.css').'?v='.env('ASSETS_CACHE') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{asset('js/home.js').'?v='.env('ASSETS_CACHE')}}"></script>
@endpush

@section('content')

  <div class="row pb-5">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{url('/admin')}}">
              <i class="fas fa-home"></i>
              Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{url('/admin/evento')}}">
              <i class="fas fa-calendar-week"></i>
              Evento
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/admin/reportes')}}">
              <i class="fas fa-chart-bar"></i>
              Reportes
            </a>
          </li>
        </ul>
        <!--
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
        </ul>-->
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
              <th style="width:160px;">Hora</th>
              <th>Evento</th>
              <th>Tipo</th>
              <th></th>
              <th></th>
            </thead>
            <tbody>
              <tr v-for="evento in eventos">
                <td><i class="fas fa-clock"></i> @{{ evento.fecha_inicio.substr(10) }} a  @{{ evento.fecha_fin.substr(10) }}</td>
                <td><strong>@{{evento.concepto}}</strong></td>
                <td>@{{evento.tipo_cita}}</td>
                <td><button class="btn btn-warning" title="Visualizar"  @click="mostrar(evento.id)"><i class="fas fa-file-alt"></i></button></td>
                <td><button class="btn btn-danger" title="Eliminar"  @click="eliminar(evento.id)"><i class="fas fa-trash-alt"></i></button></td>
              </tr>
            </tbody>
            </table>

            <h3 v-if="eventos.length == 0">No hay eventos agendados para este día</h3>

            <div class="row mt-4" style="margin-top: 60px!important;">
              <div class="col-md-3 col-sm-12">
                <button class="btn btn-success btn-lg" style="width: 100%;" @click="nuevoEvento"><i class="fas fa-calendar-plus"></i> Nueva Cita</button>
              </div>
              <div class="col-md-3 col-sm-12">
                <select name="" id="" v-model="opcion" class="form-control btn-lg">
                  <option value="0">Diaria</option>
                  <option value="1">Semanal</option>
                </select>
              </div>
              <div class="col-md-3 col-sm-12">
                <select name="" id="" v-model="tipo" class="form-control btn-lg">
                  <option value="0">Todos</option>
                  <option value="1">Alcalde</option>
                  <option value="2">Representación</option>
                </select>
              </div>
              <div class="col-md-3 col-sm-12">
                <button class="btn btn-primary btn-lg" style="width: 100%;" @click="imprimir(1)"><i class="fas fa-print"></i> Imprimir</button>
              </div>
            </div>

          </div>

        </div>

          <!--<p>@{{$data}}</p>-->


    </main>
    <div style="position: absolute; bottom: 0.25rem; text-align: center; color: lightgray;">Desarrollado por José Aispuro. Informática Mazatlán.</div>
  </div>

@endsection