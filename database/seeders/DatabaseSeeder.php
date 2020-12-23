<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            NivelSeeder::class,
            OrientacionSeeder::class,
            CursoSeeder::class,
        ]);
    }
}
