<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Agenda del día</title>
        <style>
        body{
            font-family: 'sans-serif;';
        }
        h3{
        	text-transform: uppercase;
        	font-size: 16px;
            padding: 3px;
        }
        h3 span{
        	font-size: 13px;
        }
        .contenido{
       		font-size: 13px;
        }
        h4{
        	background: #e6e6e6;
        	color: black;
        	padding: 3px;
            font-size: 14px;
            margin-top: 12px;
        }
        h4 strong{
            text-transform: uppercase;
        }
        p.evento{
        	margin-bottom: 10px;
            }
        ul{
        	list-style: none;
            margin: 0;
            padding: 0;
        }
        ul li{
            margin: 0 3px;
        }
        h5{
        	margin-bottom: 0px;
        	padding: 4px;
        }
        h5{
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 7px;
            padding:0;
        }

    </style>
    </head>
    <body>

        <table>
            <tr>
                <td style="width: 80px;">
                     <img src="{{asset('img/escudomazatlan.png')}}" alt="">
                </td>
                <td style="width: 420px"> 
                    <h3>Agenda del Alcalde <br> <small>{{$nombre_alcalde}}</small></h3>
                    <p>Agenda para el día {{$fecha_letra}}</p>
                </td>
                <td style="width: 10%;"><p style="text-align: right; font-size: 12px;"><small>Impreso el {{date('d-m-Y h:i:s a')}}</small> <br> <small>Usuario: {{Auth::user()->name}}</small></p>
                </td>
            </tr>
        </table>
        <hr>
        <div class="contenido">
              @if(count($eventos) == 0)
                    <h2 style="text-align:center; font-size: 18px; color: gray; margin-top: 45px;">No hay eventos registrados para este día</h2>
              @endif
            

        	@foreach($eventos as $evento)
        	<p class="evento">


        		<h4>{{$evento->concepto}}   &nbsp;&nbsp;<span> <strong>(Cita {{$evento->tipo_cita}})</strong></span></h4>
        			<h5><i class="fas fa-clock"></i> {{ substr($evento->fecha_inicio, 10) }} a  {{ substr($evento->fecha_fin, 10) }}</h5>
        		<ul>
        			<li>Asunto: <strong>{{$evento->asunto}}</strong></li>
        			<li>Lugar: {{$evento->lugar}}</li>
        			<li>Atiende: {{$evento->atiende}}</li>
        			<li>Asisten: {{$evento->asiste}}</li>
        			<li>Contacto: {{$evento->contacto}}</li>
        			<li>Observaciones: {{$evento->observaciones}}</li>
        		</ul>
        	</p>
        	@endforeach
        </div>
    </body>
</html>