<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'eventos';

    protected $appends = ['fecha_formateada'];

    public function getFechaFormateadaAttribute()
    {
        return substr($this->attributes['fecha_inicio'], 8, 2) . ' de ' . $this->mes(substr($this->attributes['fecha_inicio'], 5, 2)) . ' de '. substr($this->attributes['fecha_inicio'], 0, 4);
    
    }

    public function mes($mes){

        switch($mes){
            case '01': $mes = 'enero'; break;
            case '02': $mes = 'febrero'; break;
            case '03': $mes = 'marzo'; break; 
            case '04': $mes = 'abril'; break;
            case '05': $mes = 'mayo'; break;
            case '06': $mes = 'junio'; break;
            case '07': $mes = 'julio'; break;
        }

        return $mes;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
