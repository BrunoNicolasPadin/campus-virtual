<?php

namespace Database\Seeders;

use App\Models\Roles\Directivo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DirectivoSeeder extends Seeder
{
    public function run()
    {
        for ($i=1; $i < 21; $i++) { 
            for ($k=0; $k < 10; $k++) { 
                $usuario = new User();
                $usuario->name = Str::random(10);
                $usuario->email = Str::random(10) . '@gmail.com';
                $usuario->password = Hash::make('contrasenia');
                $usuario->tipo = 'Persona';
                $usuario->save();

                $directivo = new Directivo();
                $directivo->activado = 0;
                $directivo->user()->associate($usuario);
                $directivo->institucion()->associate($i);
                $directivo->save();
            }
        }
    }
}
