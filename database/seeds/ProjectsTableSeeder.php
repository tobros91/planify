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
            $project->tasks()->save(factory(App\Task::class)->make());
            $project->tasks()->save(factory(App\Task::class)->make());
        });
    }
}
