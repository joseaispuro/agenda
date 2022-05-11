
@extends('layouts.app')

@section('title', 'Agenda Municipal')

@push('styles')
    <link href="{{ asset('css/evento.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{asset('js/evento.js')}}"></script>
@endpush

@section('content')
@{{$data}}
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
            <a class="nav-link active" aria-current="page" href="{{url('/evento')}}">
              <i class="fas fa-calendar-week"></i>
              Evento
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/reportes')}}">
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
        </ul>
      -->
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

          <h2 class="text-center"> @{{(edicion) ? 'Modificar Evento' : 'Nuevo Evento'}}</h2>
            <div class="row mb-4 d-flex justify-content-center">
              <div class="col-md-2">
                <button class="btn btn-action btn-lg" style="width: 100%;"  v-bind:class="{ desactivado: edicion }"  @click="anteriorDia"><i class="fas fa-arrow-alt-circle-left"></i></button>
              </div>
              <div class="col-md-4">
                <p class="fecha">@{{fechaLetra}}</p>
              </div>
              <div class="col-md-2">
                <button class="btn btn-action btn-lg" style="width: 100%;"  v-bind:class="{ desactivado: edicion }"  @click="siguienteDia"><i class="fas fa-arrow-alt-circle-right"></i></button>
              </div>
            </div>

            <div class="row mb-3 d-flex justify-content-center">
              <div class="col-md-2">
                <h6>Fecha</h6>
                <input type="date" v-model="fecha" class="form-control">
              </div>
              <div class="col-md-2">
                <h6>Hora Inicial</h6>
                <input type="time" name="hora" class="form-control" v-model="hora" max="24:00:00" min="10:00:00" step="1">
              </div>
              <div class="col-md-2">
                <h6>Hora Final</h6>
                <input type="time" name="horaFinal" class="form-control" v-model="horaFinal" max="24:00:00" min="10:00:00" step="1">
              </div>
              <div class="col-md-2">
                <h6>Tipo de Cita</h6>
                <div class="invalido" v-show="errors.tipoCita">@{{errors.tipoCita}}</div>
                <select class="form-select" v-model="tipoCita" aria-label="Default select example">
                  <option value="0" selected>Seleccione</option>
                  <option value="invitacion">Invitación</option>
                  <option value="publica">Pública</option>
                  <option value="privada">Privada</option>
                </select>
            </div>
            </div>

            <div class="row mb-3 d-flex justify-content-center">
              <div class="col-md-8">
                <label for="concepto" class="form-label"><strong>Concepto</strong></label>
                <input type="text" class="form-control"  :class="{'is-invalid': errors.concepto}"  id="concepto"  v-model="concepto" placeholder="">
                <div class="invalid-feedback" v-show="errors.concepto">@{{errors.concepto}}</div>
              </div>
          </div>

          <div class="row mb-3 d-flex justify-content-center">
            <div class="col-md-8">
              <label for="asunto" class="form-label"><strong>Asunto</strong></label>
              <textarea class="form-control" v-model="asunto" :class="{'is-invalid': errors.asunto}" id="asunto" rows="2"></textarea>
              <div class="invalid-feedback" v-show="errors.asunto">@{{errors.asunto}}</div>
            </div>
          </div>

          <div class="row mb-3 d-flex justify-content-center">
            <div class="col-md-8">
              <h6>Lugar</h6>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" v-model="lugarAtiende" value="1" name="lugarAtiende">
                <label class="form-check-label" for="lugarAtiende">
                  Despacho del Alcalde
                </label>
              </div>
              <div class="form-check form-check-inline" >
                <input class="form-check-input" type="radio" v-model="lugarAtiende" value="2" name="lugarAtiende">
                <label class="form-check-label" for="lugarAtiende">
                  Sala de Cabildo
                </label>
              </div>

              <div class="mb-3">
                <textarea class="form-control" :class="{'is-invalid': errors.lugar}" id="lugar"  v-model="lugar" rows="2"></textarea>
                <div class="invalid-feedback" v-show="errors.asunto">@{{errors.asunto}}</div>
              </div>
            </div>

          </div>
          
          <div class="row mb-3 d-flex justify-content-center">
            <div class="col-md-8">
              <h5>¿Quién atiende?</h5>
              <div class="invalido" v-show="errors.atiendeAlcalde">@{{errors.atiendeAlcalde}}</div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="atiendeAlcalde" value="1" v-model="atiendeAlcalde">
                <label class="form-check-label" for="flexRadioDefault1">
                  Alcalde
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="atiendeAlcalde" value="0" v-model="atiendeAlcalde">
                <label class="form-check-label" for="flexRadioDefault2">
                  Representación
                </label>
              </div>

              <div class="mb-3">
                <textarea class="form-control"   v-model="atiende" :class="{'is-invalid': errors.atiende}" rows="2"></textarea>
                <div class="invalid-feedback" v-show="errors.atiende">@{{errors.atiende}}</div>
              </div>
            </div>
          </div>

          <div class="row mb-3 d-flex justify-content-center">
            <div class="col-md-8">
              <label for="Asiste" class="form-label"><strong>Asiste</strong></label>
              <textarea class="form-control" id="Asiste" rows="1" :class="{'is-invalid': errors.asiste}" v-model="asiste"></textarea>
              <div class="invalid-feedback" v-show="errors.asiste">@{{errors.asiste}}</div>
            </div>
          </div>

          <div class="row mb-3 d-flex justify-content-center">
            <div class="col-md-8">
              <label for="contacto" class="form-label"><strong>Contacto</strong></label>
              <textarea class="form-control"  id="contacto" v-model="contacto" :class="{'is-invalid': errors.contacto}" rows="1"></textarea>
              <div class="invalid-feedback" v-show="errors.contacto">@{{errors.contacto}}</div>
            </div>
          </div>

          <div class="row mb-3 d-flex justify-content-center">
            <div class="col-md-8">
              <label for="observaciones"class="form-label"><strong>Observaciones</strong></label>
              <textarea class="form-control"  id="observaciones" v-model="observaciones" rows="3"></textarea>
            </div>
          </div>

          <div class="row d-md-flex justify-content-center">
            <div class="col-md-8 mb-3">
              <button type="button" class="btn btn-lg btn-action" id="boton" @click="grabarEvento"> <i class="fas fa-save"></i> Guardar Evento</button>
            </div>
          </div>
          
    </main>
  </div>

@endsection