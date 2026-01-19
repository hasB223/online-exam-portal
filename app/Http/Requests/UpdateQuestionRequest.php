<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() || $this->user()?->isLecturer();
    }

    public function rules(): array
    {
        return [
            'prompt' => ['required', 'string'],
            'options' => ['required', 'array', 'size:4'],
            'options.*' => ['required', 'string', 'max:255'],
            'correct_option' => ['required', 'integer', 'min:0', 'max:3'],
            'points' => ['required', 'integer', 'min:1'],
        ];
    }
}
