<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;

use Log;

class ProjectInviteUser extends FormRequest
{

    public function authorize()
    {
        $project = $this->route('project');
        return $project && $this->user()->id == $project->user_id;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users'
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'No user with this email',
        ];
    }
}
