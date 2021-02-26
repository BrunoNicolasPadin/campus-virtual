<?php

namespace App\Models\Asignaturas;

use App\Models\Estructuras\Division;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignaturas';
    protected $fillable = [
        'nombre',
    ];

    protected $guarded = [
        'division_id',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function horarios()
    {
        return $this->hasMany(AsignaturaHorario::class);
    }

    public function docentes()
    {
        return $this->hasMany(AsignaturaDocente::class);
    }
}
