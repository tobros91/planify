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

            $user = $project->team()->save(factory(App\User::class)->make());

            $task = $project->tasks()->save(factory(App\Task::class)->create([
                'project_id' => $project->id,
                'user_id' => $user->id
            ]));
        });
    }
}
