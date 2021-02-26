<?php

namespace App\Models\Estructuras;

use Illuminate\Database\Eloquent\Model;

class FormaDescripcion extends Model
{
    protected $table = 'formas_descripcion';
    protected $fillable = [
        'opcion',
        'aprobado',
    ];
    protected $guarded = [
        'forma_evaluacion_id',
    ];

    public function formaEvaluacion()
    {
        return $this->belongsTo(FormaEvaluacion::class);
    }
}
