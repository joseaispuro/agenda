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
        	padding: 2px;
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
        h2{
            background: #e6e6e6;
            font-size: 15px;
            padding: 3px;
            
        }

        span.mark{
            font-weight: bolder;

        }

        div.barra{
            height: 1px;
            widows: 100%;
            background: #e6e6e6;
        }
        p.descripcion{
            line-height: 20px;
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
                    <p style="font-size:13px">Agenda Semanal del {{$semana['inicio']}} al {{$semana['fin']}}</p>
                </td>
                <td style="width: 10%;"><p style="text-align: right; font-size: 12px;"><small>Impreso el {{date('d-m-Y h:i:s a')}}</small> <br> <small>Usuario: {{Auth::user()->name}}</small></p>
                </td>
            </tr>
        </table>
        <hr>
        <div class="contenido">
              @if(count($semana) == 0)
                    <h2 style="text-align:center; font-size: 18px; color: gray; margin-top: 45px;">No hay eventos registrados para este día</h2>
              @endif
            

        	@foreach($semana['dias'] as $dia)
                                   
                   <div style="display: block; page-break-inside:avoid; margin-bottom:20px">

                   <h2>{{$dia['fecha_abreviada']}}</h2>

                   @if(count($dia['eventos']) == 0)
                    <p>No hay eventos agendados para este día</p>
                   @endif

        	       @foreach($dia['eventos'] as $evento)
                   <p class="descripcion"><strong>{{substr($evento->fecha_inicio, 10)}}</strong> - {{$evento->concepto}} <br> {{$evento->asunto}} <br> <span class="mark">Tipo </span> {{strtoupper($evento->tipo_cita)}} &nbsp;&nbsp; <span class="mark">Lugar</span> {{$evento->lugar}} 

                   <div class="barra"></div>
                  </p>
                   @endforeach
                   </div>
                 
        	@endforeach
        </div>
    </body>
</html>