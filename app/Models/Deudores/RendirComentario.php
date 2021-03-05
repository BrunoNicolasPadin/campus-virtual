<?php

namespace App\Models\Deudores;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RendirComentario extends Model
{
    protected $table = 'rendir_comentarios';
    protected $fillable = [
        'comentario',
        'created_at',
        'updated_at',
    ];
    protected $guarded = [
        'inscripcion_id',
        'user_id',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
