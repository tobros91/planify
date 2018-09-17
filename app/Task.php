<?php

namespace App;

use App\User;
use App\Comment;
use App\Project;
use App\Notifications\AssignedToTask;
use App\Notifications\KickedFromTask;
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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assign(User $user)
    {
        $this->team()->attach($user->id, ['accepted_at' => now()]);

        if (auth()->user()->id !== $user->id) {
            $user->notify(new AssignedToTask($this));
        }
    }

    public function kick(User $user)
    {
        if ($user === null) {
            throw new \Exception("Not a valid user");
        }

        $this->team()->detach($user->id);

        if (auth()->user()->id !== $user->id) {
            $user->notify(new KickedFromTask($this));
        }
    }
}
