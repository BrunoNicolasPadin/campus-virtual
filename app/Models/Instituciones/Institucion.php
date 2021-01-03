<?php

namespace App\Models\Instituciones;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'instituciones';
    protected $fillable = [
        'user_id',
        'numero',
        'fundacion',
        'historia',
        'planDeEstudio',
        'claveDeAcceso',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
