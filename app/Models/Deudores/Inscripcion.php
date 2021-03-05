<?php

namespace App\Models\Deudores;

use App\Models\Roles\Alumno;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';
    protected $fillable = [
        'calificacion',
        'comentario',
    ];
    protected $guarded = [
        'mesa_id',
        'alumno_id',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function entregas()
    {
        return $this->hasMany(RendirEntrega::class);
    }

    public function correcciones()
    {
        return $this->hasMany(RendirCorreccion::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
