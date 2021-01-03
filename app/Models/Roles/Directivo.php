<?php

namespace App\Models\Roles;

use App\Models\Instituciones\Institucion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Directivo extends Model
{
    protected $table = 'directivos';
    protected $fillable = [
        'user_id',
        'institucion_id',
        'activado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }
}
