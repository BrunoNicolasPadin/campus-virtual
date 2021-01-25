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
        'activado',
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
