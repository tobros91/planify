<?php

namespace App;

use App\Task;
use App\User;
use App\Notifications\InvitedToProject;
use App\Notifications\KickedFromProject;
use Illuminate\Database\Eloquent\Model;

use Log;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function team()
    {
        return $this->morphToMany(User::class, 'teamable', 'teams')->withPivot('accepted_at', 'rejected_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeThatUserCanAccess($query, $user = null)
    {
        if (!$user) {
            $user = auth()->user();
        }

        return $query->whereHas('team', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->whereNull('rejected_at');
        });
    }

    public function invite(User $user, $message = null)
    {
        $this->team()->attach($user->id, ['message' => $message]);

        if (auth()->user()->id !== $user->id) {
            $user->notify(new InvitedToProject($this));
        }
    }

    public function kick(User $user)
    {
        if ($user === null) {
            throw new \Exception("Not a valid user");
        }

        $this->team()->detach($user->id);

        if (auth()->user()->id !== $user->id) {
            $user->notify(new KickedFromProject($this));
        }
    }


    public function userCanAccess($user = null)
    {
        if (!$user) {
            $user = auth()->user();
        }

        return self::thatUserCanAccess($user)->first() === null ? false : true;
    }
}
