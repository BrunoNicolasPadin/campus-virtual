<?php

namespace App\Models\Evaluaciones;

use Illuminate\Database\Eloquent\Model;

class Correccion extends Model
{
    protected $table = 'correcciones';
    protected $fillable = [
        'archivo',
    ];
    protected $guarded = [
        'entrega_id',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}
