<?php

namespace App\Models\Deudores;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RendirComentario extends Model
{
    protected $table = 'rendir_comentarios';
    protected $fillable = [
        'anotado_id',
        'user_id',
        'comentario',
    ];

    public function anotado()
    {
        return $this->belongsTo(Anotado::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
