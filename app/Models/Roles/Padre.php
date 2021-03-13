<?php

namespace App\Models\Roles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Padre extends Model
{
    use Notifiable;

    protected $table = 'padres';
    protected $fillable = [
        'activado',
    ];
    protected $guarded = [
        'user_id',
        'alumno_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hijos()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}
