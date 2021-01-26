<?php

namespace App\Models\Deudores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoDeudor extends Model
{
    protected $table = 'alumnos_deudores';
    protected $fillable = [
        'alumno_id',
        'asignatura_id',
        'ciclo_lectivo_id',
    ];
}
