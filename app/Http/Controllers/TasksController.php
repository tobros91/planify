<?php

namespace App\Http\Controllers;

use App\User;
use App\Task;
use App\Project;
use Carbon\Carbon;
use App\Notifications\CommentSubmited;
use App\Http\Requests\TaskStore;
use App\Http\Requests\TaskComment;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(TaskStore $request, Project $project)
    {
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

    public function show($project_id, $task_id)
    {
        $project = Project::thatUserCanAccess()->findOrFail($project_id);

        $task = Task::with('team', 'comments')->findOrFail($task_id);

        return $task;
    }

    public function comment(TaskComment $request, Task $task)
    {
        $comment = $task->comments()->create([
            'body' => $request->input('body'),
            'user_id' => $request->user()->id
        ]);

        foreach ($task->team as $user) {
            if ($request->user()->id !== $user->id) {
                $user->notify(new CommentSubmited($task));
            }
        }

        return $comment;
    }

    public function assign(Request $request, Task $task)
    {
        $user = User::findOrFail($request->input('user_id'));

        $team = $task->assign($user);

        return response($team, 201);
    }

    public function kick(Request $request, Task $task)
    {
        $user = User::findOrFail($request->input('user_id'));

        $task->kick($user);
    }
}
