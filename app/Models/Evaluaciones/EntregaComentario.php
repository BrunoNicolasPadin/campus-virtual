<?php

namespace App\Models\Evaluaciones;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EntregaComentario extends Model
{
    protected $table = 'entregas_comentarios';
    protected $fillable = [
        'comentario',
    ];
    protected $guarded = [
        'entrega_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}
