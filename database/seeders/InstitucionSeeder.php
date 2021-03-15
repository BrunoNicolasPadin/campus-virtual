<?php

namespace Database\Seeders;

use App\Models\Instituciones\Institucion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InstitucionSeeder extends Seeder
{
    public function run()
    {
        for ($i=1; $i < 20; $i++) { 

            $usuario = new User();
            $usuario->name = Str::random(10);
            $usuario->email = Str::random(10) . '@gmail.com';
            $usuario->password = Hash::make('contrasenia');
            $usuario->tipo = 'Institucion';
            $usuario->save();

            $institucion = new Institucion();
            $institucion->numero = Str::random(5);
            $institucion->fundacion = Str::random(5);
            $institucion->historia = Str::random(100);
            $institucion->planDeEstudio = null;
            $institucion->claveDeAcceso = Hash::make('padreclaret');
            $institucion->user()->associate($usuario);
            $institucion->save();
        }
    }
}
