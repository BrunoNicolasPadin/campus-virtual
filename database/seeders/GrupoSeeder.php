<?php

namespace Database\Seeders;

use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use App\Models\Materiales\Grupo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GrupoSeeder extends Seeder
{
    public function run()
    {
        $divisiones = Division::where('institucion_id', 1)->get();
        foreach ($divisiones as $division) {

            $asignaturas = Asignatura::where('division_id', $division->id)->get();
            foreach ($asignaturas as $asignatura) {
                for ($k=1; $k < 11; $k++) { 
                    $grupo = new Grupo();
                    $grupo->nombre = Str::random(10);
                    $grupo->division()->associate($division);
                    $grupo->asignatura()->associate($asignatura);
                    $grupo->save();
                }
            }
            
        }
    }
}
