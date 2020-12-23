<?php

namespace Database\Seeders;

use App\Models\Estructuras\Periodo;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    public function run()
    {
        Periodo::create([
            'nombre' => 'Bimestral',
        ]);

        Periodo::create([
            'nombre' => 'Trimestral',
        ]);

        Periodo::create([
            'nombre' => 'Cuatrimestral',
        ]);
    }
}
