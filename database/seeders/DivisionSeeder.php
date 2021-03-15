<?php

namespace Database\Seeders;

use App\Models\Estructuras\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DivisionSeeder extends Seeder
{
    public function run()
    {
        $nombre = ['A', 'B'];
        for ($i=1; $i < 21; $i++) { 
            for ($q=1; $q < 2; $q++) { 
                for ($e=1; $e < 7; $e++) { 
                    for ($w=0; $w < 2; $w++) { 
                        $division = new Division();
                        $division->division = $nombre[$w];
                        $division->claveDeAcceso = Hash::make('division');
                        $division->institucion()->associate($i);
                        $division->nivel()->associate($q);
                        $division->curso()->associate($e);
                        if ($q == 1 || $q == 2) {
                            $division->periodo()->associate(1);
                            if ($q == 1) {
                                $division->formaEvaluacion()->associate(1);
                            }
                            else {
                                $division->formaEvaluacion()->associate(2);
                            }
                        }
                        else {
                            $division->periodo()->associate(2);
                            $division->formaEvaluacion()->associate(4);
                        }
                        $division->save();
                    }
                }
            }

            for ($q=2; $q < 3; $q++) { 
                for ($e=7; $e < 14; $e++) { 
                    for ($w=0; $w < 2; $w++) { 
                        $division = new Division();
                        $division->division = $nombre[$w];
                        $division->claveDeAcceso = Hash::make('division');
                        $division->institucion()->associate($i);
                        $division->nivel()->associate($q);
                        $division->curso()->associate($e);
                        if ($q == 1 || $q == 2) {
                            $division->periodo()->associate(1);
                            if ($q == 1) {
                                $division->formaEvaluacion()->associate(1);
                            }
                            else {
                                $division->formaEvaluacion()->associate(2);
                            }
                        }
                        else {
                            $division->periodo()->associate(2);
                            $division->formaEvaluacion()->associate(4);
                        }
                        $division->save();
                    }
                }
            }

            for ($q=3; $q < 4; $q++) { 
                for ($e=14; $e < 19; $e++) { 
                    for ($w=0; $w < 2; $w++) { 
                        $division = new Division();
                        $division->division = $nombre[$w];
                        $division->claveDeAcceso = Hash::make('division');
                        $division->institucion()->associate($i);
                        $division->nivel()->associate($q);
                        $division->curso()->associate($e);
                        if ($q == 1 || $q == 2) {
                            $division->periodo()->associate(1);
                            if ($q == 1) {
                                $division->formaEvaluacion()->associate(1);
                            }
                            else {
                                $division->formaEvaluacion()->associate(2);
                            }
                        }
                        else {
                            $division->periodo()->associate(2);
                            $division->formaEvaluacion()->associate(4);
                        }
                        $division->save();
                    }
                }
            }
            
        }
    }
}
