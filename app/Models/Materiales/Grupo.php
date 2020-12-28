<?php

namespace App\Models\Materiales;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $fillable = [
        'asignatura_id',
        'nombre',
    ];
}
