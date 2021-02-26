<?php

namespace App\Models\Estructuras;

use App\Models\Instituciones\Institucion;
use Illuminate\Database\Eloquent\Model;

class FormaEvaluacion extends Model
{
    protected $table = 'formas_evaluacion';
    protected $fillable = [
        'nombre',
        'tipo',
        'desdeCuando',
    ];
    protected $guarded = [
        'institucion_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function formaDescripcion()
    {
        return $this->hasMany(FormaDescripcion::class);
    }
}
