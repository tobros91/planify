<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'starts_at',
        'ends_at',
    ];

    public function team()
    {
        return $this->morphToMany(User::class, 'teamable', 'teams');
    }
}
