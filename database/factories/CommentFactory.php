<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'user_id' => factory(App\User::class)->create()->id,
        'task_id' => factory(App\Task::class)->create()->id
    ];
});
