<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($user_id = null)
    {
        if ($user_id === null && auth()->check()) {
            return [
                'user' => auth()->user()
            ];
        }

        $user = User::findOrFail($user_id);
        $jointProjects = auth()->check() ? auth()->user()->jointProjectsWith($user) : [];

        if (($user->visibility === 'auth' || $user->visibility === 'team') && !auth()->check()) {
            return 'hidden';
        }

        if ($user->visibility === 'team' && count($jointProjects) === 0) {
            return 'only for team';
        }

        return [
            'user' => $user,
            'jointProjects' => $jointProjects,
        ];
    }
}
