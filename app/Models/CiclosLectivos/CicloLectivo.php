<?php

namespace App\Models\CiclosLectivos;

use App\Models\Instituciones\Institucion;
use Illuminate\Database\Eloquent\Model;

class CicloLectivo extends Model
{
    protected $table = 'ciclos_lectivos';
    protected $fillable = [
        'comienzo',
        'final',
        'activado',
    ];
    protected $guarded = [
        'institucion_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
