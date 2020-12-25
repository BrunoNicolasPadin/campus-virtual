<?php

namespace App\Models\Roles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $fillable = [
        'user_id',
        'division_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
