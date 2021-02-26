<?php

namespace App\Models\Deudores;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RendirComentario extends Model
{
    protected $table = 'rendir_comentarios';
    protected $fillable = [
        'comentario',
    ];
    protected $guarded = [
        'anotado_id',
        'user_id',
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
