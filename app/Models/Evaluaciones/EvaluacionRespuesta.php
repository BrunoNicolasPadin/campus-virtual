<?php

namespace App\Models\Evaluaciones;

use Illuminate\Database\Eloquent\Model;

class EvaluacionRespuesta extends Model
{
    protected $table = 'evaluaciones_respuestas';
    protected $fillable = [
        'respuesta_id',
        'user_id',
        'respuesta',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
