@extends('layouts.print')

@section('content')
<div>
    @foreach($fechas as $fecha => $eventos)
    <div class="dia-title mt-3 p-1">{{ dtformat($fecha, "l d 'de' F 'de' Y")}}</div>

        @forelse($eventos as $evento)

            @if ($evento->tipo_cita == "privada" && !$admin_mode)
                <div class="evento privado mb-3 ps-1">
                    <div class="d-flex mb-2">
                        <div class="col-1 time">{{ dtformat($evento->fecha_inicio, "H:i") }}</div>
                        <div class="col title">CITA PRIVADA</div>
                    </div>
                </div>
            @else
                <div class="evento mb-3 ps-1">
                    <div class="d-flex mb-1">
                        @if ($admin_mode)
                        <div class="col-2 type">{{ mb_strtoupper($evento->tipo_cita) }}</div>
                        @endif
                        <div class="col-1 time">{{ dtformat($evento->fecha_inicio, "H:i") }}</div>
                        <div class="col title">{{ $evento->concepto }}</div>
                    </div>

                    <div class="d-flex mb-1">
                        @if ($admin_mode)
                        <div class="col-2"></div>
                        @endif
                        <div class="col-1 label">Asunto</div>
                        <div class="col">{{ $evento->asunto }}</div>
                    </div>

                    <div class="d-flex mb-1">
                        @if ($admin_mode)
                        <div class="col-2"></div>
                        @endif
                        <div class="col-1 label">Lugar</div>
                        <div class="col">{{ $evento->lugar }}</div>
                    </div>

                    <div class="d-flex mb-1">
                        @if ($admin_mode)
                        <div class="col-2"></div>
                        @endif
                        <div class="col-1 label">Atiende</div>
                        <div class="col">{{ $evento->atiende }}</div>
                    </div>

                    <div class="d-flex mb-1">
                        @if ($admin_mode)
                        <div class="col-2"></div>
                        @endif
                        <div class="col-1 label">Asiste</div>
                        <div class="col">{{ $evento->asiste }}</div>
                    </div>

                    @if ($admin_mode || false)
                        @if ($evento->contacto)
                        <div class="d-flex mb-1">
                            <div class="offset-2 col-1 label">Contactoss</div>
                            <div class="col">{{ $evento->contacto }}</div>
                        </div>
                        @endif

                        @if ($evento->observaciones)
                        <div class="d-flex mb-1">
                            <div class="offset-2 col-1 label">Observsss.</div>
                            <div class="col">{{ $evento->observaciones }}</div>
                        </div>
                        @endif
                    @endif
                </div>
            @endif

        @empty
            <div class="text-center text-muted p-2">No hay Eventos</div>
        @endforelse

    @endforeach
</div>
@endsection