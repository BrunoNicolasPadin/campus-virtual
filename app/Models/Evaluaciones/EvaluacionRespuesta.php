<?php

namespace App\Models\Evaluaciones;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EvaluacionRespuesta extends Model
{
    protected $table = 'evaluaciones_respuestas';
    protected $fillable = [
        'comentario_id',
        'user_id',
        'respuesta',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
