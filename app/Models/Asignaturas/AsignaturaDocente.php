<?php

namespace App\Models\Asignaturas;

use App\Models\Roles\Docente;
use Illuminate\Database\Eloquent\Model;

class AsignaturaDocente extends Model
{
    protected $table = 'asignaturas_docentes';
    protected $fillable = [
        'asignatura_id',
        'docente_id',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
