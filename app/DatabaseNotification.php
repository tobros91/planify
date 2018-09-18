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
        if (method_exists($this->type, 'fromDatabase')) {
            return $this->type::fromDatabase($this->notifiable_id, json_decode($data));
        }
        return $data;
    }
}
