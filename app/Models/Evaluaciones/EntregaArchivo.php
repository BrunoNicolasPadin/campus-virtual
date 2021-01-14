<?php

namespace App\Models\Evaluaciones;

use Illuminate\Database\Eloquent\Model;

class EntregaArchivo extends Model
{
    protected $table = 'entregas_archivos';
    protected $fillable = [
        'entrega_id',
        'archivo',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}
