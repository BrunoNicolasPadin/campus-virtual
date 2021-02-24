<?php

namespace App\Services\Alumnos;

use App\Models\Roles\Alumno;
use App\Models\User;

class AlumnoService
{
    public function find($id)
    {
        return Alumno::select('id', 'division_id')
            ->addSelect(
                ['name' => User::select('name')
                    ->whereColumn('id', 'user_id')
                    ->limit(1)
                ])
            ->findOrFail($id);
    }
}