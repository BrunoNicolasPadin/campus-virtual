<?php

namespace Database\Seeders;

use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;
use Illuminate\Database\Seeder;

class FormaDescripcionSeeder extends Seeder
{
    public function run()
    {
        $semaforos = ['Rojo', 'Amarillo', 'Verde'];
        $semaforoAprobado = [false, true, true];
        $palabras = ['Muy mal', 'Mal', 'Bien', 'Muy bien', 'Excelente'];
        $palabrasAprobado = [false, false, true, true, true];
        $numeros = [1, 2, 3, 4, 5, 6, 7 , 8, 9, 10];
        $numerosAprobado = [false, false, false, false, false, true, true, true, true, true, true];
        
        for ($i=1; $i < 21; $i++) { 

            $formasEvaluacion = FormaEvaluacion::where('institucion_id', $i)->get();
            foreach ($formasEvaluacion as $formaEvaluacion) {

                if ($formaEvaluacion->tipo == 'Escrita' && $formaEvaluacion->nombre == 'Semaforos') {
                    for ($k=0; $k < count($semaforos); $k++) { 
                        $formaDescripcion = new FormaDescripcion();
                        $formaDescripcion->opcion = $semaforos[$k];
                        $formaDescripcion->aprobado = $semaforoAprobado[$k];
                        $formaDescripcion->formaEvaluacion()->associate($formaEvaluacion);
                        $formaDescripcion->save();
                    }
                }
                if ($formaEvaluacion->tipo == 'Escrita' && $formaEvaluacion->nombre == 'Con palabras') {
                    for ($k=0; $k < count($palabras); $k++) { 
                        $formaDescripcion = new FormaDescripcion();
                        $formaDescripcion->opcion = $palabras[$k];
                        $formaDescripcion->aprobado = $palabrasAprobado[$k];
                        $formaDescripcion->formaEvaluacion()->associate($formaEvaluacion);
                        $formaDescripcion->save();
                    }
                }
                if ($formaEvaluacion->tipo == 'Numerica') {
                    for ($k=0; $k < count($numeros); $k++) { 
                        $formaDescripcion = new FormaDescripcion();
                        $formaDescripcion->opcion = $numeros[$k];
                        $formaDescripcion->aprobado = $numerosAprobado[$k];
                        $formaDescripcion->formaEvaluacion()->associate($formaEvaluacion);
                        $formaDescripcion->save();
                    }
                }
                if ($formaEvaluacion->tipo == 'Porcentual') {
                    for ($k=1; $k < 101; $k++) { 
                        $formaDescripcion = new FormaDescripcion();
                        $formaDescripcion->opcion = $k;
                        if ($k < 60) {
                            $formaDescripcion->aprobado = false;
                        }
                        else {
                            $formaDescripcion->aprobado = true;
                        }
                        $formaDescripcion->formaEvaluacion()->associate($formaEvaluacion);
                        $formaDescripcion->save();
                    }
                }
            }
        }
    }
}
