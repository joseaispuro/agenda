<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EventosController;

use Illuminate\Http\Request;
use App\Models\Evento;

class PublicController extends Controller
{
    public function index() {
        return view('public.index');
    }

    public function getEventos(Request $request) {
        $eventos = Evento::whereDate('fecha_inicio', $request->fecha)

            /**** ELIMINAR ESTO */
            ->where('user_id', '<>', env('OMITIDO'))
            /**** ELIMINAR ESTO */
            
            ->where('publicada', 1)
            ->orderBy('fecha_inicio', 'ASC')
            ->get()
            ->map(function ($evento) {
                $item = [
                    "id" => $evento->id,
                    "tipo_cita" => $evento->tipo_cita,
                    "fecha_inicio" => $evento->fecha_inicio,
                    "concepto" => $evento->concepto,
                    "asunto" => $evento->asunto,
                    "lugar" => $evento->lugar,
                    "atiende" => $evento->atiende,
                    "asiste" => $evento->asiste
                ];

                // Se quitan datos de cita privada
                if ($evento->tipo_cita == 'privada') {
                    unset($item['concepto']);
                    unset($item['asunto']);
                    unset($item['lugar']);
                    unset($item['atiende']);
                    unset($item['asiste']);
                }

                return $item;
            });

        return response()->json(['eventos' => $eventos]);

    }

    public function imprimir(Request $request) {
        $fecha = $request->get("fecha", today());

        $eventos = Evento::select(['concepto','fecha_inicio', 'publicada', 'asunto', 'lugar', 'atiende', 'asiste','tipo_cita'])

        /**** ELIMINAR ESTO */
            ->where('user_id', '<>', env('OMITIDO'))
        /**** ELIMINAR ESTO */

            ->whereDate('fecha_inicio', $request->fecha)
            ->where('publicada', 1)
            ->orderBy('fecha_inicio', 'ASC')
            ->get();

        return view("print", [
            "alcalde" => env('NOMBRE_ALCALDE'),
            "titulo" => "Agenda del Día",
            "admin_mode" => false,
            "fechas" => [$fecha => $eventos]
        ]);
    }
}
