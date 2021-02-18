<?php

namespace App\Models\Repitentes;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use Illuminate\Database\Eloquent\Model;

class Repitente extends Model
{
    protected $table = 'repitentes';
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
