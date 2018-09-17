<?php

namespace Tests\Feature;

use App\User;
use App\Project;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_store_a_task()
    {
        // Given
        $user = factory(User::class)->create();

        $project = factory(Project::class)->create([
            'user_id' => $user->id
        ]);

        // When
        $this->actingAs($user);

        $starts_at = Carbon::now()->toDateTimeString();
        $ends_at = Carbon::parse($starts_at)->addDays(5)->toDateTimeString();

        $response = $this->json('POST', '/data/projects/'.$project->id.'/tasks', [
            'title' => 'Task 1',
            'comment' => 'test',
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
        ]);


        // Then
        $response->assertStatus(201)
                 ->assertJson([
                    'title' => 'Task 1',
                    'starts_at' => $starts_at,
                    'ends_at' => $ends_at,
                 ]);
    }
}
