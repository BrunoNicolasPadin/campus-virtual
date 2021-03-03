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
        'anotado_id',
    ];

    public function anotado()
    {
        return $this->belongsTo(Anotado::class);
    }
}
