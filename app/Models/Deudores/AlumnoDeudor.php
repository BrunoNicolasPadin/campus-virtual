<?php

namespace App\Models\Deudores;

use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Roles\Alumno;
use Illuminate\Database\Eloquent\Model;

class AlumnoDeudor extends Model
{
    protected $table = 'alumnos_deudores';
    protected $fillable = [
        'alumno_id',
        'asignatura_id',
        'ciclo_lectivo_id',
        'aprobado',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function ciclo_lectivo()
    {
        return $this->belongsTo(CicloLectivo::class);
    }
}
