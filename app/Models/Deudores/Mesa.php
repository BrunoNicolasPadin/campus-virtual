<?php

namespace App\Models\Deudores;

use App\Models\Asignaturas\Asignatura;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'mesas';
    protected $fillable = [
        'asignatura_id',
        'fechaHora',
        'comentario',
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
