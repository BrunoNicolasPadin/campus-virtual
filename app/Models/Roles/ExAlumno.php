<?php

namespace App\Models\Roles;

use App\Models\Instituciones\Institucion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ExAlumno extends Model
{
    protected $table = 'ex_alumnos';
    protected $fillable = [
        'user_id',
        'institucion_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
