<?php

namespace App\Models\Evaluaciones;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EvaluacionComentario extends Model
{
    protected $table = 'evaluaciones_comentarios';
    protected $fillable = [
        'evaluacion_id',
        'user_id',
        'comentario',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
