<?php

namespace App\Models\Deudores;

use App\Models\Asignaturas\Asignatura;
use App\Models\Instituciones\Institucion;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'mesas';
    protected $fillable = [
        'fechaHoraRealizacion',
        'fechaHoraFinalizacion',
        'comentario',
    ];
    protected $guarded = [
        'institucion_id',
        'asignatura_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function anotados()
    {
        return $this->hasMany(Anotado::class);
    }
}
