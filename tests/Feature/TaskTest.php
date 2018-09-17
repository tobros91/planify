<?php

namespace Tests\Feature;

use App\User;
use App\Project;
use App\Task;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function project_team_members_can_store_tasks()
    {
        // Given
        $project = factory(Project::class)->create();

        // When
        $this->actingAs($project->user);

        $starts_at = Carbon::now()->toDateTimeString();
        $ends_at = Carbon::parse($starts_at)->addDays(5)->toDateTimeString();

        $response = $this->json('POST', '/data/projects/'.$project->id.'/tasks', [
            'title' => 'Task 1',
            'comment' => 'test',
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
        ]);

        // Then
        $response->assertStatus(201);
    }

    public function only_project_team_members_can_store_tasks()
    {
        // Given
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();
        // When
        $this->actingAs($user);

        $response = $this->json('POST', '/data/projects/'.$project->id.'/tasks');

        // Then
        $response->assertStatus(403);
    }

}
