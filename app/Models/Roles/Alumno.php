<?php

namespace App\Models\Roles;

use App\Models\Estructuras\Division;
use App\Models\Instituciones\Institucion;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Alumno extends Model
{
    use Notifiable;

    protected $table = 'alumnos';
    protected $fillable = [
        'exAlumno',
        'activado',
        'eliminado',
    ];
    protected $guarded = [
        'user_id',
        'institucion_id',
        'division_id',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->orderBy('name');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function padres()
    {
        return $this->hasMany(Padre::class);
    }
}
