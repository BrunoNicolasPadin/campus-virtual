<?php

namespace App\Models\Materiales;

use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $fillable = [
        'nombre',
    ];
    protected $guarded = [
        'division_id',
        'asignatura_id'
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
