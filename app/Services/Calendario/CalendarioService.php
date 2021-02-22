<?php

namespace App\Services\Calendario;

class CalendarioService
{
    public function obtenerMeses()
    {
        return ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    }

    public function obtenerEvaluaciones($evaluacion)
    {
        return [
            'id' => $evaluacion['id'],
            'institucion_id' => $evaluacion['institucion_id'],
            'division_id' => $evaluacion['division_id'],
            'titulo' => $evaluacion['titulo'],
            'tipo' => $evaluacion['tipo'],
            'fechaHora' => $evaluacion['fechaHoraRealizacion'],
            'fechaHoraFinalizacion' => $evaluacion['fechaHoraFinalizacion'],
            'asignatura' => $evaluacion['asignatura'],
            'division' => $evaluacion['division'],
        ];
    }

    public function obtenerMesas($mesa)
    {
        return [
            'id' => $mesa['id'],
            'institucion_id' => $mesa['institucion_id'],
            'division_id' => $mesa['asignatura']['division_id'],
            'titulo' => '-',
            'tipo' => 'Mesa de examen',
            'fechaHora' => $mesa['fechaHora'],
            'fechaHoraFinalizacion' => '',
            'asignatura' => $mesa['asignatura'],
            'division' => $mesa['division'],
        ];
    }

    public function ordenarEvasMesas($evasMesas)
    {
        $keys = array_keys($evasMesas);
        
        for ($i=0; $i < count($keys); $i++) { 
            usort($evasMesas[$keys[$i]], function($a, $b) {
                return $a['fechaHora'] <=> $b['fechaHora'];
            });
        }
        return $evasMesas;
    }
}