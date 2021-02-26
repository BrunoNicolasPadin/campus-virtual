<?php

namespace App\Models\Muro;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class MuroRespuesta extends Model
{
    protected $table = 'muro_respuestas';
    protected $fillable = [
        'respuesta',
    ];
    protected $guarded = [
        'muro_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function muro()
    {
        return $this->belongsTo(Muro::class);
    }
}
