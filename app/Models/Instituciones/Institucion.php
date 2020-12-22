<?php

namespace App\Models\Instituciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'instituciones';
    protected $fillable = [
        'user_id',
        'numero',
        'fundacion',
        'historia',
        'planDeEstudio',
        'claveDeAcceso',
    ];
}
