<?php

namespace App\Services\Division;

use App\Models\Estructuras\Curso;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\Nivel;
use App\Models\Estructuras\Orientacion;

class DivisionService
{
    public function get($institucion_id)
    {
        return Division::where('institucion_id', $institucion_id)
        ->select('id', 'division', 'forma_evaluacion_id')
        ->addSelect(
            ['nivel_nombre' => Nivel::select('nombre')
                ->whereColumn('id', 'nivel_id')
                ->limit(1)
            ])
        ->addSelect(
            ['orientacion_nombre' => Orientacion::select('nombre')
                ->whereColumn('id', 'orientacion_id')
                ->limit(1)
            ])
        ->addSelect(
            ['curso_nombre' => Curso::select('nombre')
                ->whereColumn('id', 'curso_id')
                ->limit(1)
            ])
        ->orderBy('nivel_id')
        ->orderBy('orientacion_id')
        ->orderBy('curso_id')
        ->orderBy('division')
        ->get();
    }

    public function find($id)
    {
        return Division::select('id', 'division', 'forma_evaluacion_id')
        ->addSelect(
            ['nivel_nombre' => Nivel::select('nombre')
                ->whereColumn('id', 'nivel_id')
                ->limit(1)
            ])
        ->addSelect(
            ['orientacion_nombre' => Orientacion::select('nombre')
                ->whereColumn('id', 'orientacion_id')
                ->limit(1)
            ])
        ->addSelect(
            ['curso_nombre' => Curso::select('nombre')
                ->whereColumn('id', 'curso_id')
                ->limit(1)
            ])->findOrFail($id);
    }
}