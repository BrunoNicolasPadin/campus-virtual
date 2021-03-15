<?php

namespace Database\Seeders;

use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EvaluacionSeeder extends Seeder
{
    public function run()
    {
            
        $divisiones = Division::where('institucion_id', 1)->get();
        foreach ($divisiones as $division) {

            $asignaturas = Asignatura::where('division_id', $division->id)->get();
            foreach ($asignaturas as $asignatura) {
                for ($k=1; $k < 13; $k++) { 
                    $evaluacion = new Evaluacion();
                    $evaluacion->titulo = Str::random(10);
                    $evaluacion->tipo = 'Examen';
                    $evaluacion->fechaHoraRealizacion = '2021-'.$k.'-28 10:00:00';
                    $evaluacion->fechaHoraFinalizacion = '2021-'.$k.'-28 12:00:00';
                    $evaluacion->comentario = Str::random(50);
                    $evaluacion->institucion()->associate(1);
                    $evaluacion->division()->associate($division);
                    $evaluacion->asignatura()->associate($asignatura);
                    $evaluacion->save();
                }
            }
            
        }
    }
}
