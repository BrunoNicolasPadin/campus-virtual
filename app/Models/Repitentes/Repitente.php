<?php

namespace App\Models\Repitentes;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use Illuminate\Database\Eloquent\Model;

class Repitente extends Model
{
    protected $table = 'repitentes';
    protected $fillable = [
        'comentario',
    ];
    protected $guarded = [
        'institucion_id',
        'alumno_id',
        'ciclo_lectivo_id',
        'division_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

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
