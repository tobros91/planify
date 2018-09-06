<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'user_id' => factory(App\User::class)->create()->id,
        'project_id' => factory(App\Project::class)->create()->id,
    ];
});
