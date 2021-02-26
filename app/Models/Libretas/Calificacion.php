<?php

namespace App\Models\Libretas;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';
    protected $fillable = [
        'periodo',
        'calificacion',
    ];
    protected $guarded = [
        'libreta_id',
    ];

    public function libreta()
    {
        return $this->belongsTo(Libreta::class);
    }
}
