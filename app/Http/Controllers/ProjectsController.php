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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $project = $request->user()->projects()->create($request->only('title', 'description'));
        return $project;
    }

    public function show($project_id)
    {
        $project = Project::with(['tasks.team', 'team.tasks' => function ($query) use ($project_id) {
            $query->where('project_id', $project_id);
        }])
        ->findOrFail($project_id);

        return [
            'project' => $project
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
