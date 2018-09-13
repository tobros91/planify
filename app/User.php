<?php

namespace App;

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

    protected $appends = [
        'image_url'
    ];

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

    public function scopeFindByEmail($query, $email)
    {
        return $query->where('email', $email)->first();
    }

    public function getImageUrlAttribute()
    {
        return '/svg/profile-fallback.svg';
    }


    public function jointProjectsWith($user)
    {
        return $this->projects()->whereIn('id', $user->projects()->pluck('id'))->get();
    }
}
