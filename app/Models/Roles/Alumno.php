<?php

namespace App\Models\Roles;

use App\Models\Estructuras\Division;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $fillable = [
        'user_id',
        'institucion_id',
        'division_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
