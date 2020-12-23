<?php

namespace App\Models\Estructuras;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisiones';
    protected $fillable = [
        'institucion_id',
        'nivel_id',
        'orientacion_id',
        'curso_id',
        'division',
        'periodo_id',
        'claveDeAcceso',
    ];
}
