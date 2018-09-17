<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification as Model;

class DatabaseNotification extends Model
{
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function getDataAttribute($data)
    {
        return $this->type::toFrontEnd($this->notifiable_id, json_decode($data));
    }
}
