<?php

namespace App\Http\Middleware;

use Closure;

class ProjectOwner
{
    public function handle($request, Closure $next)
    {
        $project = $request->route('project');

        if ($project && $project->user_id == $request->user()->id) {
            return $next($request);
        }

        return abort(403);
    }
}
