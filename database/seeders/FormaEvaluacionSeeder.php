<?php

namespace Database\Seeders;

use App\Models\Estructuras\FormaEvaluacion;
use Illuminate\Database\Seeder;

class FormaEvaluacionSeeder extends Seeder
{
    public function run()
    {
        $nombres = ['Semaforos', 'Con palabras', 'Porcentajes', 'Del 1 al 10'];
        $tipoArray = ['Escrita', 'Escrita', 'Porcentual', 'Numerica'];
        $desdeCuandoArray = [NULL, NULL, '60', '6'];
        for ($i=1; $i < 21; $i++) { 
            for ($w=0; $w < 4; $w++) { 
                $formaEvaluacion = new FormaEvaluacion();
                $formaEvaluacion->nombre = $nombres[$w];
                $formaEvaluacion->tipo = $tipoArray[$w];
                $formaEvaluacion->desdeCuando = $desdeCuandoArray[$w];
                $formaEvaluacion->institucion()->associate($i);
                $formaEvaluacion->save();
            }
        }
    }
}
