<?php

namespace App\Services\Mesas;

use App\Models\Deudores\Inscripcion;
use App\Models\Roles\Alumno;
use App\Models\User;

class InscriptoService
{
    public function find($id)
    {
        return Inscripcion::select('inscripciones.id', 'users.name')
            ->where('inscripciones.id', $id)
            ->join('alumnos', 'alumnos.id', 'inscripciones.alumno_id')
            ->join('users', 'users.id', 'alumnos.user_id')
            ->first();
    }
}

    