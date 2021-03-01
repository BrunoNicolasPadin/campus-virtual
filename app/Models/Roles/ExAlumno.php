<?php

namespace App\Models\Roles;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Instituciones\Institucion;
use Illuminate\Database\Eloquent\Model;

class ExAlumno extends Model
{
    protected $table = 'ex_alumnos';
    protected $fillable = [
        'abandono',
        'finalizo',
        'cambio',
        'comentario',
    ];
    protected $guarded = [
        'alumno_id',
        'institucion_id',
        'ciclo_lectivo_id',
        'division_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function ciclo_lectivo()
    {
        return $this->belongsTo(CicloLectivo::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
