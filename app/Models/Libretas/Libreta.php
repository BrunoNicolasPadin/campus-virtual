<?php

namespace App\Models\Libretas;

use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use Illuminate\Database\Eloquent\Model;

class Libreta extends Model
{
    protected $table = 'libretas';
    protected $fillable = [
        'alumno_id',
        'ciclo_lectivo_id',
        'asignatura_id',
        'periodo',
        'calificacion',
    ];

    public function cicloLectivo()
    {
        return $this->belongsTo(CicloLectivo::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
