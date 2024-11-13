
@extends('layouts.app')

@section('title', 'Agenda Municipal')

@push('styles')
    <link href="{{ asset('css/home.css').'?v='.env('ASSETS_CACHE') }}" rel="stylesheet">
@endpush


@push('scripts')
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/reportes.js').'?v='.env('ASSETS_CACHE')}}"></script>
@endpush


@section('content')

  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{url('/admin')}}">
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
            <a class="nav-link active" href="{{url('/admin/reportes')}}">
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
          <h2 class="text-center"> Reportes</h2>
         <div class="row mb-3  d-flex justify-content-center encabezado">

            <div class="row col-md-10">
              <div class="col-md-3">
                <label for=""><strong>Fecha Inicio</strong></label>
                <input type="date" class="form-control" v-model="fecha_inicio">
              </div>
              <div class="col-md-3">
                <label for=""><strong>Fecha Fin</strong></label>
                <input type="date" class="form-control" v-model="fecha_fin">
              </div>

              <div class="col-md-3">
                <label for=""><strong>Atiende</strong></label>
                <select name="atiende" v-model="atiende" id="" class="form-control">
                  <option value="0">Todo</option>
                  <option value="1">Presidenta</option>
                  <option value="2">Representación</option>
                </select>
              </div>

              <div class="col-md-3">
                <label for=""><strong>Tipo</strong></label>
                <select name="tipo" v-model="tipo" class="form-control">
                  <option value="0">Todo</option>
                  <option value="publica">Pública</option>
                  <option value="privada">Privada</option>
                  <option value="invitacion">Invitación</option>
                </select>
              </div>
            </div>

            <div class="row col-md-10 justify-content-end">

              <div class="col-md-2 mb-2 mt-3">
                <div class="d-grid gap-2">
                  <button class="btn btn-primary btn-block" @click="visualizar"><i class="fas fa-list-ol"></i> Visualizar</button>
                </div>
              </div>

              <div class="col-md-2 mb-2 mt-3">
                <div class="d-grid gap-2">
                  <button class="btn btn-success" @click="generar"><i class="fas fa-print"></i> Imprimir</button>
                </div>
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


@endsection