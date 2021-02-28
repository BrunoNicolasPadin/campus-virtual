<?php

namespace Database\Seeders;

use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AlumnoSeeder extends Seeder
{
    public function run()
    {
        for ($i=1; $i < 21; $i++) { 
            
            $divisiones = Division::where('institucion_id', $i)->get();
            foreach ($divisiones as $division) {

                for ($k=0; $k < 10; $k++) { 
                    $usuario = new User();
                    $usuario->name = Str::random(10);
                    $usuario->email = Str::random(10) . '@gmail.com';
                    $usuario->password = Hash::make('contrasenia');
                    $usuario->tipo = 'Persona';
                    $usuario->save();

                    $alumno = new Alumno();
                    $alumno->activado = '0';
                    $alumno->exAlumno = '0';
                    $alumno->user()->associate($usuario);
                    $alumno->institucion()->associate($i);
                    $alumno->division()->associate($division);
                    $alumno->save();
                }

                
            }
        }
    }
}
