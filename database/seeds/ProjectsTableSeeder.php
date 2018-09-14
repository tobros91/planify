<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Project::class, 4)->create([
            'user_id' => 1,
        ])->each(function ($project) {

            $user1 = $project->team()->save(factory(App\User::class)->make());
            $user2 = $project->team()->save(factory(App\User::class)->make());
            $user3 = $project->team()->save(factory(App\User::class)->make());

            $task1 = $project->tasks()->save(factory(App\Task::class)->make());
            $task2 = $project->tasks()->save(factory(App\Task::class)->make());

            $task1->team()->save($user1);
            $task1->team()->save($user2);


            $task1->comments()->save(factory(App\Comment::class)->make([
                'user_id' => $task1->user_id
            ]));

            $task2->comments()->save(factory(App\Comment::class)->make([
                'user_id' => $task2->user_id
            ]));


            $task2->team()->save($user1);
            $task2->team()->save($user2);
            $task2->team()->save($user3);
        });
    }
}
