<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Image;

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


    public function avatar(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $full_path = Storage::get($user->image->path);
        $image = Image::cache(function ($image) use ($full_path) {
            $image->make($full_path)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        });

        return response()->streamDownload(function () use ($image) {
            echo $image;
        }, $user->image->filename);
    }
}
