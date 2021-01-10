<?php

namespace App\Models\Evaluaciones;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'evaluaciones_archivos';
    protected $fillable = [
        'evaluacion_id',
        'titulo',
        'archivo',
        'visibilidad',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }
}
