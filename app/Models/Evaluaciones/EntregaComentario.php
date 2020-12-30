<?php

namespace App\Models\Evaluaciones;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EntregaComentario extends Model
{
    protected $table = 'entregas_comentarios';
    protected $fillable = [
        'entrega_id',
        'user_id',
        'comentario',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
