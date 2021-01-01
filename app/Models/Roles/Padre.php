<?php

namespace App\Models\Roles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    protected $table = 'padres';
    protected $fillable = [
        'user_id',
        'alumno_id',
        'activado',
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
