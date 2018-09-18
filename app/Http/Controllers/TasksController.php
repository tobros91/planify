<?php

namespace App\Http\Controllers;

use App\User;
use App\Task;
use App\Project;
use Carbon\Carbon;
use App\Notifications\CommentSubmited;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('project.team');
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'starts_at' => 'date',
            'ends_at' => 'date',
        ]);

        $task = $project->tasks()->create([
            'user_id'     => $request->user()->id,
            'title'       => $request->input('title'),
            'starts_at'   => Carbon::parse($request->input('starts_at'))->toDateTimeString(),
            'ends_at'     => Carbon::parse($request->input('ends_at'))->toDateTimeString(),
        ]);

        $task->comments()->create([
            'body' => $request->input('comment'),
            'user_id' => $request->user()->id
        ]);

        return $task;
    }

    public function show(Project $project, Task $task)
    {
        $task->load('team', 'comments');

        return $task;
    }

    public function comment(Request $request, Project $project, Task $task)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        $comment = $task->comments()->create([
            'body' => $request->input('body'),
            'user_id' => $request->user()->id
        ]);

        foreach ($task->team as $user) {
            if ($request->user()->id !== $user->id) {
                $user->notify(new CommentSubmited($task, $comment, auth()->user()));
            }
        }

        return $comment;
    }

    public function assign(Request $request, Project $project, Task $task)
    {
        $user = User::findOrFail($request->input('user_id'));

        $team = $task->assign($user);

        return response($team, 201);
    }

    public function kick(Request $request, Project $project, Task $task)
    {
        $user = User::findOrFail($request->input('user_id'));

        $task->kick($user);
    }
}
