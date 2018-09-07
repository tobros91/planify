<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Carbon\Carbon;
use App\Http\Requests\StoreTask;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(StoreTask $request, Project $project)
    {
        $task = $project->tasks()->create([
            'user_id'     => $request->user()->id,
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'starts_at'   => Carbon::parse($request->input('starts_at'))->toDateTimeString(),
            'ends_at'     => Carbon::parse($request->input('ends_at'))->toDateTimeString(),
        ]);
        return $task;
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function edit(Task $task)
    {
        //
    }

    public function update(Request $request, Task $task)
    {
        //
    }

    public function destroy(Task $task)
    {
        //
    }
}
