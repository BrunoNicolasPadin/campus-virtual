<?php

namespace App\Models\Libretas;

use Illuminate\Database\Eloquent\Model;

class NotaFinal extends Model
{
    protected $table = 'notas_finales';
    protected $fillable = [
        'alumno_id',
        'ciclo_lectivo_id',
        'asignatura_id',
        'calificacion',
    ];

    public function cicloLectivo()
    {
        return $this->belongsTo(CicloLectivo::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
