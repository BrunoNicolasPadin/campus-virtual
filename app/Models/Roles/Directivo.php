<?php

namespace App\Models\Roles;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Directivo extends Model
{
    protected $table = 'directivos';
    protected $fillable = [
        'user_id',
        'institucion_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
