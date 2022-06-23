<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="gibrans64@gmail.com">

    <title>Agenda del Alcalde - H. Ayuntamiento de Mazatlán</title>

    <link rel="stylesheet" href="{{asset('lib/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('lib/fontawesome-free-6.1.1-web/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">

    <script type="module" src="{{asset('js/index.js')}}"></script>
</head>
<body>
    <div class="intro p-5">
        <div class="container-lg col-lg-10 col-xl-9 col-xxl-8">

            <div class="row">
                <div class="col-md-3 mb-4 text-center">
                    <img class="logo" src="{{asset('img/logo-color.png')}}">
                </div>
                <div class="col-md header">
                    <h1 class="title text-primary">AGENDA DEL ALCALDE</h1>
                    <h2 class="title-2 text-muted">H. AYUNTAMIENTO DE MAZATL&Aacute;N 2021-2024</h2>
                </div>
            </div>

            <div class="container col-xl-10 fs-3 my-4 text-center">
                Ent&eacute;rate de las actividades y los lugares a los que estar&aacute; acudiendo nuestro alcalde.
            </div>

        </div>
    </div>

    <div class="content py-5">
        <div class="container-xxl">
            <div class="row justify-content-center align-items-start py-4">

                <!-- fecha -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 pb-5">
                    <div class="fecha card border-info">

                        <span class="arrow prev pointer"><i class="prev fa-solid fa-fw fa-chevron-up"></i></span>
                        <span class="arrow next pointer"><i class="next fa-solid fa-fw fa-chevron-down"></i></span>

                        <div class="card-header text-center">
                            <i class="fa-regular fa-calendar"></i>&nbsp; {{$faker->monthName()}}
                        </div>
                        <div class="click-area card-body text-center pointer">
                            <div class="day-num text-info">{{$faker->dayOfMonth()}}</div>
                            <div class="day-name">{{$faker->dayOfWeek()}}</div>
                        </div>
                        <div class="card-footer p-1">
                            <input type="date" class="pointer" value="{{$faker->date()}}">
                        </div>
                    </div>

                    <div class="actions text-secondary">
                        <button type="button" class="btn btn-lg btn-secondary" title="Descargar PDF">
                            <i class="fa-regular fa-fw fa-file-pdf"></i>
                        </button>
                        <button type="button" class="btn btn-lg btn-secondary" title="Imprimir">
                            <i class="fa-solid fa-fw fa-print"></i>
                        </button>
                    </div>
                </div>

                <!-- eventos -->
                <div class="col-md-9 col-lg-7 mb-4">
                    <?php $count = rand(0, 6); ?>
                    @if ($count > 0)
                        <ul class="list-group">
                            @for($i = 1; $i <= $count; $i++)
                                <?php $privado = rand(0, 10) > 8; ?>
                                <div class="evento list-group-item p-4 {{$privado ? 'privado' : ''}}">

                                    <div class="d-flex">
                                        <div class="hora">
                                            <div>{{$faker->time('g:i')}}</div>
                                            <div class="ampm">{{$faker->time('A')}}</div>
                                        </div>

                                        <div class="evento-titulo col ps-3 {{$privado ? 'border-secondary' : 'border-primary'}}">
                                            @if (!$privado)
                                                <h5 class="card-title mb-3">{{strtoupper($faker->sentence)}}</h5>
                                                <h6 class="card-subtitle text-muted">{{strtoupper($faker->paragraph(2))}}</h6>
                                            @else
                                                <h5 class="card-title">CITA PRIVADA</h5>
                                            @endif
                                        </div>

                                        @if (!$privado)
                                        <div class="text-secondary pointer ps-3">
                                            <i class="fa-solid fa-fw fa-lg fa-share-from-square"></i>
                                        </div>
                                        @endif
                                    </div>

                                    @if (!$privado)
                                    <div class="detalles row col-md-10 mx-auto mt-4 text-center text-primary">
                                        <div class="col-md mb-3">
                                            <div class="text-info mb-1">
                                                <i class="fa-solid fa-user-tie"></i>
                                                <label>ATIENDE</label>
                                            </div>

                                            <div>{{strtoupper($faker->name)}}</div>
                                        </div>
                                        <div class="col-md mb-3">
                                            <div class="text-info mb-1">
                                                <i class="fa-solid fa-people-group"></i>
                                                <label>ASISTEN</label>
                                            </div>

                                            <div>
                                                @for($j = 1; $j <= $faker->numberBetween(1, 10); $j++)
                                                    <div>{{strtoupper($faker->name)}}</div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="col-md mb-3">
                                            <div class="text-info mb-1">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <label>LUGAR</label>
                                            </div>

                                            <div>{{strtoupper($faker->address)}}</div>
                                        </div>
                                    </div>
                                    @endif
                                </div><!-- /evento -->
                            @endfor
                        </ul>
                    @else
                        <div class="card bg-light empty">
                            <div class="card-body py-5">
                                <i class="fa-regular fa-calendar-xmark" style="color: gainsboro"></i>
                                <div>No hay eventos programados</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- twitter -->
                <div class="twitter col-12 col-sm-8 col-lg-3">
                    @include("public.twitter")
                </div>
            </div>

        </div>
    </div>

    <div class="footer bg-primary text-white p-5">
        <div class="container col-md-10">
            <div class="row justify-content-between">
                <div class="col-sm-3 col-lg-2 mb-4 mb-sm-0">
                    <a href="http://mazatlan.gob.mx">
                        <img class="footer-logo" src="{{asset('img/escudo-mazatlan-white.png')}}">
                    </a>
                </div>
                <div class="col-sm-5 col-lg-6 mb-4 mb-sm-0 mt-sm-3 lh-lg">
                    <div class="fw-bold">Presidencia Municipal</div>
                    <div>H. Ayuntamiento de Mazatl&aacute;n</div>
                    <div>Angel Flores S/N, Col. Centro</div>
                    <div>Mazatl&aacute;n, Sinaloa.</div>
                </div>
                <div class="col-sm-4 mb-4 mb-sm-0 mt-sm-3 text-end">
                    <a class="text-white" href="https://www.instagram.com/aytodemzt">
                        <i class="fa-brands fa-fw fa-3x fa-instagram"></i>
                    </a>
                    <a class="text-white" href="https://twitter.com/aytodemzt">
                        <i class="fa-brands fa-fw fa-3x fa-twitter"></i>
                    </a>
                    <a class="text-white" href="https://www.facebook.com/AytodeMzt">
                        <i class="fa-brands fa-fw fa-3x fa-facebook"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
