<?php

namespace App\Repositories\Docentes;

use App\Models\Roles\Docente;
use App\Models\User;

class DocenteRepository
{
    public function get($institucion_id)
    {
        return Docente::where('institucion_id', $institucion_id)
            ->select('id')
            ->addSelect(
                ['name' => User::select('name')
                    ->whereColumn('id', 'user_id')
                    ->limit(1)
                ])
            ->get();
    }
}