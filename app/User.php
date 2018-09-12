<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects()
    {
        return $this->morphedByMany('App\Project', 'teamable', 'teams')->withPivot('accepted_at', 'rejected_at');
    }

    public function tasks()
    {
        return $this->morphedByMany('App\Task', 'teamable', 'teams');
    }

    public function scopeFindByEmail($query, $email)
    {
        return $query->where('email', $email)->first();
    }
}
