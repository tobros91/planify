<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'user_id' =>  function () {
            return factory(App\User::class)->create()->id;
        },
        'task_id' => function () {
            return factory(App\Task::class)->create()->id;
        }
    ];
});
