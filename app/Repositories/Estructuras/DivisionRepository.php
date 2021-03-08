<?php

namespace App\Repositories\Estructuras;

use App\Models\Estructuras\Curso;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\Nivel;
use App\Models\Estructuras\Orientacion;

class DivisionRepository
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

    public function obtenerFormaEvaluacion($division_id)
    {
        $division = Division::findOrFail($division_id);
        $formaDescripcion = [];
        $tipo = $division->formaEvaluacion->tipo;

        if ($division->formaEvaluacion->tipo == 'Escrita') {
            $tipo = 'Escrita';
            $formaDescripcion = FormaDescripcion::where('forma_evaluacion_id', $division->forma_evaluacion_id)->get();
        }
        else {

            if ($tipo == 'Numerica') {
                for ($i=1; $i < 11; $i++) { 
                    array_push($formaDescripcion, $i);
                }
            }
            else {
                for ($i=1; $i < 101; $i++) { 
                    array_push($formaDescripcion, $i);
                }
            }
        }
        return [$formaDescripcion, $tipo];
    }
}