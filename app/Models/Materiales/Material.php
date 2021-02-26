<?php

namespace App\Models\Materiales;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';
    protected $fillable = [
        'nombre',
        'visibilidad',
        'archivo',
    ];
    protected $guarded = [
        'grupo_id',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
