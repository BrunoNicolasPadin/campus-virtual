<?php

namespace App\Repositories\Deudores;

use App\Models\Deudores\Inscripcion;

class InscripcionRepository
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

    