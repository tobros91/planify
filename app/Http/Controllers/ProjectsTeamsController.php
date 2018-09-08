<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\Project;
use App\Http\Requests\ProjectInviteUser;
use App\Http\Requests\ProjectKickUser;

use Log;

class ProjectsTeamsController extends Controller
{
    public function store(Project $project, ProjectInviteUser $request)
    {
        $user = User::findByEmail($request->input('email'));

        $team = $project->invite($user);

        return response($team, 201);
    }


    public function destroy(Project $project, $user_id, ProjectKickUser $request)
    {
        $user = User::findOrFail($user_id);

        $project->kick($user);
    }
}
