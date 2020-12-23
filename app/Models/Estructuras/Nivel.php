<?php

namespace App\Models\Estructuras;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';
    protected $fillable = [
        'nombre',
    ];
}
