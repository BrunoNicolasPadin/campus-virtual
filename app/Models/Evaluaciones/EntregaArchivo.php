<?php

namespace App\Models\Evaluaciones;

use Illuminate\Database\Eloquent\Model;

class EntregaArchivo extends Model
{
    protected $table = 'entregas_archivos';
    protected $fillable = [
        'archivo',
        'created_at',
        'updated_at'
    ];
    protected $guarded = [
        'entrega_id',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}
