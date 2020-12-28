<?php

namespace App\Models\Libretas;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';
    protected $fillable = [
        'libreta_id',
        'periodo',
        'calificacion',
    ];

    public function libreta()
    {
        return $this->belongsTo(Libreta::class);
    }
}
