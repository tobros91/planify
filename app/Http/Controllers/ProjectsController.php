<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectInviteUser;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('project.owner')->only('invite', 'kick');

        $this->middleware('project.team')->only('show', 'respondToInvitation');
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

    public function show(Project $project)
    {
        $project = Project::with(['tasks.team', 'team.tasks' => function ($query) use ($project) {
            $query->where('project_id', $project->id);
        }])
        ->thatUserCanAccess()
        ->find($project->id);

        $user = $project->team()->where('user_id', auth()->user()->id)->first();

        return [
            'project' => $project,
            'user' => $user,
        ];
    }


    public function invite(ProjectInviteUser $request, Project $project)
    {
        $user = User::findByEmail($request->input('email'));

        $team = $project->invite($user, $request->input('message'));

        return response($team, 201);
    }


    public function kick(Request $request, Project $project)
    {
        $user = User::findOrFail($request->input('user_id'));

        $project->kick($user);
    }

    public function respondToInvitation(Request $request, Project $project)
    {
        $column = $request->input('action') == 'accept' ? 'accepted_at' : 'rejected_at';

        $request->user()->projects()->updateExistingPivot($project->id, [
            $column => now()
        ]);
    }
}
