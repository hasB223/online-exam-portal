<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('user')->id),
            ],
            'role' => ['required', Rule::in(['admin', 'lecturer', 'student'])],
            'class_room_id' => ['nullable', 'exists:class_rooms,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
