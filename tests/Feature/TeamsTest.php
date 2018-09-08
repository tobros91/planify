<?php

namespace Tests\Feature;

use App\User;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function project_owner_can_invite_users()
    {
        // Given
        $user1 = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $user1->id
        ]);

        $user2 = factory(User::class)->create([
            'email' => 'invitemepls@example.com'
        ]);
        // When
        $this->actingAs($user1);

        $response = $this->json('POST', '/data/projects/'.$project->id.'/teams', [
            'email' => 'invitemepls@example.com'
        ]);

        // Then
        $response->assertStatus(201);

        $this->assertDatabaseHas('teams', [
            'user_id' => $user2->id,
            'teamable_id' => $project->id,
            'teamable_type' => 'App\Project'
        ]);
    }

    /** @test */
    public function project_owner_can_kick_users()
    {
       // Given
        $user1 = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $user1->id
        ]);

        $user2 = factory(User::class)->create();
        $project->team()->save($user2);

        // When
        $this->actingAs($user1);

        $response = $this->delete('/data/projects/'.$project->id.'/teams/'.$user2->id);

        // Then
        $response->assertStatus(200);

        $this->assertDatabaseMissing('teams', [
            'user_id' => $user2->id,
            'teamable_id' => $project->id,
            'teamable_type' => 'App\Project'
        ]);
    }
}
