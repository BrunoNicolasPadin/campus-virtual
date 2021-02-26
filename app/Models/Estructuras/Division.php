<?php

namespace App\Models\Estructuras;

use App\Models\Asignaturas\Asignatura;
use App\Models\Instituciones\Institucion;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisiones';
    protected $fillable = [
        'division',
        'claveDeAcceso',
    ];
    protected $guarded = [
        'institucion_id',
        'nivel_id',
        'orientacion_id',
        'curso_id',
        'periodo_id',
        'forma_evaluacion_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function orientacion()
    {
        return $this->belongsTo(Orientacion::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function formaEvaluacion()
    {
        return $this->belongsTo(FormaEvaluacion::class);
    }

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }
}
