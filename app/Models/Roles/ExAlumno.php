<?php

namespace App\Models\Roles;

use App\Models\Instituciones\Institucion;
use Illuminate\Database\Eloquent\Model;

class ExAlumno extends Model
{
    protected $table = 'ex_alumnos';
    protected $fillable = [
        'alumno_id',
        'institucion_id',
        'ciclo_lectivo_id',
        'division_id',
        'abandono',
        'comentario',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
