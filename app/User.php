<?php

namespace App;

use App\DatabaseNotification;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'visibility', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = [
        'image'
    ];

    protected $appends = [
        'image_url'
    ];

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function projects()
    {
        return $this->morphedByMany('App\Project', 'teamable', 'teams')
                    ->withPivot('accepted_at', 'rejected_at')
                    ->thatUserCanAccess();
    }

    public function tasks()
    {
        return $this->morphedByMany('App\Task', 'teamable', 'teams');
    }

    public function image()
    {
        return $this->morphOne('App\File', 'fileable');
    }


    public function scopeFindByEmail($query, $email)
    {
        return $query->where('email', $email)->first();
    }

    public function getImageUrlAttribute()
    {
        if ($this->image === null) {
            return '/svg/profile-fallback.svg';
        }
        return '/data/profile/'.$this->id.'/avatar';
    }


    public function jointProjectsWith($user)
    {
        return $this->projects()->whereIn('id', $user->projects()->pluck('id'))->get();
    }
}
