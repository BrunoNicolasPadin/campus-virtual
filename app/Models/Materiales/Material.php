<?php

namespace App\Models\Materiales;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';
    protected $fillable = [
        'grupo_id',
        'nombre',
        'visibilidad',
        'archivo',
    ];
}
