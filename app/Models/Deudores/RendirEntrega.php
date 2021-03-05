<?php

namespace App\Models\Deudores;

use Illuminate\Database\Eloquent\Model;

class RendirEntrega extends Model
{
    protected $table = 'rendir_entregas';
    protected $fillable = [
        'archivo',
        'created_at',
        'updated_at',
    ];
    protected $guarded = [
        'inscripcion_id',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }
}
