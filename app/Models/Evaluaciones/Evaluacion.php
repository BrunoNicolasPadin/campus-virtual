<?php

namespace App\Models\Evaluaciones;

use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use App\Models\Instituciones\Institucion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Evaluacion extends Model
{
    use Notifiable;

    protected $table = 'evaluaciones';
    protected $fillable = [
        'titulo',
        'tipo',
        'fechaHoraRealizacion',
        'fechaHoraFinalizacion',
        'comentario',
    ];
    protected $guarded = [
        'institucion_id',
        'division_id',
        'asignatura_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
