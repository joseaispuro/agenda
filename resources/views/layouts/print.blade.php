<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda del Alcalde - H. Ayuntamiento de Mazatlán</title>
    <link href="{{asset('lib/bootstrap.css').'?v='.env('ASSETS_CACHE')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/print.css').'?v='.env('ASSETS_CACHE')}}" rel="stylesheet" type="text/css" />
    @stack('styles')
</head>

<body>
    <div class="page">
        <div class="header d-flex bg-primary text-white py-2 px-3 mb-3">
            <div class="col">
                <img class="logo" src="{{asset('img/logo-horiz-white.png')}}">
            </div>
            <div class="flex-fill text-end">
                <h1 class="mb-1">Agenda del Gobierno Municipal</h1>
                <h2 class="mb-2">{{ $alcalde }}</h2>
                <h3 class="mb-0">{{ $titulo }}</h3>
            </div>
        </div>

        <div class="agenda-content">
            @yield('content')
        </div>

        <div class="footer fw-semibold text-center p-4">
            <div>{{ url('')}}</div>
            <div>Impreso el {{ dtformat(now(), "l d 'de' F, h:i a") }}</div>
        </div>
    </div>
</body>
</html>