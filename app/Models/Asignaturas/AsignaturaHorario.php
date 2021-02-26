<?php

namespace App\Models\Asignaturas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignaturaHorario extends Model
{
    protected $table = 'asignaturas_horarios';
    protected $fillable = [
        'dia',
        'horaDesde',
        'horaHasta',
    ];
    protected $guarded = [
        'asignatura_id',
    ];

    public function asignatura()
    {
        return $this->BelongsTo(Asignatura::class);
    }
}
