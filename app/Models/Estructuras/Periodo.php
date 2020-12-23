<?php

namespace App\Models\Estructuras;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';
    protected $fillable = [
        'nombre',
    ];
}
