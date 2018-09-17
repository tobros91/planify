<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class ProjectInviteUser extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $project_id = $this->route('project')->id;

        return [
            'email' => [
                'required',
                'email',
                'exists:users',
                function ($attribute, $value, $fail) use ($project_id) {

                    $user = User::where('email', $value)
                            ->whereHas('projects', function ($query) use ($project_id) {
                                $query->where('teamable_id', $project_id);
                            })
                            ->first();

                    if ($user !== null) {
                        $fail('The user is already invited to this project');
                    }
                },
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'No user with this email',
        ];
    }
}
