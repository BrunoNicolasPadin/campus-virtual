<?php

namespace App\Models\Evaluaciones;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'evaluaciones_archivos';
    protected $fillable = [
        'nombre',
        'archivo',
        'visibilidad',
    ];
    protected $guarded = [
        'evaluacion_id',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }
}
