<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {

    $starts_at = $faker->dateTimeThisMonth;
    $ends_at = Carbon\Carbon::instance($starts_at)->addDays($faker->numberBetween(1, 7));

    return [
        'title' => $faker->sentence,
        'user_id' => factory(App\User::class)->create()->id,
        'project_id' => factory(App\Project::class)->create()->id,
        'starts_at' => $starts_at,
        'ends_at' => $ends_at,
    ];
});
