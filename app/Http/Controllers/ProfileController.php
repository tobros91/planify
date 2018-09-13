<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($user_id = null)
    {
        if ($user_id === null && auth()->check()) {
            $user_id = auth()->user()->id;
        }

        $user = User::findOrFail($user_id);

        if (($user->visibility === 'auth' || $user->visibility === 'team') && !auth()->check()) {
            return 'hidden';
        }

        if ($user->visibility === 'team' && count($user->sharedProjectsWith(auth()->user())) === 0) {
            return 'only for team';
        }

        return $user;
    }
}
