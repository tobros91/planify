<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return [
            'projects' => Auth::user()->projects
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $project = Project::create([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'user_id'     => $request->user()->id
        ]);

        $project->team()->attach($project->user_id, ['accepted_at' => now()]);

        return $project;
    }

    public function show($project_id)
    {
        $project = Project::with(['tasks.team', 'team.tasks' => function ($query) use ($project_id) {
            $query->where('project_id', $project_id);
        }])
        ->thatUserCanAccess()
        ->findOrFail($project_id);

        $user = $project->team()->where('user_id', auth()->user()->id)->first();

        return [
            'project' => $project,
            'user' => $user,
        ];
    }

    public function edit(Project $project)
    {
        //
    }

    public function update(Request $request, Project $project)
    {
        //
    }

    public function destroy(Project $project)
    {
        //
    }
}
