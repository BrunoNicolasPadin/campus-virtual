<?php

namespace Database\Seeders;

use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Estructuras\Division;
use App\Models\Roles\Docente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DocenteSeeder extends Seeder
{
    public function run()
    {
        for ($i=1; $i < 21; $i++) { 
            
            $divisiones = Division::where('institucion_id', $i)->get();
            foreach ($divisiones as $division) {
                
                $asignaturas = Asignatura::where('division_id', $division->id)->get();
                foreach ($asignaturas as $asignatura) {

                    $usuario = new User();
                    $usuario->name = Str::random(10);
                    $usuario->email = Str::random(10) . '@gmail.com';
                    $usuario->password = Hash::make('contrasenia');
                    $usuario->tipo = 'Persona';
                    $usuario->save();

                    $docente = new Docente();
                    $docente->activado = 0;
                    $docente->user()->associate($usuario);
                    $docente->institucion()->associate($i);
                    $docente->save();

                    $asignaturaDocente = new AsignaturaDocente();
                    $asignaturaDocente->asignatura()->associate($asignatura->id);
                    $asignaturaDocente->docente()->associate($docente);
                    $asignaturaDocente->save();
                }
            }
        }
    }
}
