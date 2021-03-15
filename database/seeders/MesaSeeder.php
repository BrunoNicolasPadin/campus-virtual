<?php

namespace Database\Seeders;

use App\Models\Asignaturas\Asignatura;
use App\Models\Deudores\Mesa;
use App\Models\Estructuras\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MesaSeeder extends Seeder
{
    public function run()
    {    
        $divisiones = Division::where('institucion_id', 1)->get();
        foreach ($divisiones as $division) {

            $asignaturas = Asignatura::where('division_id', $division->id)->get();
            foreach ($asignaturas as $asignatura) {
                for ($k=1; $k < 13; $k++) { 
                    $mesa = new Mesa();
                    $mesa->fechaHora = '2021-'.$k.'-28 10:00:00';;
                    $mesa->comentario = Str::random(25);
                    $mesa->institucion()->associate(1);
                    $mesa->asignatura()->associate($asignatura);
                    $mesa->save();
                }
            }
            
        }
    }
}
