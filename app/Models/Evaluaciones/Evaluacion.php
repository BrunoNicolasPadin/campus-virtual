<?php

namespace App\Models\Evaluaciones;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';
    protected $fillable = [
        'division_id',
        'asignatura_id',
        'tipo',
        'fechaHoraRealizacion',
        'fechaHoraFinalizacion',
        'comentario',
    ];
}
