<?php

namespace App\Services\Division;

use App\Models\Estructuras\Division;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;

class ObtenerFormaEvaluacion
{
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

    public function find($id)
    {
        return FormaEvaluacion::select('nombre')->findOrFail($id);
    }
}