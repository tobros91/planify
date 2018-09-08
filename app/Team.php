<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'user_id',
        'teamable_id',
        'teamable_type'
    ];
}
