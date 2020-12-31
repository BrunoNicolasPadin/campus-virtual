<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use Inertia\Inertia;

class HorarioController extends Controller
{
    public function mostrarHorarios($institucion_id, $division_id)
    {
        $asignaturas = Asignatura::where('division_id', $division_id)->with('horarios')->get();
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
        $semana = [];
        $k = 0;

        
        for ($i=0; $i < count($dias); $i++) { 

            foreach ($asignaturas as $asignatura) {

                foreach ($asignatura->horarios as $horario) {
                    
                    if ($dias[$i] == $horario->dia) {
                        
                        $semana[$i] = [
                            'asignatura' => $asignatura->nombre,
                            'dia' => $horario->dia,
                            'horaDesde' => $horario->horaDesde,
                            'horaHasta' => $horario->horaHasta,
                        ];
                        
                        $k++;
                        
                        break;
                    }
                }
            }
            $k = 0;
        }
        return dd($semana);
        /* ksort($semana);

        return Inertia::render('Horarios/Mostrar', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'dias' => $dias,
            'semanas' => $semana,
        ]); */
    }
}
