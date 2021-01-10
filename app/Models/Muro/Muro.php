<?php

namespace App\Models\Muro;

use App\Models\Estructuras\Division;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Muro extends Model
{
    protected $table = 'muro';
    protected $fillable = [
        'division_id',
        'user_id',
        'publicacion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
