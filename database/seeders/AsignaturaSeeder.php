<?php

namespace Database\Seeders;

use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaHorario;
use App\Models\Estructuras\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AsignaturaSeeder extends Seeder
{
    public function run()
    {
        for ($z=1; $z < 21; $z++) { 
            $divisiones = Division::where('institucion_id', $z)->get();

            foreach ($divisiones as $division) {
                for ($i=0; $i < 10; $i++) { 
                    $asignatura = new Asignatura();
                    $asignatura->nombre = Str::random(10);
                    $asignatura->division()->associate($division->id);
                    $asignatura->save();

                    for ($k=0; $k < 2; $k++) { 
                        $asignaturaHorario = new AsignaturaHorario();
                        $asignaturaHorario->dia = Str::random(10);
                        $asignaturaHorario->horaDesde = '09:00:00';
                        $asignaturaHorario->horaHasta = '10:00:00';
                        $asignaturaHorario->asignatura()->associate($asignatura);
                        $asignaturaHorario->save();
                    }
                }
            }
        }
    }
}
