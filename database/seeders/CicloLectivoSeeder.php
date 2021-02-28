<?php

namespace Database\Seeders;

use App\Models\CiclosLectivos\CicloLectivo;
use Illuminate\Database\Seeder;

class CicloLectivoSeeder extends Seeder
{
    public function run()
    {
            $cicloLectivo = new CicloLectivo();
            $cicloLectivo->comienzo = '2021-03-01';
            $cicloLectivo->final = '2022-02-28';
            $cicloLectivo->activado = 0;
            $cicloLectivo->institucion()->associate(1);
            $cicloLectivo->save();
    }
}
