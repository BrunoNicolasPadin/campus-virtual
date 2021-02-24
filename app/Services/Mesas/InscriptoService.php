<?php

namespace App\Services\Mesas;

use App\Models\Deudores\Anotado;
use App\Models\Roles\Alumno;
use App\Models\User;

class InscriptoService
{
    public function find($id)
    {
        return Anotado::select('anotados.id', 'users.name')
            ->where('anotados.id', $id)
            ->join('alumnos', 'alumnos.id', 'anotados.alumno_id')
            ->join('users', 'users.id', 'alumnos.user_id')
            ->first();
    }
}

    