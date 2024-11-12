
@extends('layouts.app')

@section('title', 'Agenda Municipal')

@push('styles')
    <link href="{{ asset('css/usuarios.css').'?v='.env('ASSETS_CACHE') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{asset('js/usuarios.js').'?v='.env('ASSETS_CACHE')}}"></script>
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
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <div class="row mt-2">
        <div class="col-md-8">

          <h3>Listado de Usuarios</h3>

          <table class="table table-striped">
            <thead>
              <tr> 
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Usuario</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr  v-for="(usuario, index) in usuarios" :key="usuario.id" :class="usuario.deleted_at != null ? 'eliminado': ''">
                <th scope="row">@{{index+1}}</th>
                <td>@{{usuario.name}}</td>
                <td>@{{usuario.user}}</td>
                <td>@{{usuario.email}}</td>
                <td>   

                  <div v-if="usuario.deleted_at == null">
                  <div class="btn-group" role="group" aria-label="Basic example">
                    <button @click="modificar(usuario)" class="btn btn-primary  btn-sm" title="Modificar"> <i class="fas fa-edit"></i> </button>
                   
                  </div>

                  <div class="btn-group mr-4" style="margin-left:6px;" role="group" aria-label="Basic example">
                    <button v-if="usuario.id > 1" @click="eliminar(usuario.id)" class="btn btn-danger  btn-sm  " title="Dar de baja"> <i class="fas fa-user-slash"></i> </button>
                  </div>
                  </div>

                  
                </td>
              </tr>


            </tbody>
          </table>
        </div>
      
        <div class="col-md-4">
          <h3> @{{(usuario.id > 0) ? 'Modificar Usuario' : 'Nuevo Usuario'}}</h3>

          <div class="row mt-2">
            <label for="">Nombre</label>
            <input class="form-control form-control-sm" :class="{'is-invalid': errors.name}"  v-model="usuario.name" type="text" placeholder="Nombre">
            <div class="invalid-feedback" v-if="errors.name">@{{errors.name[0]}}</div>
          </div>
          
          <div class="row mt-2">
            <label for="">Usuario</label>
            <input class="form-control form-control-sm" v-model="usuario.user" type="text" placeholder="Usuario" :class="{'is-invalid': errors.user}">
            <div class="invalid-feedback" v-if="errors.user">@{{errors.user[0]}}</div>
          </div>

          <div class="row mt-2">
            <label for="">Contraseña <small style="color: #ff5722">@{{(usuario.id > 0) ? '(Deje en blanco si no quiere modificar)' : ''}}</small></label>
            <input class="form-control form-control-sm" v-model="usuario.password" type="text" placeholder="Contraseña" :class="{'is-invalid': errors.password}">
            <div class="invalid-feedback" v-if="errors.password">@{{errors.password[0]}}</div>
          </div>

          <div class="row mt-2">
            <label for="">Email</label>
            <input class="form-control form-control-sm" v-model="usuario.email" type="text" placeholder="Correo" :class="{'is-invalid': errors.email}">
            <div class="invalid-feedback" v-if="errors.email">@{{errors.email[0]}}</div>
          </div>

          <div class="row mt-4">
            <button style="width: 48%; margin:1%;" class="btn btn-secondary btn-sm mb-2" @click="limpiarDatos">Limpiar</button>
            <button style="width: 48%; margin:1%;" class="btn btn-success btn-sm mb-2" @click="guardarUsuario">Guardar</button>
          </div>

          
        </div>

      </div>
      
  

          <!--<p>@{{$data}}</p>-->


    </main>
  </div>

@endsection