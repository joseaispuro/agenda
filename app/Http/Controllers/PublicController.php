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
}
