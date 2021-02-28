<?php

namespace Database\Seeders;

use App\Models\Roles\Alumno;
use App\Models\Roles\Padre;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PadreSeeder extends Seeder
{
    public function run()
    {
        for ($i=1; $i < 21; $i++) { 

            $alumnos = Alumno::where('institucion_id', $i)->get();
            foreach ($alumnos as $alumno) {

                $usuario = new User();
                $usuario->name = Str::random(10);
                $usuario->email = Str::random(10) . '@gmail.com';
                $usuario->password = Hash::make('contrasenia');
                $usuario->tipo = 'Persona';
                $usuario->save();

                $padre = new Padre();
                $padre->activado = '0';
                $padre->user()->associate($usuario);
                $padre->hijos()->associate($alumno);
                $padre->save();
            }
        }
    }
}
