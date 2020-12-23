<?php

namespace Database\Seeders;

use App\Models\Estructuras\Orientacion;
use Illuminate\Database\Seeder;

class OrientacionSeeder extends Seeder
{
    public function run()
    {
        $ori = ['Ciencias Sociales y Humanidades', 'Ciencias Naturales', 'Economía y Administración', 'Lenguas', 'Agro y Ambiente',
        'Comunicación', 'Informática', 'Educación Física', 'Turismo', 'Arte', 'Literatura', 'Educación', 'Física y Matemática',
        'Agrotécnica', 'Electromecánica', 'Química', 'Construcciones', 'Electrónica', 'Electricidad', 'Mecánica', 'Informática'];

        for ($i=0; $i < count($ori); $i++) { 
            Orientacion::create([
                'orientacion' => $ori[$i],
            ]);
        }
    }
}
