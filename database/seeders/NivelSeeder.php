<?php

namespace Database\Seeders;

use App\Models\Estructuras\Nivel;
use Illuminate\Database\Seeder;

class NivelSeeder extends Seeder
{
    public function run()
    {
        Nivel::create([
            'nombre' => 'Inicial',
        ]);

        Nivel::create([
            'nombre' => 'Primaria',
        ]);

        Nivel::create([
            'nombre' => 'Secundaria',
        ]);
    }
}
