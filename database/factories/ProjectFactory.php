<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->afterCreating(App\Project::class, function ($project, $faker) {
    $project->team()->attach($project->user_id, ['accepted_at' => now()]);
});
