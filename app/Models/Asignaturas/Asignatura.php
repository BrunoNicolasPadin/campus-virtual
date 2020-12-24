<?php

namespace App\Models\Asignaturas;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignaturas';
    protected $fillable = [
        'division_id',
        'nombre',
    ];
}
