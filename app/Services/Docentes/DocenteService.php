<?php

namespace App\Services\Docentes;

use App\Models\Roles\Docente;
use App\Models\User;

class DocenteService
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