<?php

namespace Database\Seeders;

use App\Models\CiclosLectivos\CicloLectivo;
use Illuminate\Database\Seeder;

class CicloLectivoSeeder extends Seeder
{
    public function run()
    {
        for ($i=2; $i < 21; $i++) { 
            
            $cicloLectivo = new CicloLectivo();
            $cicloLectivo->comienzo = '1996-03-04';
            $cicloLectivo->final = '1997-03-02';
            $cicloLectivo->activado = 1;
            $cicloLectivo->institucion()->associate($i);
            $cicloLectivo->save();
        }
    }
}
