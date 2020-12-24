<?php

namespace App\Models\Asignaturas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturaHorario extends Model
{
    protected $table = 'asignaturas_docentes';
    protected $fillable = [
        'asignatura_id',
        'dia',
        'horaDesde',
        'horaHasta',
    ];
}
