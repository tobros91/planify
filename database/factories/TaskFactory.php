<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {

    $starts_at = $faker->dateTimeThisMonth;
    $ends_at = Carbon\Carbon::instance($starts_at)->addDays($faker->numberBetween(1, 7));

    return [
        'title' => $faker->sentence,
        'project_id' => function () {
            return  factory(App\Project::class)->create()->id;
        },
        'user_id' => function (array $post) {
            return App\Project::find($post['project_id'])->user_id;
        },
        'starts_at' => $starts_at,
        'ends_at' => $ends_at,
    ];
});

$factory->afterCreating(App\Task::class, function ($task, $faker) {
    if ($task->project->team()->find($task->user_id) == null) {
        $task->project->team()->attach($task->user_id, ['accepted_at' => now()]);
    }
    $task->team()->attach($task->user_id, ['accepted_at' => now()]);
    $task->comments()->save(factory(App\Comment::class)->make([
        'user_id' => $task->user_id,
        'task_id' => $task->id,
    ]));
});
