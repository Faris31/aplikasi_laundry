<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    protected $fillable = [
        'level_name'
    ];

    use SoftDeletes;

    public function users(){
        return $this->hasMany(User::class, 'id_level');
    }
}
