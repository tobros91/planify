<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function team()
    {
        return $this->morphToMany(User::class, 'teamable', 'teams')->withPivot('accepted_at', 'rejected_at');
    }

    public function invite(User $user)
    {
        return $this->team()->attach($user->id);
    }

    public function kick(User $user)
    {
        if ($user === null) {
            throw new \Exception("Not a valid user");
        }

        return $this->team()->detach($user->id);
    }
}
