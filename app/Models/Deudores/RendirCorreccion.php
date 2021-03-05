<?php

namespace App\Models\Deudores;

use Illuminate\Database\Eloquent\Model;

class RendirCorreccion extends Model
{
    protected $table = 'rendir_correcciones';
    protected $fillable = [
        'archivo',
    ];
    protected $guarded = [
        'inscripcion_id',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }
}
