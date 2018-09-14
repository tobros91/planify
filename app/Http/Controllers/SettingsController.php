<?php

namespace App\Http\Controllers;

use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use Log;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = auth()->user();

        return $user;
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'visibility' => 'required|in:public,auth,team'
        ]);

        $user->update($request->only('name', 'email', 'visibility'));
    }


    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image'
        ]);

        $user = auth()->user();

        $upload            = $request->file('file');
        $original_basename = $upload->getClientOriginalName();
        $path              = $upload->store('avatars');

        $file = $user->image()->create([
            'user_id'           => $user->id,
            'path'              => $path,
            'original_basename' => $original_basename,
        ]);

        $file->generateThumbs();

        return $file;
    }
}
