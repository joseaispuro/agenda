<?php


function dtformat($date, $format = 'Y-m-d')
{
    if ($format == 'auto') {
        return dtformat_auto($date);
    }

    $DAYS = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    $MONTHS = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    /*
        TOKENS PARA EL FORMATO DE FECHA
        (BASADOS EN LA FUNCION FORMAT DE PHP)
    */
    $TOKENS = [
        /*
            DIA
        */
        // Día del mes, 2 dígitos (01 - 31)
        'd' => fn($dt) => str_pad($dt['mday'], 2, 0, STR_PAD_LEFT),
        // Nombre del día de la semana, 3 letras (Dom - Sáb)
        'D' => fn($dt) => substr($DAYS[$dt['wday']], 0, 3),
        // Día del mes, sin ceros (1 - 31)
        'j' => fn($dt) => $dt['mday'],
        // Nombre del día de la semana (Domingo - Sábado)
        'l' => fn($dt) => $DAYS[$dt['wday']],
        // Número del día de la semana (0 [Domingo] - 6 [Sábado])
        'w' => fn($dt) => $dt['wday'],

        /*
            MES
        */
        // Nombre del mes (Enero - Diciembre)
        'F' => fn($dt) => $MONTHS[$dt['mon'] - 1],
        // Número del mes, 2 dígitos (01 - 12)
        'm' => fn($dt) => str_pad($dt['mon'], 2, 0, STR_PAD_LEFT),
        // Nombre del mes, 3 letras (Ene - Dic)
        'M' => fn($dt) => substr($MONTHS[$dt['mon'] - 1], 0, 3),
        // Número del mes, sin ceros (1 - 12)
        'n' => fn($dt) => $dt['mon'],

        /*
            AÑO
        */
        // Año, 4 dígitos (2022)
        'Y' => fn($dt) => $dt['year'],
        // Año, 2 dígitos (22)
        'y' => fn($dt) => substr($dt['year'], -2),

        /*
            HORA
        */
        // am/pm, minúscula
        'a' => fn($dt) => $dt['hours'] < 12 ? 'am' : 'pm',
        // AM/PM, mayúscula
        'A' => fn($dt) => $dt['hours'] < 12 ? 'AM' : 'PM',
        // Formato de 12 hrs, sin ceros (1 - 12)
        'g' => fn($dt) => $dt['hours'] == 0 ? 12 : ($dt['hours'] > 12 ? $dt['hours'] - 12 : $dt['hours']),
        // Formato de 24 hrs, sin ceros (0 - 23)
        'G' => fn($dt) => $dt['hours'],
        // Formato de 12 hrs, 2 dígitos (01 - 12)
        'h' => fn($dt) => str_pad($dt['hours'] == 0 ? 12 : ($dt['hours'] > 12 ? $dt['hours'] - 12 : $dt['hours']), 2, 0, STR_PAD_LEFT),
        // Formato de 24 hrs, 2 dígitos (00 - 23)
        'H' => fn($dt) => str_pad($dt['hours'], 2, 0, STR_PAD_LEFT),
        // Minutos, 2 dígitos (00 - 59),
        'i' => fn($dt) => str_pad($dt['minutes'], 2, 0, STR_PAD_LEFT),
        // Segundos, 2 dígitos (00 - 59)
        's' => fn($dt) => str_pad($dt['seconds'], 2, 0, STR_PAD_LEFT),
        // Milisegundos, 3 digitos
        'v' => fn($dt) => date('v', $dt[0]),

        /*
            ZONA HORARIA
        */
        // Diferencia del Meridiano de Greenwich (GMT) sin dos puntos (-0700)
        'O' => fn($dt) => date('O', $dt[0]),
        // Diferencia del Meridiano de Greenwich (GMT) con dos puntos (-07:00)
        'P' => fn($dt) => date('P', $dt[0]),

        /*
            FECHA/HORA COMPLETA
        */
        // Formato ISO 8601 (2020-02-12T15:19:21+00:00)
        'c' => fn($dt) => dtformat($dt[0], "Y-m-d'T'H:i:sP"),
        // Formato RFC 2822 (Jue, 21 Dic 2000 16:01:07 +0200)
        'r' => fn($dt) => dtformat($dt[0], "D, d M Y H:i:s O"),
        // Segundos transcurridos desde 1970-01-01 00:00:00
        'U' => fn($dt) => $dt[0],

    ];


    $date = getdate(dtparse($date));
    $literal = [];

    // Respaldo de texto literal (entre comillas dentro del string, no se interpreta)
    $format = preg_replace_callback("/(['\"])([^\\1]*?)\\1/", function ($m) use (&$literal) {
        array_push($literal, $m[2]);
        return '{{'.(count($literal) - 1).'}}';
    }, $format);
    // Reemplazo de tokens
    $format = preg_replace_callback("/(".implode('|', array_keys($TOKENS)).")/", function ($m) use ($TOKENS, $date) {
        return $TOKENS[$m[0]]($date);
    }, $format);
    // Restaurar texto literal
    $format = preg_replace_callback("/{{(\\d+)}}/", function ($m) use ($literal) {
        return $literal[$m[1]];
    }, $format);


    return $format;
}

/*
    FUNCION DE FORMATO DE FECHA DINÁMICO
*/
function dtformat_auto($date) {
    $dt = getdate(dtparse($date));
    $now = getdate();
    $format = '';

    if ($dt['year'] == $now['year']) { // Mismo año

        if ($dt['mon'] == $now['mon']) { // Mismo mes

            if ($dt['mday'] == $now['mday']) { // Mismo día
                $diff = ($now[0] - $dt[0]);

                if (abs($diff) < 60) { // <1 min
                    $format = "'Ahorita'";

                } else if (abs($diff) < 3600) { // <1 Hora
                    $format = ($diff > 0 ? "'Hace' " : "'En' ") . intval(abs(round($diff / 60))) . " 'min.'";

                } else {
                    $format = "'Hoy' g:i a"; // La hora del dia
                }

            } else { // Otro dia
                $diff = $now['mday'] - $dt['mday'];

                if (abs($diff) == 1) { // 1 día
                    $format = ($diff > 0 ? "'Ayer'" : "'Mañana'") . " g:i a";

                } else if (abs($diff) < 7) { // <1 semana
                    $format = "l j";

                } else {
                    $format = "j/M"; // El mes y el dia
                }
            }

        } else { // Otro mes
            $format = "j/M"; // El mes y el dia
        }

    } else { // Otro año
        $format = 'd/M/Y'; // La fecha corta
    }

    return dtformat($date, $format);
};

function dtparse($date) {
    if (is_a($date, \DateTime::class)) {
        return $date->getTimestamp();
    }
    if (is_string($date)) {
        return strtotime($date);
    }
    return $date;
}
