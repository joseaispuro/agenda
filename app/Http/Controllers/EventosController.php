<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use Validator;
use Auth;

class EventosController extends Controller
{

    public function guardarEvento(Request $request)
    {

        $usuario = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'asunto' => 'required',
            'concepto' => 'required',
            'lugar' => 'required',
            'atiende' => 'required',
            'asiste' => 'required',
            'contacto' => 'required',
            'atiendeAlcalde' => 'in:1,0',
            'tipoCita' => 'in:invitacion,publica,privada',
        ], ['required' => 'El campo es requerido', 'in' => 'Debe seleccionar una opción']);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Hay errores']);
        }

        if ($request->evento_id) {

            $evento = $request->evento_id;
            $evento = Evento::findOrFail($evento);

            $fecha_inicio = $request->fecha . ' ' . $request->hora;
            $fecha_fin = $request->fecha . ' ' . $request->horaFinal;

            $evento->asunto = $request->asunto;
            $evento->concepto = $request->concepto;
            $evento->tipo_cita = $request->tipoCita;
            $evento->fecha_inicio = $fecha_inicio;
            $evento->fecha_fin = $fecha_fin;
            $evento->atiende = $request->atiende;
            $evento->atiende_alcalde = $request->atiendeAlcalde;
            $evento->lugar = $request->lugar;
            $evento->asiste = $request->asiste;
            $evento->contacto = $request->contacto;
            $evento->user_id = $usuario;
            $evento->observaciones = $request->observaciones;

            $evento->save();
            return response()->json(['respuesta' => true, 'mensaje' => 'Evento modificado exitosamente!']);
        }

        $fecha_inicio = $request->fecha . ' ' . $request->hora;
        $fecha_fin = $request->fecha . ' ' . $request->horaFinal;

        $evento = new Evento;
        $evento->asunto = $request->asunto;
        $evento->concepto = $request->concepto;
        $evento->tipo_cita = $request->tipoCita;
        $evento->fecha_inicio = $fecha_inicio;
        $evento->fecha_fin = $fecha_fin;
        $evento->atiende = $request->atiende;
        $evento->atiende_alcalde = $request->atiendeAlcalde;
        $evento->lugar = $request->lugar;
        $evento->asiste = $request->asiste;
        $evento->contacto = $request->contacto;
        $evento->user_id = $usuario;
        $evento->observaciones = $request->observaciones;

        $evento->save();
        return response()->json(['respuesta' => true, 'mensaje' => 'Evento guardado exitosamente!']);
    }

    public function getEventos(Request $request)
    {

        $fecha = $request->fecha;
        $fechaHasta = $request->fecha_hasta;
        $atiende =  $request->atiende;
        $tipo = $request->tipo;
        $publicado = 'false';

        if ($fechaHasta == null) {
            $eventos = Evento::whereDate('fecha_inicio', $request->fecha)->orderBy('fecha_inicio', 'ASC');
            $publicado = Evento::select('publicada', 'fecha_inicio')->whereDate('fecha_inicio', $request->fecha)->first();
        } else {
            $eventos = Evento::whereBetween('fecha_inicio', [$fecha . " 00:00:00", $fechaHasta . " 23:59:59"])->orderBy('fecha_inicio', 'ASC');
        }

        if ($atiende == 1) {
            $eventos->where('atiende_alcalde', 1);
        }

        if ($atiende == 2) {
            $eventos->where('atiende_alcalde', 0);
        }

        if ($tipo) {
            $eventos->where('tipo_cita', $tipo);
        }


        return response()->json(['eventos' => $eventos->get(), 'publicado' => $publicado]);
    }

    public function mostrarHome()
    {

        /*$fecha = date('Y-m-d');

        $dias = ['', 'Lunes', 'Martes', 'Miércoles', 'Jueves','Viérnes', 'Sábado', 'Domingo'];
        $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $dia = $dias[date('N')];
        $fecha_letra = 'Hoy es ' . $dia . date('d') . ' de ' .  $meses[date('n')] . ' de ' . date('Y');
*/

        return view('home');
    }


    public function getEvento(Request $request)
    {
        $evento = Evento::where('id', $request->id)->with('user')->first();
        return $evento;
    }

    public function imprimir(Request $request)
    {

        //Agenda diaria
        if ($request->opcion == 0) {

            $fecha = $request->fecha;
            $eventos = Evento::whereDate('fecha_inicio', $fecha)->orderBy('fecha_inicio', 'ASC');

            if ($request->tipo == 1 || $request->tipo == 2) {
                if ($request->tipo == 1) {
                    $eventos->where('atiende_alcalde', 1);
                }

                if ($request->tipo == 2) {
                    $eventos->where('atiende_alcalde', 0);
                }
            }

            $eventos = $eventos->get();

            return view("print", [
                "alcalde" => env('NOMBRE_ALCALDE'),
                "titulo" => "Agenda del Día",
                "admin_mode" => true,
                "fechas" => [$fecha => $eventos]
            ]);
        }


        //Agenda Semanal
        if ($request->opcion == 1) {

            $fecha = $request->fecha;
            $dias = $this->getSemana($fecha);

            //return $dias;

            //Ordena los días de la semana
            usort($dias, function ($a, $b) {
                return strtotime($a) - strtotime($b);
            });

            $semana = [];

            //Inicio y fin de la semana
            // $inicio = $this->fechaAbrev($dias[0]);
            // $fin = $this->fechaAbrev($dias[count($dias) - 1]);

            foreach ($dias as $dia) {
                $query = Evento::whereDate('fecha_inicio', $dia)->orderBy('fecha_inicio', 'ASC');

                if ($request->tipo == 1) {
                    $query->where('atiende_alcalde', 1);
                }
                if ($request->tipo == 2) {
                    $query->where('atiende_alcalde', 0);
                }
                $semana[$dia] = $query->get();
            }

            return view("print", [
                "alcalde" => env('NOMBRE_ALCALDE'),
                "titulo" => "Agenda Semanal",
                "admin_mode" => true,
                "fechas" => $semana
            ]);
        }
    }

    public function generar(Request $request)
    {
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        $tipo = $request->tipo;
        $atiende = $request->atiende;

        $eventos = Evento::whereBetween('fecha_inicio', [$fecha_inicio . " 00:00:00", $fecha_fin . " 23:59:59"])
            ->orderBy('fecha_inicio', 'ASC');

        if ($tipo != "0") {
            $eventos->where('tipo_cita', $tipo);
        }

        if ($atiende == "1") {
            $eventos->where('atiende_alcalde', $atiende);
        }

        if ($atiende == "2") {
            $eventos->where('atiende_alcalde', 0);
            // $nombre_alcalde = "";
        }

        $eventos = $eventos->get();
        $fechas = $eventos->groupBy(fn($item) => dtformat($item->fecha_inicio));

        return view("print", [
            "alcalde" => env('NOMBRE_ALCALDE'),
            "titulo" => "Reporte de Agenda del ".dtformat($fecha_inicio, "d/M/Y")." al ".dtformat($fecha_fin, "d/M/Y"),
            "admin_mode" => true,
            "fechas" => $fechas
        ]);
    }

    //Recibe una fecha y retorna los dias que pertenecen a esa semana
    public function getSemana($fecha)
    {

        $diaActual = date('N', strtotime($fecha));

        $dias[] = $fecha;

        $diasAdelante = 7 - $diaActual;
        $diasAtras = $diaActual - 1;

        $fecha_actual = date($fecha);
        if ($diasAtras > 0) {
            for ($c = 0; $c < $diasAtras; $diasAtras--) {
                $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "- 1 day"));
                $dias[] = $fecha_actual;
            }
        }

        $fecha_actual = date($fecha);
        if ($diasAdelante > 0) {
            for ($c = $diaActual + 1; $c <= 7; $c++) {
                $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 day"));
                $dias[] = $fecha_actual;
            }
        }

        return $dias;
    }


    public function updateEventos(Request $request)
    {

        $fecha = $request->fecha;
        $publicado = $request->publicado;

        Evento::whereDate('fecha_inicio', $fecha)->update(['publicada' => $publicado]);

        return response()->json($request);
    }

    public function eliminarEvento(Request $request)
    {

        $evento = Evento::findOrFail($request->evento_id);
        $evento->delete();

        return response()->json(['success' => true, 'msg' => '¡Evento eliminado correctamente!']);
        //return $request->evento_id;
    }


    //Obtiene la fecha en formato descriptivo a partir de una fecha dada
    public function fechaLetra($fecha)
    {

        $diaLetra = date('w', strtotime($fecha));
        $mes = date('n', strtotime($fecha));
        $day = date('d', strtotime($fecha));
        $year = date('Y', strtotime($fecha));

        $meses = ['0', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];

        return $dias[$diaLetra] . ' ' . $day . ' de ' . $meses[$mes] . ' de ' . $year;
    }

    //Fecha descriptiva formato corto
    public function fechaAbrev($fecha)
    {

        $diaLetra = date('w', strtotime($fecha));
        $mes = date('n', strtotime($fecha));
        $day = date('d', strtotime($fecha));

        $meses = ['0', 'Ene', 'Feb', 'Mar', 'Abr', 'Mayo', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viérnes', 'Sábado'];

        return $dias[$diaLetra] . ', ' . $day . ' de ' . $meses[$mes];
    }
}
