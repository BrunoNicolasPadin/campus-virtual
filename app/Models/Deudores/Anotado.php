<?php

namespace App\Models\Deudores;

use App\Models\Roles\Alumno;
use Illuminate\Database\Eloquent\Model;

class Anotado extends Model
{
    protected $table = 'anotados';
    protected $fillable = [
        'mesa_id',
        'alumno_id',
        'calificacion',
        'comentario',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
