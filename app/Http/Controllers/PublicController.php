<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EventosController;

use Illuminate\Http\Request;
use App\Models\Evento;

class PublicController extends Controller
{
    public function index() {
        $faker = \Faker\Factory::create('es_ES');

        $eventosController = new EventosController();

        $fecha = date('Y-m-d');

        $fechaLetra = $eventosController->fechaLetra($fecha);
        $fechaLetra = explode(' ', $fechaLetra);

        $eventos = Evento::whereDate('created_at', $fecha.' 00:00:00')->where('publicada',1)->orderBy('fecha_inicio', 'ASC')->get();


        return view('public.index', compact('eventos', 'fecha', 'fechaLetra'));
    }

    public function getEventos(Request $request){

        $fecha = $request->fecha;
        $eventos = Evento::whereDate('fecha_inicio', $request->fecha)->where('publicada', 1)->orderBy('fecha_inicio', 'ASC');
      

        return response()->json(['eventos' => $eventos->get()]);

    }

    public function imprimirPdf(Request $request){

        $fecha = $request->fecha;

        $eventosController = new EventosController();

        $fecha_letra = $eventosController->fechaLetra($fecha);
        $nombre_alcalde = env('NOMBRE_ALCALDE');


        $eventos = Evento::select(['concepto','fecha_inicio', 'publicada', 'asunto', 'lugar', 'atiende', 'asiste'])->whereDate('fecha_inicio', $request->fecha)->where('publicada', 1)->orderBy('fecha_inicio', 'ASC')->get();

        $pdf = \PDF::loadView('imprimir-pdf', compact('eventos','fecha_letra','nombre_alcalde'));
        return $pdf->download('eventos-'. $fecha .'.pdf');


    }
}
