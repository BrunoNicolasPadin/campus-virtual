<?php

namespace App\Models\Libretas;

use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\Periodo;
use App\Models\Roles\Alumno;
use Illuminate\Database\Eloquent\Model;

class Libreta extends Model
{
    protected $table = 'libretas';
    protected $fillable = [];
    protected $guarded = [
        'alumno_id',
        'ciclo_lectivo_id',
        'division_id',
        'asignatura_id',
        'periodo_id',
    ];

    public function cicloLectivo()
    {
        return $this->belongsTo(CicloLectivo::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}
