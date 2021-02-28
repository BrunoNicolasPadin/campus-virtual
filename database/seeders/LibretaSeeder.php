<?php

namespace Database\Seeders;

use App\Models\Libretas\Calificacion;
use App\Models\Libretas\Libreta;
use App\Models\Roles\Alumno;
use Illuminate\Database\Seeder;

class LibretaSeeder extends Seeder
{
    public function run()
    {
        $alumnos = Alumno::where('division_id', 35)->get();
        $formasEvaluacion = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];

        foreach ($alumnos as $alumno) {
            $libretas = Libreta::where('alumno_id', $alumno->id)
            ->where('ciclo_lectivo_id', 37)
            ->with(['asignatura', 'calificaciones'])
            ->get();

            foreach ($libretas as $libreta) {
                foreach ($libreta->calificaciones as $calificacionPeriodo) {
                    $calificacion = Calificacion::findOrFail($calificacionPeriodo->id);
                    $calificacion->calificacion = array_rand(array_flip($formasEvaluacion), 1);
                    $calificacion->save();
                }
            }

        }
    }
}
