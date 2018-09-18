<?php

namespace Tests\Feature;

use App\User;
use App\Project;
use App\Task;
use Tests\TestCase;
use App\Notifications\CommentSubmited;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function project_team_members_can_comment_on_tasks()
    {
        $task = factory(Task::class)->create();


        $this->actingAs($task->user);
        $response = $this->json('POST', '/data/projects/'.$task->project->id.'/tasks/'.$task->id.'/comment', [
            'body' => 'test',
        ]);


        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'user_id' => $task->user->id,
            'task_id' => $task->id,
            'body'    => 'test',
        ]);
    }


    /** @test */
    public function only_project_team_members_can_comment_on_tasks()
    {
        $task = factory(Task::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->json('POST', '/data/projects/'.$task->project->id.'/tasks/'.$task->id.'/comment');

        $response->assertStatus(403);
    }


    /** @test */
    public function all_assigned_users_except_poster_should_receive_notifications_on_new_comment()
    {
        Notification::fake();

        $task = factory(Task::class)->create();

        $user2 = factory(User::class)->create();
        $task->team()->save($user2);


        $this->actingAs($task->user);
        $response = $this->json('POST', '/data/projects/'.$task->project->id.'/tasks/'.$task->id.'/comment', [
            'body' => 'test',
        ]);


        Notification::assertNotSentTo(
            [$task->user],
            CommentSubmited::class
        );

        Notification::assertSentTo(
            [$user2],
            CommentSubmited::class
        );
    }
}
