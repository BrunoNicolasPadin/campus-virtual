<?php

namespace App\Models\Deudores;

use Illuminate\Database\Eloquent\Model;

class MesaArchivo extends Model
{
    protected $table = 'mesas_archivos';
    protected $fillable = [
        'mesa_id',
        'archivo',
        'visibilidad',
    ];
}
