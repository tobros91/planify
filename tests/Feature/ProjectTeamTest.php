<?php

namespace Tests\Feature;

use App\User;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_project_owner_can_invite_or_kick_team_members()
    {
        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();


        $this->actingAs($user);
        $inviteResponse = $this->json('POST', '/data/projects/'.$project->id.'/invite', [
            'email' => 'invitemepls@example.com'
        ]);
        $kickResponse = $this->json('POST', '/data/projects/'.$project->id.'/kick', [
            'email' => 'invitemepls@example.com'
        ]);


        $inviteResponse->assertStatus(403);
        $kickResponse->assertStatus(403);
    }

    /** @test */
    public function project_owner_can_invite_users()
    {
        $project = factory(Project::class)->create();
        $user2 = factory(User::class)->create([
            'email' => 'invitemepls@example.com'
        ]);


        $this->actingAs($project->user);
        $response = $this->json('POST', '/data/projects/'.$project->id.'/invite', [
            'email' => 'invitemepls@example.com',
            'message' => 'Come to the dark side, we have cookies.'
        ]);


        $response->assertStatus(201);
        $this->assertDatabaseHas('teams', [
            'user_id'       => $user2->id,
            'teamable_id'   => $project->id,
            'teamable_type' => 'App\Project',
            'message'       => 'Come to the dark side, we have cookies.'
        ]);
    }

    /** @test */
    public function user_can_not_get_invited_twice()
    {
        $project = factory(Project::class)->create();
        $user2 = factory(User::class)->create([
            'email' => 'invitemepls@example.com'
        ]);
        $project->team()->save($user2);


        $this->actingAs($project->user);
        $response = $this->json('POST', '/data/projects/'.$project->id.'/invite', [
            'email' => 'invitemepls@example.com',
            'message' => 'Come to the dark side, we have cookies.'
        ]);


        $response->assertStatus(422);
    }

    /** @test */
    public function project_owner_can_kick_users()
    {
        $project = factory(Project::class)->create();
        $user2 = factory(User::class)->create();
        $project->team()->save($user2);


        $this->actingAs($project->user);
        $response = $this->json('POST', '/data/projects/'.$project->id.'/kick', [
            'user_id' => $user2->id,
        ]);


        $response->assertStatus(200);
        $this->assertDatabaseMissing('teams', [
            'user_id'       => $user2->id,
            'teamable_id'   => $project->id,
            'teamable_type' => 'App\Project'
        ]);
    }
}
