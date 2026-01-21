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
            'status' => ['required', Rule::in(['active', 'pending'])],
            'class_room_id' => ['nullable', 'exists:class_rooms,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed', 'required_with:password_confirmation'],
            'password_confirmation' => ['nullable', 'string', 'min:8', 'required_with:password'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $role = $this->input('role');
            $status = $this->input('status');

            if ($role === 'student' && $status === 'active' && empty($this->input('class_room_id'))) {
                $validator->errors()->add('class_room_id', __('Active students must be assigned to a class.'));
            }
        });
    }
}
