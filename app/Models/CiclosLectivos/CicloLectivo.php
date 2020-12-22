<?php

namespace App\Models\CiclosLectivos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicloLectivo extends Model
{
    protected $table = 'ciclos_lectivos';
    protected $fillable = [
        'institucion_id',
        'comienzo',
        'final',
        'activado',
    ];
}
