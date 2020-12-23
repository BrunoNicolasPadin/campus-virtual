<?php

namespace App\Models\Estructuras;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisiones';
    protected $fillable = [
        'institucion_id',
        'nivel_id',
        'orientacion_id',
        'curso_id',
        'division',
        'periodo_id',
        'claveDeAcceso',
    ];

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
}
