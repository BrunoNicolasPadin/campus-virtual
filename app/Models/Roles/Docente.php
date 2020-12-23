<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docentes';
    protected $fillable = [
        'user_id',
        'institucion_id',
    ];
}
