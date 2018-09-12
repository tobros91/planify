<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInviteUser;
use App\Http\Requests\ProjectKickUser;
use App\Project;
use App\Team;
use App\User;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ProjectsTeamsController extends Controller
{
    public function store(Project $project, ProjectInviteUser $request)
    {
        $user = User::findByEmail($request->input('email'));

        $team = $project->invite($user);

        return response($team, 201);
    }

    public function respond(Project $project, Request $request)
    {
        $column = $request->input('action') == 'accept' ? 'accepted_at' : 'rejected_at';

        $request->user()->projects()->updateExistingPivot($project->id, [
            $column => now()
        ]);

        $request->user()->notifications()->update(['action_at' => now()]);
    }


    public function destroy(Project $project, $user_id, ProjectKickUser $request)
    {
        $user = User::findOrFail($user_id);

        $project->kick($user);
    }
}
