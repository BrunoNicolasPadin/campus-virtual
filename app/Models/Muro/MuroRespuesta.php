<?php

namespace App\Models\Muro;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class MuroRespuesta extends Model
{
    protected $table = 'muro_respuestas';
    protected $fillable = [
        'muro_id',
        'user_id',
        'respuesta',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
