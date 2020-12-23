<?php

namespace Database\Seeders;

use App\Models\Estructuras\Nivel;
use Illuminate\Database\Seeder;

class NivelSeeder extends Seeder
{
    public function run()
    {
        Nivel::create([
            'nivel' => 'Inicial',
        ]);

        Nivel::create([
            'nivel' => 'Primaria',
        ]);

        Nivel::create([
            'nivel' => 'Secundaria',
        ]);
    }
}
