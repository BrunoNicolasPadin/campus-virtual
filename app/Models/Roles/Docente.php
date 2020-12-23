<?php

namespace App\Models\Roles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docentes';
    protected $fillable = [
        'user_id',
        'institucion_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
