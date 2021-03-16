<?php

namespace App\Models\Instituciones;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Institucion extends Model
{
    use Notifiable;

    protected $table = 'instituciones';
    protected $fillable = [
        'numero',
        'fundacion',
        'historia',
        'planDeEstudio',
        'claveDeAcceso',
    ];
    protected $guarded = [
        'user_id',
        'cantidadAlumnos',
        'pago',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
