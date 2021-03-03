<?php

namespace App\Models\Evaluaciones;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EvaluacionRespuesta extends Model
{
    protected $table = 'evaluaciones_respuestas';
    protected $fillable = [
        'respuesta',
        'created_at',
        'updated_at',
    ];
    protected $guarded = [
        'comentario_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentario()
    {
        return $this->belongsTo(EvaluacionComentario::class);
    }
}
