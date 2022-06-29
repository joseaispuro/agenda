<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EventosController;

use Illuminate\Http\Request;
use App\Models\Evento;

class PublicController extends Controller
{
    public function index() {
        //$faker = \Faker\Factory::create('es_ES');

        $eventosController = new EventosController();

        $fecha = date('Y-m-d');

        $fechaLetra = $eventosController->fechaLetra($fecha);
        $fechaLetra = explode(' ', $fechaLetra);

        $eventos = Evento::whereDate('created_at', $fecha.' 00:00:00')->where('publicada',1)->orderBy('fecha_inicio', 'ASC')->get();

        //Elimino datos en caso de ser cita privada
        foreach($eventos as $evento){
            if($evento->tipo_cita == 'privada'){
                unset($evento->lugar);
                unset($evento->asiste);
                unset($evento->concepto);
                unset($evento->asunto);
                unset($evento->atiende);
                unset($evento->observaciones);
            }

            unset($evento->contacto);
            unset($evento->atiende_alcalde);
        }


        return view('public.index', compact('eventos', 'fecha', 'fechaLetra'));
    }

    public function getEventos(Request $request){

        $fecha = $request->fecha;
        $eventos = Evento::whereDate('fecha_inicio', $request->fecha)->where('publicada', 1)->orderBy('fecha_inicio', 'ASC')->get();


        //Elimino datos en caso de ser cita privada
        foreach($eventos as $evento){
            if($evento->tipo_cita == 'privada'){
                unset($evento->lugar);
                unset($evento->asiste);
                unset($evento->concepto);
                unset($evento->asunto);
                unset($evento->atiende);
                unset($evento->observaciones);
            }

            unset($evento->contacto);
            unset($evento->atiende_alcalde);
        }
      

        return response()->json(['eventos' => $eventos]);

    }

    public function imprimirPdf(Request $request){

        $fecha = $request->fecha;

        $eventosController = new EventosController();

        $fecha_letra = $eventosController->fechaLetra($fecha);
        $nombre_alcalde = env('NOMBRE_ALCALDE');


        $eventos = Evento::select(['concepto','fecha_inicio', 'publicada', 'asunto', 'lugar', 'atiende', 'asiste','tipo_cita'])->whereDate('fecha_inicio', $request->fecha)->where('publicada', 1)->orderBy('fecha_inicio', 'ASC')->get();

        $pdf = \PDF::loadView('imprimir-pdf', compact('eventos','fecha_letra','nombre_alcalde'));
        return $pdf->download('eventos-'. $fecha .'.pdf');


    }
}
