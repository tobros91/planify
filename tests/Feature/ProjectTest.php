<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_list_projects()
    {
        // Given
        $user = factory(User::class)->create();

        // When
        $project = factory(Project::class)->create([
            'title' => 'Project 1',
            'user_id' => $user->id
        ]);

        $project = factory(Project::class)->create([
            'title' => 'Project 2',
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        // Then
        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertSee('Project 1');
        $response->assertSee('Project 2');
    }


    /** @test */
    public function user_can_view_a_single_project()
    {
        // Given
        $user = factory(User::class)->create();

        // When
        $project = factory(Project::class)->create([
            'title' => 'Project 1',
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        // Then
        $response = $this->get(route('projects.show', ['project_id' => $project->id]));

        $response->assertStatus(200);
        $response->assertSee('Project 1');
    }



    /** @test */
    public function user_can_store_project()
    {
        // Given
        $user = factory(User::class)->create();

        // When
        $this->actingAs($user);

        $response = $this->json('POST', '/data/projects', [
            'title' => 'Project 1',
            'description' => 'test'
        ]);

        // Then
        $response->assertStatus(201)
                 ->assertJson([
                    'title' => 'Project 1',
                 ]);
    }
}
