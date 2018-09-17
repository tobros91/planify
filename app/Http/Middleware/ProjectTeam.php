<?php

namespace App\Http\Middleware;

use Closure;

class ProjectTeam
{
    public function handle($request, Closure $next)
    {
        $project = $request->route('project');

        if ($project && $project->userCanAccess() === true) {
            return $next($request);
        }

        return abort(403);
    }
}
