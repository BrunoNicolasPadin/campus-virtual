<?php

namespace App\Models\Estructuras;

use Illuminate\Database\Eloquent\Model;

class FormaDescripcion extends Model
{
    protected $table = 'formas_descripcion';
    protected $fillable = [
        'forma_evaluacion_id',
        'opcion',
        'aprobado',
    ];

    public function formaEvaluacion()
    {
        return $this->belongsTo(FormaEvaluacion::class);
    }
}
