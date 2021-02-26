<?php

namespace App\Models\Evaluaciones;

use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';
    protected $fillable = [
        'titulo',
        'tipo',
        'fechaHoraRealizacion',
        'fechaHoraFinalizacion',
        'comentario',
    ];
    protected $guarded = [
        'institucion_id',
        'division_id',
        'asignatura_id',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
