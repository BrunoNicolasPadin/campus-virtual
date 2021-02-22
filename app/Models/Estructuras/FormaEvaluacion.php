<?php

namespace App\Models\Estructuras;

use Illuminate\Database\Eloquent\Model;

class FormaEvaluacion extends Model
{
    protected $table = 'formas_evaluacion';
    protected $fillable = [
        'institucion_id',
        'nombre',
        'tipo',
        'desdeCuando',
    ];

    public function formaDescripcion()
    {
        return $this->hasMany(FormaDescripcion::class);
    }
}
