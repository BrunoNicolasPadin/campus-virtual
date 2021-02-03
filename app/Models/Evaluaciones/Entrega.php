<?php

namespace App\Models\Evaluaciones;

use App\Models\Roles\Alumno;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entregas';
    protected $fillable = [
        'evaluacion_id',
        'alumno_id',
        'calificacion',
        'comentario',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function archivos()
    {
        return $this->hasMany(EntregaArchivo::class);
    }
}
