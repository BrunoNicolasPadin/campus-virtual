<?php

namespace Database\Seeders;

use App\Models\Estructuras\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run()
    {
        $curso = ['Lactantes', 'Deambuladores', 'Sala de 2 años', 'Sala de 3 años', 'Sala de 4 años', 'Sala de 5 años', '1er grado', '2do grado',
            '3er grado', '4to grado', '5to grado', '6to grado', '7mo grado', '1er año', '2do año', '3er año', '4to año', '5to año', '6to año', '7mo año'];

        for ($i=0; $i < count($curso); $i++) { 
            Curso::create([
                'curso' => $curso[$i],
            ]);
        }
    }
}
