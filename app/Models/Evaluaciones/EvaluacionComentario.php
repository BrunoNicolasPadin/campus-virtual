<?php

namespace App\Models\Evaluaciones;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EvaluacionComentario extends Model
{
    protected $table = 'evaluaciones_comentarios';
    protected $fillable = [
        'comentario',
    ];
    protected $guarded = [
        'evaluacion_id',
        'user_id',
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
