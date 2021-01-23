<?php

namespace App\Models\Repetidores;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use Illuminate\Database\Eloquent\Model;

class Repetidor extends Model
{
    protected $table = 'repetidores';
    protected $fillable = [
        'institucion_id',
        'alumno_id',
        'ciclo_lectivo_id',
        'division_id',
        'comentario',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function ciclo_lectivo()
    {
        return $this->belongsTo(CicloLectivo::class);
    }
}
