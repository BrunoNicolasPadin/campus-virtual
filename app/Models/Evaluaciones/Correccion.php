<?php

namespace App\Models\Evaluaciones;

use Illuminate\Database\Eloquent\Model;

class Correccion extends Model
{
    protected $table = 'correcciones';
    protected $fillable = [
        'entrega_id',
        'archivo',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}
