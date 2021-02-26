<?php

namespace App\Models\Muro;

use Illuminate\Database\Eloquent\Model;

class MuroArchivo extends Model
{
    protected $table = 'muro_archivos';
    protected $fillable = [
        'archivo',
    ];
    protected $guarded = [
        'muro_id',
    ];

    public function muro()
    {
        return $this->belongsTo(Muro::class);
    }
}
