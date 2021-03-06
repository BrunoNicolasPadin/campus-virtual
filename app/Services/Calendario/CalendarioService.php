<?php

namespace App\Services\Calendario;

class CalendarioService
{
    public function obtenerMeses()
    {
        return ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    }

    public function obtenerMesesValidar()
    {
        return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    }

    public function obtenerEvaluaciones($evaluacion)
    {
        return [
            'id' => $evaluacion['id'],
            'institucion_id' => $evaluacion['institucion_id'],
            'division_id' => $evaluacion['division_id'],
            'titulo' => $evaluacion['titulo'],
            'tipo' => $evaluacion['tipo'],
            'fechaHoraRealizacion' => $evaluacion['fechaHoraRealizacion'],
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
            'fechaHoraRealizacion' => $mesa['fechaHoraRealizacion'],
            'fechaHoraFinalizacion' => $mesa['fechaHoraFinalizacion'],
            'asignatura' => $mesa['asignatura'],
            'division' => $mesa['division'],
        ];
    }

    public function ordenarEvasMesas($evasMesas)
    {
        $keys = array_keys($evasMesas);
        
        for ($i=0; $i < count($keys); $i++) { 
            usort($evasMesas[$keys[$i]], function($a, $b) {
                return $a['fechaHoraRealizacion'] <=> $b['fechaHoraRealizacion'];
            });
        }
        return $evasMesas;
    }

    public function obtenerMesesParaBuscar()
    {
        return [
            array('Nombre' => 'Enero', 'Numero' => 1),
            array('Nombre' => 'Febrero', 'Numero' => 2),
            array('Nombre' => 'Marzo', 'Numero' => 3),
            array('Nombre' => 'Abril', 'Numero' => 4),
            array('Nombre' => 'Mayo', 'Numero' => 5),
            array('Nombre' => 'Junio', 'Numero' => 6),
            array('Nombre' => 'Julio', 'Numero' => 7),
            array('Nombre' => 'Agosto', 'Numero' => 8),
            array('Nombre' => 'Septiembre', 'Numero' => 9),
            array('Nombre' => 'Octubre', 'Numero' => 10),
            array('Nombre' => 'Noviembre', 'Numero' => 11),
            array('Nombre' => 'Diciembre', 'Numero' => 12),
        ];
    }

    public function obtenerMesSeleccionado($mes)
    {
        $meses = $this->obtenerMeses();
        return $meses[$mes-1];
    }
}